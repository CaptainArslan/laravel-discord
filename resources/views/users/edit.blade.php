<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update User: ' . $user->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('Update User') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600">
                                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                                </p>
                            </header>

                            <form method="post" action="{{ route('users.update', $user->id) }}" class="mt-6 space-y-6">
                                @csrf
                                @method('put')

                                <!-- Grid Layout for Form Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Name -->
                                    <div>
                                        <x-input-label for="name" :value="__('Name')" />
                                        <x-text-input id="name" name="name" type="text"
                                            value="{{ old('name', $user->name) }}" class="mt-1 block w-full" />
                                        <x-input-error :messages="$errors->updateUser->get('name')" class="mt-2" />
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" name="email" type="email"
                                            value="{{ old('email', $user->email) }}" class="mt-1 block w-full" />
                                        <x-input-error :messages="$errors->updateUser->get('email')" class="mt-2" />
                                    </div>

                                    <!-- self_define_word -->
                                    <div>
                                        <x-input-label for="word" :value="__('Self descriptive word')" />
                                        <x-text-input id="word" name="self_define_word" type="text"
                                            value="{{ old('word', $user->self_define_word) }}"
                                            class="mt-1 block w-full" />
                                        <x-input-error :messages="$errors->updateUser->get('word')" class="mt-2" />
                                    </div>

                                    <!-- Role -->
                                    <div class="md:col-span-2">
                                        <x-input-label for="roles" :value="__('Roles')" />
                                        <select id="roles" name="roles[]"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ ucfirst($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->updateUser->get('roles')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                                    @if (session('status') === 'user-updated')
                                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                                    @endif
                                </div>
                            </form>

                        </section>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
