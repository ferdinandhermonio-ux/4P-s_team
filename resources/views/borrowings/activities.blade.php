<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('System Activity Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6">
                        <form method="GET" action="{{ route('borrowings.activities') }}" class="flex items-center gap-4">
                            <x-text-input name="search" placeholder="Search activity..." value="{{ request('search') }}" class="w-full max-w-sm" />
                            <x-primary-button>Search</x-primary-button>
                            @if(request('search'))
                                <a href="{{ route('borrowings.activities') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Clear</a>
                            @endif
                        </form>
                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">User</th>
                                    <th class="px-6 py-3">Action</th>
                                    <th class="px-6 py-3">Description</th>
                                    <th class="px-6 py-3">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activities as $activity)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $activity->user->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 rounded text-xs font-bold uppercase
                                                {{ $activity->action === 'borrow' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ $activity->action === 'return' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $activity->action === 'create' ? 'bg-purple-100 text-purple-700' : '' }}
                                                {{ $activity->action === 'delete' ? 'bg-red-100 text-red-700' : '' }}">
                                                {{ $activity->action }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $activity->description }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $activity->created_at->format('Y-m-d H:i:s') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center">No activities recorded.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $activities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
