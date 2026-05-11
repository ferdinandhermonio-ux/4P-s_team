<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'SLMS') }} | Smart Library System</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800|plus-jakarta-sans:500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased" style="font-family: 'Manrope', sans-serif;">
        <div class="relative overflow-x-hidden">
            <div class="pointer-events-none absolute -left-20 top-16 h-72 w-72 rounded-full bg-blue-300/35 blur-3xl"></div>
            <div class="pointer-events-none absolute -right-24 top-24 h-80 w-80 rounded-full bg-amber-200/45 blur-3xl"></div>

            <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/85 backdrop-blur-xl">
                <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                    <a href="/" class="inline-flex items-center gap-2">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-sm font-extrabold text-white">SL</span>
                        <span class="text-sm font-bold tracking-tight text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Smart Library</span>
                    </a>

                    <nav class="flex items-center gap-2 sm:gap-3">
                        <button type="button" onclick="window.toggleTheme && window.toggleTheme()" class="btn btn-secondary">Theme: <span data-theme-toggle-label>Light</span></button>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-secondary">Sign In</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-primary">Create Account</a>
                                @endif
                            @endauth
                        @endif
                    </nav>
                </div>
            </header>

            <main>
                <section class="mx-auto grid w-full max-w-7xl grid-cols-1 gap-10 px-4 pb-14 pt-14 sm:px-6 lg:grid-cols-2 lg:items-center lg:px-8">
                    <div class="fade-up">
                        <span class="badge badge-brand mb-4">Built for schools and community libraries</span>
                        <h1 class="text-4xl font-extrabold leading-tight text-slate-900 sm:text-5xl" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Manage your library with clarity, speed, and confidence.
                        </h1>
                        <p class="mt-5 max-w-xl text-base text-slate-600 sm:text-lg">
                            Smart Library System streamlines cataloging, borrowing, returns, and activity tracking so librarians can focus on readers, not spreadsheets.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Open Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">Get Started</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-secondary">Create Account</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>

                    <div class="fade-up-delay">
                        <div class="app-card p-6 sm:p-8">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="app-card-soft p-4">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Catalog health</p>
                                    <p class="mt-2 text-2xl font-extrabold text-slate-900">98%</p>
                                    <p class="mt-1 text-xs text-slate-500">Accurate inventory</p>
                                </div>
                                <div class="app-card-soft p-4">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Borrow flow</p>
                                    <p class="mt-2 text-2xl font-extrabold text-slate-900">3 clicks</p>
                                    <p class="mt-1 text-xs text-slate-500">Issue to return</p>
                                </div>
                                <div class="app-card-soft p-4">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Role-based access</p>
                                    <p class="mt-2 text-2xl font-extrabold text-slate-900">Admin + Staff</p>
                                    <p class="mt-1 text-xs text-slate-500">Secure operations</p>
                                </div>
                                <div class="app-card-soft p-4">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Activity logs</p>
                                    <p class="mt-2 text-2xl font-extrabold text-slate-900">Real-time</p>
                                    <p class="mt-1 text-xs text-slate-500">Auditable events</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="features" class="mx-auto w-full max-w-7xl px-4 pb-8 sm:px-6 lg:px-8">
                    <div class="app-card p-6 sm:p-8">
                        <h2 class="text-2xl font-extrabold text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Everything your library team needs</h2>
                        <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                            <article class="app-card-soft p-4">
                                <h3 class="font-bold text-slate-900">Smart Catalog</h3>
                                <p class="mt-2 text-sm text-slate-600">Organize books by category, ISBN, and stock status with quick filters.</p>
                            </article>
                            <article class="app-card-soft p-4">
                                <h3 class="font-bold text-slate-900">Borrowing Control</h3>
                                <p class="mt-2 text-sm text-slate-600">Track borrowed, overdue, and returned books in one clean flow.</p>
                            </article>
                            <article class="app-card-soft p-4">
                                <h3 class="font-bold text-slate-900">Actionable Reports</h3>
                                <p class="mt-2 text-sm text-slate-600">View operational insights to keep lending performance healthy.</p>
                            </article>
                            <article class="app-card-soft p-4">
                                <h3 class="font-bold text-slate-900">Audit Trail</h3>
                                <p class="mt-2 text-sm text-slate-600">Maintain trust with searchable activity records for key operations.</p>
                            </article>
                        </div>
                    </div>
                </section>

                <section class="mx-auto w-full max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
                    <div class="app-card p-6 sm:p-8">
                        <h2 class="text-2xl font-extrabold text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">How it works</h2>
                        <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div class="app-card-soft p-5">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Step 1</p>
                                <h3 class="mt-2 font-bold text-slate-900">Build your inventory</h3>
                                <p class="mt-2 text-sm text-slate-600">Add books, assign categories, and keep stock updated in minutes.</p>
                            </div>
                            <div class="app-card-soft p-5">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Step 2</p>
                                <h3 class="mt-2 font-bold text-slate-900">Enable borrowing</h3>
                                <p class="mt-2 text-sm text-slate-600">Members borrow books with due dates tracked automatically.</p>
                            </div>
                            <div class="app-card-soft p-5">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Step 3</p>
                                <h3 class="mt-2 font-bold text-slate-900">Monitor and improve</h3>
                                <p class="mt-2 text-sm text-slate-600">Review overdue trends and activity logs to optimize service.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <footer class="border-t border-slate-200/80 bg-white/70">
                <div class="mx-auto flex w-full max-w-7xl flex-col gap-3 px-4 py-6 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                    <p>© {{ date('Y') }} Smart Library System</p>
                    <p>Designed for a cleaner, faster library workflow.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
