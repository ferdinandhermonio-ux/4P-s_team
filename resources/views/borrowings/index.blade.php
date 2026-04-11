<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Librarian Reports - Borrowed & Overdue Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                        <form method="GET" action="{{ route('borrowings.index') }}" class="flex flex-wrap items-center gap-4">
                            <div>
                                <select name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">All Statuses</option>
                                    <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                                </select>
                            </div>
                            <div>
                                <x-text-input name="search" placeholder="Search user or book..." value="{{ request('search') }}" />
                            </div>
                            <x-primary-button>Filter</x-primary-button>
                            @if(request()->anyFilled(['status', 'search']))
                                <a href="{{ route('borrowings.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Clear Filters</a>
                            @endif
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrowed At</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($borrowings as $borrowing)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $borrowing->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $borrowing->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $borrowing->book->title }}</div>
                                            <div class="text-sm text-gray-500">ISBN: {{ $borrowing->book->isbn }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $borrowing->borrowed_at->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $borrowing->due_date->format('Y-m-d') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $borrowing->status === 'borrowed' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $borrowing->status === 'overdue' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $borrowing->status === 'returned' ? 'bg-green-100 text-green-800' : '' }}">
                                                {{ ucfirst($borrowing->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($borrowing->status !== 'returned')
                                                <form method="POST" action="{{ route('borrowings.return', $borrowing) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900" onclick="return confirm('Confirm return?')">Mark Returned</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400">Returned on {{ $borrowing->returned_at->format('Y-m-d') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No borrowing records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $borrowings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
