<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('books.update', $book) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $book->title)" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="author" :value="__('Author')" />
                                <x-text-input id="author" name="author" type="text" class="mt-1 block w-full" :value="old('author', $book->author)" required />
                                <x-input-error :messages="$errors->get('author')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="category_id" :value="__('Category')" />
                                <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="isbn" :value="__('ISBN')" />
                                <x-text-input id="isbn" name="isbn" type="text" class="mt-1 block w-full" :value="old('isbn', $book->isbn)" required />
                                <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="quantity" :value="__('Total Quantity')" />
                                <x-text-input id="quantity" name="quantity" type="number" class="mt-1 block w-full" :value="old('quantity', $book->quantity)" required min="1" />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex items-center gap-4">
                            <x-primary-button>{{ __('Update Book') }}</x-primary-button>
                            <a href="{{ route('books.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>