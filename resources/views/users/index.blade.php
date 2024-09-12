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
                    <table class="min-w-full table-auto divide-y divide-gray-200 w-full">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">
                                    Roles
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}"> <!-- Apply striped rows -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @foreach ($user->getRoleNames() as $role)
                                            <span
                                                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                                                {{ $role }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <!-- Flexbox for horizontal alignment with spacing -->
                                            <!-- Edit Button -->
                                            @can('edit user')
                                                <a href="{{ route('users.edit', $user->id) }}">
                                                    <x-primary-button>
                                                        {{ __('Edit') }}
                                                    </x-primary-button>
                                                </a>
                                            @endcan

                                            @can('delete user')
                                                <div class="space-x-2">
                                                    <!-- Delete Form -->
                                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                                                        onsubmit="return confirm('Are you sure you want to delete this user?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')

                                                        <!-- Delete Button -->
                                                        <x-danger-button>
                                                            {{ __('Delete') }}
                                                        </x-danger-button>
                                                    </form>
                                                </div>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="pagination mt-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
