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
    <ul>
        @foreach ($guilds as $guild)
            <li>{{ $guild['name'] }}</li>
        @endforeach
    </ul>
</body>

</html>
