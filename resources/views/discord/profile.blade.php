<!-- resources/views/discord/profile.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discord Profile</title>
    <style>
        .avatar {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body>
    <h1>Welcome, {{ $username }}</h1>
    <img src="https://cdn.discordapp.com/avatars/{{ Auth::user()->discord_id }}/{{ $avatar }}.png" alt="Avatar"
        class="avatar">

    <h2>Servers:</h2>
    {{-- <ul>
        @foreach ($guilds as $guild)
            <li>{{ $guild['name'] }}</li>
        @endforeach
    </ul> --}}
</body>

</html>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Discord Profile') }}
        </h2>
    </x-slot>


    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold text-gray-800 leading-tight">{{ __('Your Entered Keywords') }}
                        "{{ Str::ucfirst(Auth::user()->discord_username) }}"
                    </h2>
                    <img src="https://cdn.discordapp.com/avatars/{{ Auth::user()->discord_id }}/{{ $avatar }}.png"
                        alt="Avatar" class="avatar">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
