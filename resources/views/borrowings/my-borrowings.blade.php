<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="app-title" style="font-family: 'Plus Jakarta Sans', sans-serif;">My Borrowings</h2>
            <p class="app-subtitle">Track your borrowed books and due dates.</p>
        </div>
    </x-slot>

    <div class="app-container pt-6">
        <section class="app-card p-0 fade-up">
            <div class="table-wrap">
                <table class="table-ui min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Timeline</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($borrowings as $borrowing)
                            <tr>
                                <td>
                                    <p class="font-semibold text-slate-900">{{ $borrowing->book->title }}</p>
                                    <p class="text-xs font-mono text-slate-500">ISBN: {{ $borrowing->book->isbn }}</p>
                                </td>
                                <td class="text-sm text-slate-600">
                                    <p>Borrowed: <span class="font-semibold">{{ $borrowing->borrowed_at->format('M d, Y') }}</span></p>
                                    <p>Due: <span class="font-semibold">{{ $borrowing->due_date->format('M d, Y') }}</span></p>
                                </td>
                                <td>
                                    @if($borrowing->status == 'returned')
                                        <span class="badge badge-success">Returned</span>
                                    @elseif($borrowing->status == 'overdue')
                                        <span class="badge badge-danger">Overdue</span>
                                    @else
                                        <span class="badge badge-brand">Borrowed</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex justify-end">
                                        @if($borrowing->status != 'returned')
                                            <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary px-3 py-2 text-xs" onclick="return confirm('Ready to return this book?')">Return Book</button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-500">Returned on {{ $borrowing->returned_at->format('M d, Y') }}</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-sm text-slate-500">
                                    You have no borrowing records yet.
                                    <div class="mt-2">
                                        <a href="{{ route('books.index') }}" class="font-semibold text-blue-700 hover:text-blue-800">Explore Library</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 bg-slate-50 px-5 py-4">
                {{ $borrowings->links() }}
            </div>
        </section>
    </div>
</x-app-layout>
