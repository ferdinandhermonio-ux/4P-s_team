<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Books Inventory') }}
            </h2>
            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'librarian')
            <a href="{{ route('books.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition shadow-md">
                + Add New Book
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Advanced Filter Bar -->
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-100">
                <form action="{{ route('books.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Search Keywords</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Title, Author or ISBN..." class="w-full rounded-lg border-gray-200 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Category</label>
                        <select name="category_id" class="w-full rounded-lg border-gray-200 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Stock Status</label>
                        <select name="stock_status" class="w-full rounded-lg border-gray-200 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Status</option>
                            <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock (≤ 2)</option>
                            <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition font-medium">Apply Filters</button>
                        <a href="{{ route('books.index') }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-200 transition">Reset</a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-0 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Book Details</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">ISBN</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Stock Status</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse($books as $book)
                            <tr class="hover:bg-indigo-50/30 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $book->title }}</div>
                                    <div class="text-sm text-gray-500">by {{ $book->author }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                                        {{ $book->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 font-mono">
                                    {{ $book->isbn }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <div class="flex items-center">
                                            @if($book->available_quantity == 0)
                                                <span class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></span>
                                                <span class="text-sm font-semibold text-red-700">Out of Stock</span>
                                            @elseif($book->available_quantity <= 2)
                                                <span class="h-2.5 w-2.5 rounded-full bg-yellow-500 mr-2 animate-pulse"></span>
                                                <span class="text-sm font-semibold text-yellow-700">Low Stock</span>
                                            @else
                                                <span class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></span>
                                                <span class="text-sm font-semibold text-green-700">Available</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ $book->available_quantity }} of {{ $book->quantity }} units
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <div class="flex justify-end items-center gap-2" x-data="{ open: false }">
                                        <button @click="open = true" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition" title="View Details">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>

                                        <!-- Book Details Modal -->
                                        <x-modal name="book-details" :show="false" x-show="open" @close="open = false">
                                            <div class="p-6">
                                                <div class="flex justify-between items-start mb-4">
                                                    <h3 class="text-2xl font-bold text-gray-900">{{ $book->title }}</h3>
                                                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase">{{ $book->category->name }}</span>
                                                </div>
                                                
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                                    <div class="space-y-4">
                                                        <div>
                                                            <label class="block text-xs font-bold text-gray-400 uppercase">Author</label>
                                                            <p class="text-gray-700 font-medium">{{ $book->author }}</p>
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-bold text-gray-400 uppercase">ISBN-13</label>
                                                            <p class="text-gray-700 font-mono">{{ $book->isbn }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="space-y-4">
                                                        <div>
                                                            <label class="block text-xs font-bold text-gray-400 uppercase">Availability</label>
                                                            <div class="flex items-center mt-1">
                                                                <span class="h-3 w-3 rounded-full {{ $book->available_quantity > 0 ? 'bg-green-500' : 'bg-red-500' }} mr-2"></span>
                                                                <p class="text-gray-700 font-bold">{{ $book->available_quantity }} units available</p>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-bold text-gray-400 uppercase">Total Stock</label>
                                                            <p class="text-gray-700">{{ $book->quantity }} units total</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                                    <x-secondary-button @click="open = false">Close</x-secondary-button>
                                                    @if($book->available_quantity > 0)
                                                        <form action="{{ route('books.borrow', $book) }}" method="POST">
                                                            @csrf
                                                            <x-primary-button>Borrow This Book</x-primary-button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </x-modal>

                                        @if($book->available_quantity > 0)
                                        <form action="{{ route('books.borrow', $book) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-md text-sm font-medium transition shadow-sm">Borrow</button>
                                        </form>
                                        @endif

                                        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'librarian')
                                        <a href="{{ route('books.edit', $book) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Edit Book">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                        </a>
                                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Delete this book permanently?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete Book">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-gray-400 mb-2 italic">No books found matching your criteria.</div>
                                    <a href="{{ route('books.index') }}" class="text-indigo-600 font-semibold underline">Clear all filters</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>