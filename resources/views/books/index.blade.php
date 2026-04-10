<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Books Catalog') }}
            </h2>
            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'librarian')
            <a href="{{ route('books.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                Add New Book
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <form action="{{ route('books.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or author..." class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">Search</button>
                    @if(request('search'))
                        <a href="{{ route('books.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition flex items-center">Clear</a>
                    @endif
                </form>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($books as $book)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $book->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $book->author }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $book->category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $book->available_quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $book->available_quantity }} / {{ $book->quantity }} Available
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <div class="flex items-center space-x-2">
                                        @if($book->available_quantity > 0)
                                        <form action="{{ route('books.borrow', $book) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1 rounded">Borrow</button>
                                        </form>
                                        @endif

                                        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'librarian')
                                        <a href="{{ route('books.edit', $book) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded">Edit</a>
                                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded">Delete</button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>