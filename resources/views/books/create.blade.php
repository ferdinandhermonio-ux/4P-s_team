<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="app-title" style="font-family: 'Plus Jakarta Sans', sans-serif;">Add New Book</h2>
            <p class="app-subtitle">Create a new catalog record for your library inventory.</p>
        </div>
    </x-slot>

    <div class="app-container pt-6">
        <section class="mx-auto max-w-4xl app-card p-6 sm:p-8 fade-up">
            <form action="{{ route('books.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <x-input-label for="title" value="Book Title" class="text-xs font-semibold uppercase tracking-wide text-slate-500" />
                        <x-text-input id="title" name="title" type="text" class="mt-1" :value="old('title')" required placeholder="The Great Gatsby" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="author" value="Author" class="text-xs font-semibold uppercase tracking-wide text-slate-500" />
                        <x-text-input id="author" name="author" type="text" class="mt-1" :value="old('author')" required placeholder="F. Scott Fitzgerald" />
                        <x-input-error :messages="$errors->get('author')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="category_id" value="Category" class="text-xs font-semibold uppercase tracking-wide text-slate-500" />
                        <select id="category_id" name="category_id" class="mt-1 w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="isbn" value="ISBN-13" class="text-xs font-semibold uppercase tracking-wide text-slate-500" />
                        <x-text-input id="isbn" name="isbn" type="text" class="mt-1" :value="old('isbn')" required placeholder="9780000000000" />
                        <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="cover_image" value="Cover Image URL" class="text-xs font-semibold uppercase tracking-wide text-slate-500" />
                        <x-text-input id="cover_image" name="cover_image" type="url" class="mt-1" :value="old('cover_image')" placeholder="https://..." />
                        <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="quantity" value="Total Quantity" class="text-xs font-semibold uppercase tracking-wide text-slate-500" />
                        <x-text-input id="quantity" name="quantity" type="number" class="mt-1" :value="old('quantity')" required min="1" />
                        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-end gap-3 border-t border-slate-200 pt-5">
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
                    <x-primary-button>Create Book Entry</x-primary-button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
