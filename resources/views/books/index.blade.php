<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="app-title" style="font-family: 'Plus Jakarta Sans', sans-serif;">Books Inventory</h2>
                <p class="app-subtitle">Search, filter, and manage your collection efficiently.</p>
            </div>
            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'librarian')
                <a href="{{ route('books.create') }}" class="btn btn-primary">Add New Book</a>
            @endif
        </div>
    </x-slot>

    <div class="app-container pt-6">
        <section class="app-card p-5 fade-up">
            <form action="{{ route('books.index') }}" method="GET" class="grid grid-cols-1 gap-3 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Title, author, or ISBN" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Category</label>
                    <select name="category_id" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Stock</label>
                    <select name="stock_status" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock (<= 2)</option>
                        <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="btn btn-primary w-full">Apply</button>
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </section>

        <section class="mt-5 app-card p-0 fade-up-delay">
            <div class="table-wrap">
                <table class="table-ui min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Category</th>
                            <th>ISBN</th>
                            <th>Stock</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($books as $book)
                            <tr>
                                <td>
                                    <div class="flex items-start gap-3">
                                        @if($book->cover_image)
                                            <img src="{{ $book->cover_image }}" alt="{{ $book->title }} cover" class="h-14 w-10 rounded-md border border-slate-200 object-cover" loading="lazy" />
                                        @else
                                            <div class="flex h-14 w-10 items-center justify-center rounded-md border border-slate-200 bg-slate-100 text-[10px] font-semibold text-slate-500">No Img</div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $book->title }}</p>
                                            <p class="text-xs text-slate-500">by {{ $book->author }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-brand">{{ $book->category->name }}</span>
                                </td>
                                <td class="font-mono text-xs text-slate-600">{{ $book->isbn }}</td>
                                <td>
                                    <div class="flex flex-col gap-1">
                                        @if($book->available_quantity == 0)
                                            <span class="badge badge-danger">Out of Stock</span>
                                        @elseif($book->available_quantity <= 2)
                                            <span class="badge badge-warning">Low Stock</span>
                                        @else
                                            <span class="badge badge-success">Available</span>
                                        @endif
                                        <span class="text-xs text-slate-500">{{ $book->available_quantity }} of {{ $book->quantity }} available</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex justify-end gap-2">
                                        @if($book->available_quantity > 0)
                                            <form action="{{ route('books.borrow', $book) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary px-3 py-2 text-xs">Borrow</button>
                                            </form>
                                        @endif

                                        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'librarian')
                                            <a href="{{ route('books.edit', $book) }}" class="btn btn-secondary px-3 py-2 text-xs">Edit</a>
                                            <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Delete this book permanently?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-sm text-slate-500">
                                    No books found with the selected filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 bg-slate-50 px-5 py-4">
                {{ $books->links() }}
            </div>
        </section>
    </div>
</x-app-layout>
