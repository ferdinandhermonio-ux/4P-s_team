<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Borrowings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrowed At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($borrowings as $borrowing)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $borrowing->book->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $borrowing->borrowed_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $borrowing->due_date->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $borrowing->status == 'returned' ? 'bg-green-100 text-green-800' : 
                                           ($borrowing->status == 'overdue' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ ucfirst($borrowing->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($borrowing->status != 'returned')
                                    <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 bg-green-50 px-3 py-1 rounded">Return Book</button>
                                    </form>
                                    @else
                                        <span class="text-gray-400">Returned on {{ $borrowing->returned_at->format('Y-m-d') }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $borrowings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>