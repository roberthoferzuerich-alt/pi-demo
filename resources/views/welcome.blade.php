<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pi-Demo — Personen Übersicht</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #090d16;
            color: #f1f5f9;
        }
        .bg-grid-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        .glass-card {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-card:hover {
            border-color: rgba(99, 102, 241, 0.4);
            box-shadow: 0 20px 40px -15px rgba(99, 102, 241, 0.25);
        }
        .gradient-text {
            background: linear-gradient(135deg, #818cf8 0%, #c084fc 50%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #db2777 100%);
        }
    </style>
</head>
<body class="min-h-full bg-grid-pattern antialiased flex flex-col justify-between selection:bg-indigo-500 selection:text-white">

    <!-- Top Ambient Glow -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[350px] bg-gradient-to-b from-indigo-600/20 via-purple-600/10 to-transparent blur-3xl pointer-events-none -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full flex-grow">
        
        <!-- Header & Begrüssung -->
        <header class="mb-12">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 pb-8 border-b border-slate-800/80">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 mb-3">
                        <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                        Willkommen im Dashboard
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                        Herzlich willkommen bei <span class="gradient-text">Pi-Demo</span> 👋
                    </h1>
                    <p class="mt-2 text-slate-400 text-sm sm:text-base max-w-2xl">
                        Übersicht über alle registrierten Personen. Filtere in Echtzeit nach Namen, Positionen oder Abteilungen.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-slate-400 bg-slate-900/80 px-3 py-2 rounded-xl border border-slate-800">
                        🗓️ {{ date('d.m.Y') }}
                    </span>
                    <a href="#people-list" class="gradient-bg text-white px-5 py-2.5 rounded-xl font-medium text-sm shadow-lg shadow-indigo-500/25 hover:opacity-95 transition-all duration-200">
                        Personen anzeigen
                    </a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8">
                <div class="glass-card p-5 rounded-2xl flex items-center gap-4">
                    <div class="p-3 bg-indigo-500/10 text-indigo-400 rounded-xl border border-indigo-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Gesamt Personen</p>
                        <p class="text-2xl font-bold text-white mt-0.5">{{ count($people) }}</p>
                    </div>
                </div>

                <div class="glass-card p-5 rounded-2xl flex items-center gap-4">
                    <div class="p-3 bg-emerald-500/10 text-emerald-400 rounded-xl border border-emerald-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Abteilungen</p>
                        <p class="text-2xl font-bold text-white mt-0.5">{{ $people->pluck('department')->unique()->count() }}</p>
                    </div>
                </div>

                <div class="glass-card p-5 rounded-2xl flex items-center gap-4">
                    <div class="p-3 bg-purple-500/10 text-purple-400 rounded-xl border border-purple-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Standorte / Städte</p>
                        <p class="text-2xl font-bold text-white mt-0.5">{{ $people->pluck('city')->unique()->count() }}</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Search Bar & Filters -->
        <div id="people-list" class="mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-white">Personenliste</h2>
                <p class="text-xs text-slate-400">Übersicht aller Einträge in der Datenbank</p>
            </div>
            
            <div class="relative w-full sm:w-72">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input 
                    type="text" 
                    id="searchInput" 
                    placeholder="Suchen nach Name, Position..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-900/90 border border-slate-800 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"
                >
            </div>
        </div>

        <!-- People Grid -->
        @if ($people->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="peopleGrid">
                @foreach ($people as $person)
                    <div class="glass-card rounded-2xl p-6 transition-all duration-300 flex flex-col justify-between person-card"
                         data-search="{{ strtolower($person->full_name . ' ' . $person->job_title . ' ' . $person->department . ' ' . $person->city) }}">
                        
                        <div>
                            <!-- Header Info -->
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img src="{{ $person->avatar_url }}" alt="{{ $person->full_name }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-indigo-500/30">
                                        <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-emerald-500 ring-2 ring-slate-900"></span>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-white hover:text-indigo-400 transition-colors">
                                            {{ $person->full_name }}
                                        </h3>
                                        <p class="text-xs text-slate-400 font-medium">
                                            {{ $person->job_title }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Badges -->
                            <div class="flex flex-wrap gap-2 mb-5">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-500/10 text-indigo-300 border border-indigo-500/20">
                                    🏢 {{ $person->department }}
                                </span>
                                <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-800 text-slate-300 border border-slate-700/50">
                                    📍 {{ $person->city }}
                                </span>
                            </div>

                            <!-- Details -->
                            <div class="space-y-2 text-xs text-slate-300 bg-slate-900/50 p-3.5 rounded-xl border border-slate-800/80 mb-4">
                                <div class="flex items-center justify-between gap-2 overflow-hidden">
                                    <span class="text-slate-500 font-medium shrink-0">E-Mail:</span>
                                    <a href="mailto:{{ $person->email }}" class="text-indigo-400 hover:underline truncate">
                                        {{ $person->email }}
                                    </a>
                                </div>
                                @if($person->phone)
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-slate-500 font-medium">Telefon:</span>
                                        <span class="text-slate-300 font-mono">{{ $person->phone }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="pt-3 border-t border-slate-800/60 flex items-center justify-between text-[11px] text-slate-500">
                            <span>ID: #{{ $person->id }}</span>
                            <span>Erstellt: {{ $person->created_at ? $person->created_at->format('d.m.Y') : 'n/a' }}</span>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- No results message -->
            <div id="noResults" class="hidden text-center py-16 glass-card rounded-2xl mt-4">
                <svg class="w-12 h-12 text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-slate-300">Keine Ergebnisse gefunden</h3>
                <p class="text-sm text-slate-500 mt-1">Versuche einen anderen Suchbegriff.</p>
            </div>

        @else
            <div class="text-center py-20 glass-card rounded-2xl">
                <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="text-xl font-bold text-white mb-2">Noch keine Personen vorhanden</h3>
                <p class="text-slate-400 text-sm mb-6 max-w-md mx-auto">
                    Führe <code>php artisan db:seed</code> aus, um die Datenbank mit Testpersonen zu füllen.
                </p>
            </div>
        @endif

    </div>

    <!-- Footer -->
    <footer class="mt-16 border-t border-slate-800/80 bg-slate-950/40 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div>
                <span class="font-semibold text-slate-400">Pi-Demo</span> &copy; {{ date('Y') }} — Laravel v{{ app()->version() }} (PHP v{{ PHP_VERSION }})
            </div>
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    System online
                </span>
            </div>
        </div>
    </footer>

    <!-- Interactive Live Search Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const personCards = document.querySelectorAll('.person-card');
            const noResults = document.getElementById('noResults');

            if (searchInput) {
                searchInput.addEventListener('input', function (e) {
                    const query = e.target.value.toLowerCase().trim();
                    let visibleCount = 0;

                    personCards.forEach(card => {
                        const searchData = card.getAttribute('data-search') || '';
                        if (searchData.includes(query)) {
                            card.style.display = 'flex';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    if (noResults) {
                        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
                    }
                });
            }
        });
    </script>
</body>
</html>
