<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="app-title" style="font-family: 'Plus Jakarta Sans', sans-serif;">Edit Book</h2>
                <p class="app-subtitle">Update details for "{{ $book->title }}".</p>
            </div>
            <span class="badge badge-brand">ID #{{ $book->id }}</span>
        </div>
    </x-slot>

    <div class="app-container pt-6">
        <section class="mx-auto max-w-4xl app-card p-6 sm:p-8 fade-up">
            <form action="{{ route('books.update', $book) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <x-input-label for="title" value="Book Title" class="text-xs font-semibold uppercase tracking-wide text-slate-500" />
                        <x-text-input id="title" name="title" type="text" class="mt-1" :value="old('title', $book->title)" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="author" value="Author" class="text-xs font-semibold uppercase tracking-wide text-slate-500" />
                        <x-text-input id="author" name="author" type="text" class="mt-1" :value="old('author', $book->author)" required />
                        <x-input-error :messages="$errors->get('author')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="category_id" value="Category" class="text-xs font-semibold uppercase tracking-wide text-slate-500" />
                        <select id="category_id" name="category_id" class="mt-1 w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="isbn" value="ISBN-13" class="text-xs font-semibold uppercase tracking-wide text-slate-500" />
                        <x-text-input id="isbn" name="isbn" type="text" class="mt-1" :value="old('isbn', $book->isbn)" required />
                        <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="cover_image" value="Cover Image URL" class="text-xs font-semibold uppercase tracking-wide text-slate-500" />
                        <x-text-input id="cover_image" name="cover_image" type="url" class="mt-1" :value="old('cover_image', $book->cover_image)" placeholder="https://..." />
                        <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="quantity" value="Total Quantity" class="text-xs font-semibold uppercase tracking-wide text-slate-500" />
                        <x-text-input id="quantity" name="quantity" type="number" class="mt-1" :value="old('quantity', $book->quantity)" required min="1" />
                        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-end gap-3 border-t border-slate-200 pt-5">
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">Discard Changes</a>
                    <x-primary-button>Update Book Entry</x-primary-button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
