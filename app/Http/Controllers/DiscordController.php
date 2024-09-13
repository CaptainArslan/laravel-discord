<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class DiscordController extends Controller
{
    public function redirectToDiscord()
    {
        return Socialite::driver('discord')->redirect();
    }

    public function handleDiscordCallback()
    {
        try {
            $discordUser = Socialite::driver('discord')->user();
            $token = $discordUser->token;

            // Fetch user data from Discord
            $client = new Client();
            $response = $client->request('GET', 'https://discord.com/api/v10/users/@me', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);
            $userData = json_decode($response->getBody(), true);

            // Fetch guilds data from Discord
            $responseGuilds = $client->request('GET', 'https://discord.com/api/v10/users/@me/guilds', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);
            $guildsData = json_decode($responseGuilds->getBody(), true);

            // Store or update user in the database
            $user = User::updateOrCreate(
                ['discord_id' => $userData['id']],
                [
                    'discord_username' => $userData['username'],
                    'discord_avatar' => $userData['avatar'],
                    'discord_token' => $token,
                    'discord_refresh_token' => $discordUser->refreshToken,
                    'discord_token_expires' => date('Y-m-d H:i:s', time() + $discordUser->expiresIn),
                ]
            );

            Auth::login($user);

            // Pass user data and guilds to the view
            return view('discord.profile', [
                'username' => $userData['username'],
                'avatar' => $userData['avatar'],
                'guilds' => $guildsData,
            ]);
        } catch (\Exception $e) {
            return redirect('/')->withErrors('Unable to authenticate with Discord.');
        }
    }

    public function profile()
    {
        return view('discord.profile');
    }
}
