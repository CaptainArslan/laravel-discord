<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Discord Intrgation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($user->discord_id)
                        <!-- User is connected with Discord -->
                        <div class="space-y-4">
                            <p class="text-lg font-semibold ">
                                {{ $user->name }}! {{ __('We are happy to see you again :)') }}
                            </p>
                            <div class="discord-info py-10">
                                <p>
                                    <img src="https://cdn.discordapp.com/avatars/{{ $user->discord_id }}/{{ $user->discord_avatar }}.png"
                                        alt="Avatar" class="w-24 h-24 rounded-full border border-gray-300">
                                </p>
                                <p class="text-md">{{ __('Your Discord username:') }} <span
                                        class="font-bold">{{ $user->discord_username }}</span></p>
                                <h2 class="text-lg font-semibold mt-4">{{ __('Connected Servers') }}</h2>
                                {{-- <ul class="list-disc pl-5 space-y-2">
                                    @foreach ($guildsData as $guild)
                                        <li class="text-md">{{ $guild['name'] }}</li>
                                    @endforeach
                                </ul> --}}
                                <div class="container mx-auto px-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                        @foreach ($guildsData as $guild)
                                            <div
                                                class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform transform hover:scale-105">
                                                <div class="flex justify-center p-4 bg-gray-100">
                                                    <!-- Guild Icon or Fallback Image -->
                                                    <img class="w-40 h-40 object-cover rounded-full"
                                                        src="{{ $guild['icon'] ? 'https://cdn.discordapp.com/icons/' . $guild['id'] . '/' . $guild['icon'] . '.png' : 'https://placehold.co/200x200?text=Server' }}"
                                                        alt="{{ $guild['name'] }}">
                                                </div>
                                                <div class="p-4 text-center">
                                                    <!-- Guild Name -->
                                                    <h3 class="text-lg font-semibold text-gray-900 truncate">
                                                        {{ $guild['name'] }}</h3>
                                                    <!-- Optional: Show member count or other info -->
                                                    <p class="text-sm text-gray-600 mt-2">
                                                        {{ $guild['member_count'] ?? 'N/A' }} members
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center space-y-4">
                            <p class="text-lg font-semibold">{{ __('You are not connected with Discord.') }}</p>
                            <div class="mt-6">
                                <a href="{{ route('auth.discord') }}">
                                    <x-primary-button class="bg-[#5865F2]">
                                        {{ __('Connect with Discord') }}
                                    </x-primary-button>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
