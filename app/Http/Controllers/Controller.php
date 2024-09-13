<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

abstract class Controller
{
    // Function to get synonyms using Guzzle
    public function getSynonyms($word, $user)
    {
        $client = new Client();

        // URL-encode the word to handle spaces and special characters
        $encodedWord = urlencode($word);

        $response = $client->request('GET', 'https://wordsapiv1.p.rapidapi.com/words/' . $encodedWord . '/synonyms', [
            'headers' => [
                'x-rapidapi-host' => 'wordsapiv1.p.rapidapi.com',
                'x-rapidapi-key' => env('RAPIDAPI_KEY'), // Store your API key in .env
            ],
        ]);

        // Decode the response
        $synonyms = json_decode($response->getBody()->getContents(), true);
        $user->self_define_word_synonyms =  $synonyms;
        $user->save();
    }
}
