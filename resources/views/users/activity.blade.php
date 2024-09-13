<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users Activity Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Check if there are any activities -->
                    @if ($activities->count())
                        <table class="min-w-full table-auto divide-y divide-gray-200 w-full">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">
                                        User
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">
                                        Subject Type & ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($activities as $activity)
                                    <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}"> <!-- Apply striped rows -->
                                        <!-- User Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $activity->causer ? $activity->causer->name : 'System' }}
                                        </td>

                                        <!-- Description Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ ucfirst($activity->description) }}
                                        </td>

                                        <!-- Subject Type & ID Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $activity->subject_type }} #{{ $activity->subject_id }}
                                        </td>

                                        <!-- Date Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $activity->created_at->format('Y-m-d H:i:s') }}
                                        </td>

                                        <!-- Actions Column (optional, could include a view or delete option) -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <!-- Optionally add Delete if needed, wrapped with a form -->
                                                @can('delete activity')
                                                    <form method="POST"
                                                        action="{{ route('activity.destroy', $activity->id) }}"
                                                        onsubmit="return confirm('Are you sure you want to delete this activity log?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900">Delete</button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $activities->links() }} <!-- Ensure pagination links are displayed -->
                        </div>
                    @else
                        <!-- Message when no logs are found -->
                        <p class="text-gray-600">{{ __('No activity logs available.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
