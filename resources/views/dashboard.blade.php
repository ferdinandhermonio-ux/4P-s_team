<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="app-title" style="font-family: 'Plus Jakarta Sans', sans-serif;">Dashboard</h2>
                <p class="app-subtitle">Overview of books, users, and borrowing performance.</p>
            </div>
        </div>
    </x-slot>

    <div class="app-container pt-6">
        @php
            $totalBooks = max(1, (int) $stats['total_books']);
            $borrowedRate = min(100, (int) round(($stats['borrowed_books'] / $totalBooks) * 100));
            $overdueRate = min(100, (int) round(($stats['overdue_books'] / $totalBooks) * 100));
            $availableRate = max(0, 100 - $borrowedRate);
        @endphp

        <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4 fade-up">
            <article class="app-card p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Books</p>
                <p class="mt-3 text-3xl font-extrabold text-slate-900">{{ $stats['total_books'] }}</p>
            </article>
            <article class="app-card p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Users</p>
                <p class="mt-3 text-3xl font-extrabold text-slate-900">{{ $stats['total_users'] }}</p>
            </article>
            <article class="app-card p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Borrowed Books</p>
                <p class="mt-3 text-3xl font-extrabold text-blue-700">{{ $stats['borrowed_books'] }}</p>
            </article>
            <article class="app-card p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Overdue Books</p>
                <p class="mt-3 text-3xl font-extrabold text-red-600">{{ $stats['overdue_books'] }}</p>
            </article>
        </section>

        <section class="mt-6 app-card p-6 fade-up">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <h3 class="text-lg font-extrabold text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Library Analytics</h3>
                <p class="text-xs text-slate-500">Auto-computed from current catalog and borrowing data</p>
            </div>

            <div class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-3">
                <div class="app-card-soft p-4 lg:col-span-2">
                    <div class="space-y-4">
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs font-semibold text-slate-500">
                                <span>Borrowed Ratio</span>
                                <span>{{ $borrowedRate }}%</span>
                            </div>
                            <div class="h-2 rounded-full bg-slate-200">
                                <div class="h-2 rounded-full bg-blue-600" style="width: {{ $borrowedRate }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs font-semibold text-slate-500">
                                <span>Overdue Ratio</span>
                                <span>{{ $overdueRate }}%</span>
                            </div>
                            <div class="h-2 rounded-full bg-slate-200">
                                <div class="h-2 rounded-full bg-red-500" style="width: {{ $overdueRate }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs font-semibold text-slate-500">
                                <span>Available Ratio</span>
                                <span>{{ $availableRate }}%</span>
                            </div>
                            <div class="h-2 rounded-full bg-slate-200">
                                <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $availableRate }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="app-card-soft p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Health Snapshot</p>
                    <div class="mt-3 space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600">Catalog utilization</span>
                            <span class="badge badge-brand">{{ $borrowedRate }}%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600">Risk level</span>
                            @if($overdueRate >= 20)
                                <span class="badge badge-danger">High</span>
                            @elseif($overdueRate >= 8)
                                <span class="badge badge-warning">Medium</span>
                            @else
                                <span class="badge badge-success">Low</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600">Member count</span>
                            <span class="badge badge-brand">{{ $stats['total_users'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-6 app-card p-6 fade-up-delay">
            <h3 class="text-lg font-extrabold text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Quick Actions</h3>
            <p class="mt-1 text-sm text-slate-500">Jump directly to frequently used sections.</p>

            <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'librarian')
                    <a href="{{ route('books.index') }}" class="app-card-soft rounded-xl p-4 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                        Manage Books
                    </a>
                    <a href="{{ route('categories.index') }}" class="app-card-soft rounded-xl p-4 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                        Manage Categories
                    </a>
                @endif
                <a href="{{ route('my.borrowings') }}" class="app-card-soft rounded-xl p-4 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                    My Borrowings
                </a>
            </div>
        </section>
    </div>
</x-app-layout>
