<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <div class="mb-8 border-b border-gray-100 pb-4">
                        <h3 class="text-lg font-bold text-gray-800">Book Information</h3>
                        <p class="text-sm text-gray-500 italic">Enter the details of the new book for the library collection.</p>
                    </div>

                    <form action="{{ route('books.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            <div class="md:col-span-2">
                                <x-input-label for="title" class="flex items-center text-xs font-bold uppercase text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    Book Title
                                </x-input-label>
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" :value="old('title')" required placeholder="e.g. The Great Gatsby" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="author" class="flex items-center text-xs font-bold uppercase text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Author Name
                                </x-input-label>
                                <x-text-input id="author" name="author" type="text" class="mt-1 block w-full border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" :value="old('author')" required placeholder="e.g. F. Scott Fitzgerald" />
                                <x-input-error :messages="$errors->get('author')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="category_id" class="flex items-center text-xs font-bold uppercase text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7c.78.78.78 2.047 0 2.828l-7 7c-.78.78-2.047.78-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                    Category
                                </x-input-label>
                                <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="isbn" class="flex items-center text-xs font-bold uppercase text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                    ISBN-13
                                </x-input-label>
                                <x-text-input id="isbn" name="isbn" type="text" class="mt-1 block w-full border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" :value="old('isbn')" required placeholder="9780000000000" />
                                <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="quantity" class="flex items-center text-xs font-bold uppercase text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    Total Quantity
                                </x-input-label>
                                <x-text-input id="quantity" name="quantity" type="number" class="mt-1 block w-full border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" :value="old('quantity')" required min="1" />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-10 flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                            <a href="{{ route('books.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700 transition">Cancel and Return</a>
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 py-3 px-8 text-sm font-bold rounded-xl shadow-lg shadow-indigo-200">
                                {{ __('Create Book Entry') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>