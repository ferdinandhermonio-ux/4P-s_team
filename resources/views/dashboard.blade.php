<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Books</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_books'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Users</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Borrowed Books</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900 text-blue-600">{{ $stats['borrowed_books'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Overdue Books</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900 text-red-600">{{ $stats['overdue_books'] }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'librarian')
                            <a href="{{ route('books.index') }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">Manage Books</a>
                            <a href="{{ route('categories.index') }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">Manage Categories</a>
                        @endif
                        <a href="{{ route('my.borrowings') }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">My Borrowings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
