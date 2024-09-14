<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class DiscordController extends Controller
{

    public function connect()
    {
        $user = Auth::user();
        $guildsData = json_decode($user->discord_guilds, true);
        return view('discord.connect', get_defined_vars());
    }

    public function redirectToDiscord()
    {
        return Socialite::driver('discord')
            ->scopes(['identify', 'guilds']) // Adding 'guilds' scope here
            ->redirect();
    }


    public function handleProviderCallback()
    {
        try {
            $discordUser = Socialite::driver('discord')->user();
            $token = $discordUser->token;

            // Fetch user data from Discord
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://discord.com/api/v10/users/@me', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);
            $userData = json_decode($response->getBody(), true);

            // // Fetch guilds data from Discord
            $responseGuilds = $client->request('GET', 'https://discord.com/api/v10/users/@me/guilds', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);
            $guildsData = json_decode($responseGuilds->getBody(), true);

            // Store or update user in the database
            $user = Auth::user();
            $user->discord_data = json_encode(['information' =>  $userData, 'servers' => $guildsData]);
            $user->discord_username = $userData['username'];
            $user->discord_avatar = $userData['avatar'];
            $user->discord_id = $userData['id'];
            $user->discord_token = $token;
            $user->discord_refresh_token = $discordUser->refreshToken;
            $user->discord_token_expires = now()->addSeconds($discordUser->expiresIn);
            $user->discord_guilds = json_encode($guildsData);
            $user->save();

            return view('discord.connect', get_defined_vars());
        } catch (\Exception $e) {
            return to_route('discord.connect')->withErrors('Unable to authenticate with Discord: ' . $e->getMessage());
        }
    }


    public function profile()
    {
        return view('discord.profile');
    }
}
