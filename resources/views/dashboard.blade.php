<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ $user->name }}! {{ __('We are happy to see you again :)') }}
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold text-gray-800 leading-tight">{{ __('Your Entered Keywords') }}
                        "{{ $user->self_define_word }}"
                    </h2>

                    <h3 class="py-3 text-2xl font-semibold text-gray-800 leading-tight">{{ __('Synonyms :') }}</h3>
                    @if ($user->self_define_word_synonyms)
                        @php
                            $synonymsData = json_decode($user->self_define_word_synonyms, true);

                            // Check if the 'synonyms' key exists and access it
                            if (isset($synonymsData['synonyms'])) {
                                $synonyms = $synonymsData['synonyms']; // This will be an array of synonyms
                            } else {
                                $synonyms = []; // Fallback if 'synonyms' key is not found
                            }
                        @endphp

                        @if (!empty($synonyms))
                            <p class="text-gray-800">
                                {{ implode(', ', $synonyms) }} <!-- Display the synonyms as comma-separated -->
                            </p>
                        @else
                            <p class="text-gray-500">No synonyms available.</p>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
