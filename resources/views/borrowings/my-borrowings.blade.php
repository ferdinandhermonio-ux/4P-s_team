<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Library History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-md" role="alert">
                    <p class="font-bold">Success</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-md" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    @if($borrowings->isEmpty())
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4 opacity-20">📚</div>
                            <h3 class="text-xl font-medium text-gray-500">You haven't borrowed any books yet.</h3>
                            <a href="{{ route('books.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-900 font-semibold underline">Explore the catalog</a>
                        </div>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-widest bg-gray-50">
                                    <th class="px-6 py-4">Book Information</th>
                                    <th class="px-6 py-4">Borrow Date</th>
                                    <th class="px-6 py-4">Due Date / Status</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($borrowings as $borrowing)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $borrowing->book->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $borrowing->book->author }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        {{ $borrowing->borrowed_at->toFormattedDateString() }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($borrowing->status == 'returned')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Returned ({{ $borrowing->returned_at->format('M d, Y') }})
                                            </span>
                                        @else
                                            @php
                                                $daysLeft = now()->diffInDays($borrowing->due_date, false);
                                                $urgencyClass = $daysLeft < 0 ? 'bg-red-100 text-red-800' : ($daysLeft <= 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800');
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $urgencyClass }}">
                                                @if($daysLeft < 0)
                                                    Overdue by {{ abs($daysLeft) }} days
                                                @else
                                                    Due in {{ $daysLeft }} days
                                                @endif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($borrowing->status != 'returned')
                                            <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" onsubmit="return confirm('Ready to return this book?')">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                                                    Return Book
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs italic">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-6 border-t pt-4">
                            {{ $borrowings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>