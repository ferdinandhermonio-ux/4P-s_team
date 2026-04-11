<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Borrowings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-0 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Book Details</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Timeline</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse($borrowings as $borrowing)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $borrowing->book->title }}</div>
                                    <div class="text-xs text-gray-500 font-mono">ISBN: {{ $borrowing->book->isbn }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex flex-col">
                                        <span class="text-gray-600">Borrowed: <span class="font-medium">{{ $borrowing->borrowed_at->format('M d, Y') }}</span></span>
                                        <span class="text-gray-600">Due: <span class="font-medium">{{ $borrowing->due_date->format('M d, Y') }}</span></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase
                                        {{ $borrowing->status == 'returned' ? 'bg-green-100 text-green-700' : 
                                           ($borrowing->status == 'overdue' ? 'bg-red-100 text-red-700 animate-pulse' : 'bg-blue-100 text-blue-700') }}">
                                        {{ $borrowing->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap text-sm font-medium">
                                    @if($borrowing->status != 'returned')
                                    <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm" onclick="return confirm('Ready to return this book?')">Return Book</button>
                                    </form>
                                    @else
                                        <div class="text-xs text-gray-400 italic">
                                            Returned on {{ $borrowing->returned_at->format('M d, Y') }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="text-gray-400 italic">You haven't borrowed any books yet.</div>
                                    <a href="{{ route('books.index') }}" class="text-indigo-600 font-bold underline mt-2 inline-block">Explore Library</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        {{ $borrowings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>