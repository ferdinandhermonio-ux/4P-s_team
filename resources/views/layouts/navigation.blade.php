<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/85 backdrop-blur-xl">
    <div class="app-container">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-blue-600 text-sm font-extrabold text-white">SL</span>
                    <span class="hidden text-sm font-bold tracking-tight text-slate-900 sm:block" style="font-family: 'Plus Jakarta Sans', sans-serif;">Smart Library</span>
                </a>

                <div class="hidden items-center gap-1 md:flex">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg px-3 py-2 text-sm font-semibold transition">Dashboard</a>
                    <a href="{{ route('my.borrowings') }}" class="{{ request()->routeIs('my.borrowings') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg px-3 py-2 text-sm font-semibold transition">My Books</a>

                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'librarian')
                        <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg px-3 py-2 text-sm font-semibold transition">Inventory</a>
                        <a href="{{ route('borrowings.index') }}" class="{{ request()->routeIs('borrowings.index') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg px-3 py-2 text-sm font-semibold transition">Reports</a>
                        <a href="{{ route('borrowings.activities') }}" class="{{ request()->routeIs('borrowings.activities') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg px-3 py-2 text-sm font-semibold transition">Activity</a>
                    @endif
                </div>
            </div>

            <div class="hidden items-center gap-3 md:flex">
                <button type="button" @click="window.toggleTheme && window.toggleTheme()" class="btn btn-secondary px-3 py-2 text-xs">Theme: <span data-theme-toggle-label>Light</span></button>
                <button type="button" @click="window.toggleDensity && window.toggleDensity()" class="btn btn-secondary px-3 py-2 text-xs">Density: <span data-density-toggle-label>Comfortable</span></button>

                <div class="text-right">
                    <div class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-500">{{ Auth::user()->email }}</div>
                </div>

                <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Profile</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Log Out</button>
                </form>
            </div>

            <button @click="open = !open" class="inline-flex items-center justify-center rounded-lg border border-slate-300 p-2 text-slate-700 md:hidden" type="button">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div x-show="open" x-transition class="space-y-2 border-t border-slate-200 py-4 md:hidden">
            <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Dashboard</a>
            <a href="{{ route('my.borrowings') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('my.borrowings') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">My Books</a>

            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'librarian')
                <a href="{{ route('books.index') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('books.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Inventory</a>
                <a href="{{ route('borrowings.index') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('borrowings.index') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Reports</a>
                <a href="{{ route('borrowings.activities') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('borrowings.activities') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Activity</a>
            @endif

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                <div class="mb-3 grid grid-cols-2 gap-2">
                    <button type="button" @click="window.toggleTheme && window.toggleTheme()" class="btn btn-secondary w-full">Theme: <span data-theme-toggle-label>Light</span></button>
                    <button type="button" @click="window.toggleDensity && window.toggleDensity()" class="btn btn-secondary w-full">Density: <span data-density-toggle-label>Comfortable</span></button>
                </div>
                <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn btn-secondary flex-1">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" class="btn btn-primary w-full">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
