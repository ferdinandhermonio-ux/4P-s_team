<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="app-title" style="font-family: 'Plus Jakarta Sans', sans-serif;">Borrowings Report</h2>
            <p class="app-subtitle">Monitor borrowed, overdue, and returned books.</p>
        </div>
    </x-slot>

    <div class="app-container pt-6">
        <section class="app-card p-5 fade-up">
            <form method="GET" action="{{ route('borrowings.index') }}" class="grid grid-cols-1 gap-3 md:grid-cols-4">
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Status</label>
                    <select name="status" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Statuses</option>
                        <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Search</label>
                    <input name="search" value="{{ request('search') }}" placeholder="Search user or book" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500" />
                </div>
                <div class="flex items-end gap-2">
                    <button class="btn btn-primary w-full">Filter</button>
                    @if(request()->anyFilled(['status', 'search']))
                        <a href="{{ route('borrowings.index') }}" class="btn btn-secondary">Clear</a>
                    @endif
                </div>
            </form>
        </section>

        <section class="mt-5 app-card p-0 fade-up-delay">
            <div class="table-wrap">
                <table class="table-ui min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Book</th>
                            <th>Borrowed</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($borrowings as $borrowing)
                            <tr>
                                <td>
                                    <p class="font-semibold text-slate-900">{{ $borrowing->user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $borrowing->user->email }}</p>
                                </td>
                                <td>
                                    <p class="font-medium text-slate-900">{{ $borrowing->book->title }}</p>
                                    <p class="text-xs text-slate-500">ISBN: {{ $borrowing->book->isbn }}</p>
                                </td>
                                <td class="text-sm text-slate-600">{{ $borrowing->borrowed_at->format('Y-m-d H:i') }}</td>
                                <td class="text-sm text-slate-600">{{ $borrowing->due_date->format('Y-m-d') }}</td>
                                <td>
                                    @if($borrowing->status === 'borrowed')
                                        <span class="badge badge-brand">Borrowed</span>
                                    @elseif($borrowing->status === 'overdue')
                                        <span class="badge badge-danger">Overdue</span>
                                    @else
                                        <span class="badge badge-success">Returned</span>
                                    @endif
                                </td>
                                <td>
                                    @if($borrowing->status !== 'returned')
                                        <form method="POST" action="{{ route('borrowings.return', $borrowing) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary px-3 py-2 text-xs" onclick="return confirm('Confirm return?')">Mark Returned</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-500">Returned on {{ $borrowing->returned_at->format('Y-m-d') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-sm text-slate-500">No borrowing records found.</td>
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
