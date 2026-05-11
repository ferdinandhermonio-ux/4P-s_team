<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="app-title" style="font-family: 'Plus Jakarta Sans', sans-serif;">System Activity Logs</h2>
            <p class="app-subtitle">Review borrowing, return, and inventory actions across the system.</p>
        </div>
    </x-slot>

    <div class="app-container pt-6">
        <section class="app-card p-5 fade-up">
            <form method="GET" action="{{ route('borrowings.activities') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="w-full sm:max-w-md">
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Search</label>
                    <input name="search" value="{{ request('search') }}" placeholder="Search activity details" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500" />
                </div>
                <button class="btn btn-primary">Search</button>
                @if(request('search'))
                    <a href="{{ route('borrowings.activities') }}" class="btn btn-secondary">Clear</a>
                @endif
            </form>
        </section>

        <section class="mt-5 app-card p-0 fade-up-delay">
            <div class="table-wrap">
                <table class="table-ui min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($activities as $activity)
                            <tr>
                                <td class="font-semibold text-slate-900">{{ $activity->user->name }}</td>
                                <td>
                                    @if($activity->action === 'borrow')
                                        <span class="badge badge-brand">borrow</span>
                                    @elseif($activity->action === 'return')
                                        <span class="badge badge-success">return</span>
                                    @elseif($activity->action === 'delete')
                                        <span class="badge badge-danger">delete</span>
                                    @else
                                        <span class="badge badge-warning">{{ $activity->action }}</span>
                                    @endif
                                </td>
                                <td class="text-slate-700">{{ $activity->description }}</td>
                                <td class="text-sm text-slate-600">{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-sm text-slate-500">No activities recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 bg-slate-50 px-5 py-4">
                {{ $activities->links() }}
            </div>
        </section>
    </div>
</x-app-layout>
