<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SI Alumni') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    
    {{-- Anti-Inspect Script --}}
    <script src="{{ asset('js/anti-inspect.js') }}" defer></script>
</head>
<body class="antialiased bg-white dark:bg-zinc-950 min-h-screen flex flex-col font-sans selection:bg-blue-500 selection:text-white">
    
    {{-- Navbar --}}
    <div class="fixed w-full z-50 top-0 transition-all duration-300" id="navbar">
        <div class="absolute inset-0 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl border-b border-zinc-200 dark:border-zinc-800"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10  rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-red-500/30 transform hover:scale-105 transition-transform duration-200">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-zinc-900 dark:text-white">SI<span class="text-red-500">Alumni</span></span>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-sm font-medium text-zinc-600 hover:text-blue-600 dark:text-zinc-400 dark:hover:text-blue-400 transition-colors" data-i18n="nav_features">Fitur</a>
                    <a href="#tracer" class="text-sm font-medium text-zinc-600 hover:text-blue-600 dark:text-zinc-400 dark:hover:text-blue-400 transition-colors" data-i18n="nav_tracer">Tracer Study</a>
                    <a href="#" class="text-sm font-medium text-zinc-600 hover:text-blue-600 dark:text-zinc-400 dark:hover:text-blue-400 transition-colors" data-i18n="nav_news">Berita</a>
                </nav>

                <!-- Language Switcher, Dark Mode Toggle & Auth Buttons -->
                <div class="flex items-center gap-3">
                    {{-- Language Switcher --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-xl text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                            </svg>
                            <span id="current-lang-label" class="text-sm font-medium hidden sm:inline">ID</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-40 bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 py-2 z-50">
                            <button onclick="setLanguage('id')" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                <span class="text-lg">🇮🇩</span> Indonesia
                            </button>
                            <button onclick="setLanguage('en')" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                <span class="text-lg">🇬🇧</span> English
                            </button>
                            <button onclick="setLanguage('ar')" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                <span class="text-lg">🇸🇦</span> العربية
                            </button>
                            <button onclick="setLanguage('zh')" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                <span class="text-lg">🇨🇳</span> 中文
                            </button>
                            <button onclick="setLanguage('ja')" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                <span class="text-lg">🇯🇵</span> 日本語
                            </button>
                        </div>
                    </div>

                    {{-- Dark Mode Toggle --}}
                    <button
                        x-data
                        @click="$flux.appearance = $flux.dark ? 'light' : 'dark'"
                        class="p-2.5 rounded-xl text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all duration-200"
                        title="Toggle Dark Mode"
                    >
                        <template x-if="$flux.dark">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </template>
                        <template x-if="!$flux.dark">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </template>
                    </button>

                    @auth
                        <flux:button href="{{ url('/dashboard') }}" variant="primary" icon="squares-2x2"><span data-i18n="btn_dashboard">Dashboard</span></flux:button>
                    @else
                        <flux:button href="{{ route('login') }}" variant="ghost"><span data-i18n="btn_login">Masuk</span></flux:button>
                        @if (Route::has('register'))
                            <flux:button href="{{ route('register') }}" variant="primary"><span data-i18n="btn_register">Daftar</span></flux:button>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- Hero Section --}}
    <main class="flex-grow">
        <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            <!-- Background Gradients -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 pointer-events-none">
                <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-500/20 rounded-full blur-[120px] animate-pulse"></div>
                <div class="absolute top-[20%] right-[-10%] w-[35%] h-[50%] bg-indigo-500/20 rounded-full blur-[120px] animate-pulse delay-700"></div>
                <div class="absolute bottom-[-10%] left-[20%] w-[40%] h-[40%] bg-violet-500/20 rounded-full blur-[120px] animate-pulse delay-1000"></div>
            </div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto">
                    <div class="mb-8 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 text-blue-600 dark:text-blue-400 text-sm font-medium animate-fade-in-up">
                        <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                        <span data-i18n="hero_badge">Tracer Study 2024 Telah Dibuka</span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-bold tracking-tight text-zinc-900 dark:text-white mb-8 leading-tight">
                        <span data-i18n="hero_title_1">Hubungkan Kembali</span> <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600" data-i18n="hero_title_2">Jejak Langkahmu</span>
                    </h1>
                    
                    <p class="text-lg text-zinc-600 dark:text-zinc-400 mb-12 leading-relaxed max-w-2xl mx-auto" data-i18n="hero_description">
                        Membangun jaringan alumni yang kuat, melacak kesuksesan karir, dan berkontribusi untuk kemajuan almamater tercinta.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        @auth
                            <flux:button href="{{ url('/dashboard') }}" variant="primary" icon="squares-2x2" class="w-full sm:w-auto h-12 text-lg px-8"><span data-i18n="btn_to_dashboard">Ke Dashboard</span></flux:button>
                        @else
                            <flux:button href="{{ route('register') }}" variant="primary" class="w-full sm:w-auto h-12 text-lg px-8 shadow-xl shadow-blue-500/20"><span data-i18n="btn_start_now">Mulai Sekarang</span></flux:button>
                            <flux:button href="#features" variant="ghost" icon="arrow-down" class="w-full sm:w-auto h-12 text-lg px-8"><span data-i18n="btn_learn_features">Pelajari Fitur</span></flux:button>
                        @endauth
                    </div>

                    <!-- Modern Stats Grid -->
                    <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-zinc-200 dark:border-zinc-800 pt-10">
                        <div class="p-4">
                            <div class="text-3xl font-bold text-zinc-900 dark:text-white mb-1">2.5k+</div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400" data-i18n="stat_alumni">Alumni Terdaftar</div>
                        </div>
                        <div class="p-4">
                            <div class="text-3xl font-bold text-zinc-900 dark:text-white mb-1">95%</div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400" data-i18n="stat_employment">Employment Rate</div>
                        </div>
                        <div class="p-4">
                            <div class="text-3xl font-bold text-zinc-900 dark:text-white mb-1">50+</div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400" data-i18n="stat_partners">Mitra Perusahaan</div>
                        </div>
                        <div class="p-4">
                            <div class="text-3xl font-bold text-zinc-900 dark:text-white mb-1">2010</div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400" data-i18n="stat_since">Sejak Tahun</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Features Section --}}
        <div id="features" class="py-24 bg-zinc-50/50 dark:bg-zinc-900/50 relative">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-blue-600 dark:text-blue-400 font-semibold mb-2 uppercase tracking-wide text-sm" data-i18n="features_subtitle">Fitur Unggulan</h2>
                    <h3 class="text-3xl md:text-4xl font-bold text-zinc-900 dark:text-white" data-i18n="features_title">Ekosistem Digital Alumni</h3>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="group bg-white dark:bg-zinc-900 rounded-3xl p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-zinc-100 dark:border-zinc-800 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-bl-[100px] -mr-8 -mt-8 transition-transform group-hover:scale-150 duration-500"></div>
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center text-blue-600 dark:text-blue-400 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <flux:icon name="user-group" class="w-6 h-6" />
                        </div>
                        <h4 class="text-xl font-bold text-zinc-900 dark:text-white mb-3" data-i18n="feature1_title">Direktori Alumni</h4>
                        <p class="text-zinc-500 dark:text-zinc-400 leading-relaxed" data-i18n="feature1_desc">
                            Temukan teman seangkatan, senior, atau junior. Bangun jejaring profesional Anda dengan mudah melalui database terintegrasi.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="group bg-white dark:bg-zinc-900 rounded-3xl p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-zinc-100 dark:border-zinc-800 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-bl-[100px] -mr-8 -mt-8 transition-transform group-hover:scale-150 duration-500"></div>
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                            <flux:icon name="chart-bar" class="w-6 h-6" />
                        </div>
                        <h4 class="text-xl font-bold text-zinc-900 dark:text-white mb-3" data-i18n="feature2_title">Tracer Study</h4>
                        <p class="text-zinc-500 dark:text-zinc-400 leading-relaxed" data-i18n="feature2_desc">
                            Partisipasi Anda membantu pengembangan kurikulum. Isi kuesioner dengan antarmuka yang modern dan mudah digunakan.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="group bg-white dark:bg-zinc-900 rounded-3xl p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-zinc-100 dark:border-zinc-800 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-violet-500/5 rounded-bl-[100px] -mr-8 -mt-8 transition-transform group-hover:scale-150 duration-500"></div>
                        <div class="w-12 h-12 bg-violet-100 dark:bg-violet-900/30 rounded-2xl flex items-center justify-center text-violet-600 dark:text-violet-400 mb-6 group-hover:bg-violet-600 group-hover:text-white transition-colors duration-300">
                            <flux:icon name="briefcase" class="w-6 h-6" />
                        </div>
                        <h4 class="text-xl font-bold text-zinc-900 dark:text-white mb-3">
                            <span data-i18n="feature3_title">Pusat Karir</span> <span class="text-violet-600 dark:text-violet-400 text-sm font-medium ml-1">(Coming Soon)</span>
                        </h4>
                        <p class="text-zinc-500 dark:text-zinc-400 leading-relaxed" data-i18n="feature3_desc">
                            Dapatkan akses eksklusif ke informasi lowongan pekerjaan dan peluang kolaborasi dari sesama alumni dan mitra.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tracer Study CTA --}}
        <div id="tracer" class="py-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-zinc-900">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-900/20 to-indigo-900/20"></div>
                <!-- Abstract patterns -->
                <svg class="absolute top-0 right-0 text-white/5 w-1/2 h-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M50 0 L100 0 L100 100 L0 100 Z" />
                </svg>
            </div>
            
            <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
                <div class="bg-gradient-to-br from-zinc-800/50 to-zinc-900/50 backdrop-blur-md rounded-3xl p-8 md:p-16 border border-white/10 text-center md:text-left flex flex-col md:flex-row items-center justify-between gap-12">
                    <div class="max-w-2xl">
                        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6" data-i18n="cta_title">Sudahkah Anda Berpartisipasi?</h2>
                        <p class="text-zinc-300 text-lg leading-relaxed mb-0" data-i18n="cta_description">
                            Data Anda adalah kunci untuk masa depan almamater yang lebih baik. Luangkan waktu kurang dari 10 menit untuk mengisi Tracer Study tahun ini.
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        @auth
                            <flux:button href="{{ route('alumni.tracer-periods') }}" variant="primary" class="h-14 px-8 text-lg bg-white text-zinc-900 hover:bg-zinc-100 border-0">
                                <span class="font-bold" data-i18n="btn_start_survey">Mulai Survey</span>
                                <flux:icon name="arrow-right" class="ml-2 w-5 h-5" />
                            </flux:button>
                        @else
                            <flux:button href="{{ route('login') }}" variant="primary" class="h-14 px-8 text-lg bg-white text-zinc-900 hover:bg-zinc-100 border-0">
                                <span class="font-bold" data-i18n="btn_login_survey">Masuk & Isi Survey</span>
                                <flux:icon name="arrow-right" class="ml-2 w-5 h-5" />
                            </flux:button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

    </main>

    {{-- Modern Footer --}}
    <footer class="bg-white dark:bg-zinc-950 border-t border-zinc-100 dark:border-zinc-900 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold shadow-lg">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo">
                        </div>
                        <span class="font-bold text-xl text-zinc-900 dark:text-white">SI<span class="text-red-600">Alumni</span></span>
                    </div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6" data-i18n="footer_description">
                        Platform resmi ikatan alumni untuk mempererat silaturahmi dan memajukan almamater.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="text-zinc-400 hover:text-blue-600 transition-colors"><flux:icon name="globe-alt" class="w-5 h-5" /></a>
                        <a href="#" class="text-zinc-400 hover:text-blue-600 transition-colors"><flux:icon name="chat-bubble-left-right" class="w-5 h-5" /></a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-semibold text-zinc-900 dark:text-white mb-4" data-i18n="footer_nav">Navigasi</h4>
                    <ul class="space-y-3 text-sm text-zinc-500 dark:text-zinc-400">
                        <li><a href="#" class="hover:text-blue-600 transition-colors" data-i18n="footer_home">Beranda</a></li>
                        <li><a href="#features" class="hover:text-blue-600 transition-colors" data-i18n="nav_features">Fitur</a></li>
                        <li><a href="#tracer" class="hover:text-blue-600 transition-colors" data-i18n="nav_tracer">Tracer Study</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition-colors" data-i18n="nav_news">Berita</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-zinc-900 dark:text-white mb-4" data-i18n="footer_support">Dukungan</h4>
                    <ul class="space-y-3 text-sm text-zinc-500 dark:text-zinc-400">
                        <li><a href="#" class="hover:text-blue-600 transition-colors" data-i18n="footer_help">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition-colors">FAQ</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition-colors" data-i18n="footer_contact">Kontak Kami</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-zinc-900 dark:text-white mb-4" data-i18n="footer_legal">Legal</h4>
                    <ul class="space-y-3 text-sm text-zinc-500 dark:text-zinc-400">
                        <li><a href="#" class="hover:text-blue-600 transition-colors" data-i18n="footer_privacy">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition-colors" data-i18n="footer_terms">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-zinc-100 dark:border-zinc-900 pt-8 text-center md:text-left flex flex-col md:flex-row justify-between items-center">
                <p class="text-xs text-zinc-500 dark:text-zinc-500" data-i18n="footer_copyright">&copy; {{ date('Y') }} Sistem Informasi Alumni. All rights reserved.</p>
                <div class="mt-4 md:mt-0 flex gap-6 text-xs text-zinc-500 dark:text-zinc-500">
                    <span>Versi 1.0.0</span>
                    <span>Laravel v{{ Illuminate\Foundation\Application::VERSION }}</span>
                </div>
            </div>
        </div>
    </footer>

    {{-- Language Translations Script --}}
    <script>
        const translations = {
            id: {
                // Navigation
                nav_features: 'Fitur',
                nav_tracer: 'Tracer Study',
                nav_news: 'Berita',
                // Buttons
                btn_dashboard: 'Dashboard',
                btn_login: 'Masuk',
                btn_register: 'Daftar',
                btn_to_dashboard: 'Ke Dashboard',
                btn_start_now: 'Mulai Sekarang',
                btn_learn_features: 'Pelajari Fitur',
                btn_start_survey: 'Mulai Survey',
                btn_login_survey: 'Masuk & Isi Survey',
                // Hero
                hero_badge: 'Tracer Study 2024 Telah Dibuka',
                hero_title_1: 'Hubungkan Kembali',
                hero_title_2: 'Jejak Langkahmu',
                hero_description: 'Membangun jaringan alumni yang kuat, melacak kesuksesan karir, dan berkontribusi untuk kemajuan almamater tercinta.',
                // Stats
                stat_alumni: 'Alumni Terdaftar',
                stat_employment: 'Tingkat Kerja',
                stat_partners: 'Mitra Perusahaan',
                stat_since: 'Sejak Tahun',
                // Features
                features_subtitle: 'Fitur Unggulan',
                features_title: 'Ekosistem Digital Alumni',
                feature1_title: 'Direktori Alumni',
                feature1_desc: 'Temukan teman seangkatan, senior, atau junior. Bangun jejaring profesional Anda dengan mudah melalui database terintegrasi.',
                feature2_title: 'Tracer Study',
                feature2_desc: 'Partisipasi Anda membantu pengembangan kurikulum. Isi kuesioner dengan antarmuka yang modern dan mudah digunakan.',
                feature3_title: 'Pusat Karir',
                feature3_desc: 'Dapatkan akses eksklusif ke informasi lowongan pekerjaan dan peluang kolaborasi dari sesama alumni dan mitra.',
                // CTA
                cta_title: 'Sudahkah Anda Berpartisipasi?',
                cta_description: 'Data Anda adalah kunci untuk masa depan almamater yang lebih baik. Luangkan waktu kurang dari 10 menit untuk mengisi Tracer Study tahun ini.',
                // Footer
                footer_description: 'Platform resmi ikatan alumni untuk mempererat silaturahmi dan memajukan almamater.',
                footer_nav: 'Navigasi',
                footer_home: 'Beranda',
                footer_support: 'Dukungan',
                footer_help: 'Pusat Bantuan',
                footer_contact: 'Kontak Kami',
                footer_legal: 'Legal',
                footer_privacy: 'Kebijakan Privasi',
                footer_terms: 'Syarat & Ketentuan',
                footer_copyright: '© 2026 Sistem Informasi Alumni. Hak cipta dilindungi.'
            },
            en: {
                // Navigation
                nav_features: 'Features',
                nav_tracer: 'Tracer Study',
                nav_news: 'News',
                // Buttons
                btn_dashboard: 'Dashboard',
                btn_login: 'Login',
                btn_register: 'Register',
                btn_to_dashboard: 'Go to Dashboard',
                btn_start_now: 'Get Started',
                btn_learn_features: 'Learn Features',
                btn_start_survey: 'Start Survey',
                btn_login_survey: 'Login & Fill Survey',
                // Hero
                hero_badge: 'Tracer Study 2024 is Now Open',
                hero_title_1: 'Reconnect',
                hero_title_2: 'Your Footsteps',
                hero_description: 'Building a strong alumni network, tracking career success, and contributing to the advancement of our beloved alma mater.',
                // Stats
                stat_alumni: 'Registered Alumni',
                stat_employment: 'Employment Rate',
                stat_partners: 'Company Partners',
                stat_since: 'Since Year',
                // Features
                features_subtitle: 'Key Features',
                features_title: 'Digital Alumni Ecosystem',
                feature1_title: 'Alumni Directory',
                feature1_desc: 'Find classmates, seniors, or juniors. Build your professional network easily through an integrated database.',
                feature2_title: 'Tracer Study',
                feature2_desc: 'Your participation helps curriculum development. Fill out questionnaires with a modern and easy-to-use interface.',
                feature3_title: 'Career Center',
                feature3_desc: 'Get exclusive access to job opportunities and collaboration opportunities from fellow alumni and partners.',
                // CTA
                cta_title: 'Have You Participated?',
                cta_description: 'Your data is the key to a better future for our alma mater. Take less than 10 minutes to complete this year\'s Tracer Study.',
                // Footer
                footer_description: 'Official alumni association platform to strengthen bonds and advance our alma mater.',
                footer_nav: 'Navigation',
                footer_home: 'Home',
                footer_support: 'Support',
                footer_help: 'Help Center',
                footer_contact: 'Contact Us',
                footer_legal: 'Legal',
                footer_privacy: 'Privacy Policy',
                footer_terms: 'Terms & Conditions',
                footer_copyright: '© 2026 Alumni Information System. All rights reserved.'
            },
            ar: {
                // Navigation
                nav_features: 'المميزات',
                nav_tracer: 'دراسة التتبع',
                nav_news: 'الأخبار',
                // Buttons
                btn_dashboard: 'لوحة التحكم',
                btn_login: 'تسجيل الدخول',
                btn_register: 'التسجيل',
                btn_to_dashboard: 'إلى لوحة التحكم',
                btn_start_now: 'ابدأ الآن',
                btn_learn_features: 'تعرف على المميزات',
                btn_start_survey: 'ابدأ الاستطلاع',
                btn_login_survey: 'سجل الدخول وأكمل الاستطلاع',
                // Hero
                hero_badge: 'دراسة التتبع 2024 مفتوحة الآن',
                hero_title_1: 'أعد الاتصال',
                hero_title_2: 'بخطواتك',
                hero_description: 'بناء شبكة خريجين قوية، تتبع النجاح المهني، والمساهمة في تقدم جامعتنا العزيزة.',
                // Stats
                stat_alumni: 'خريجين مسجلين',
                stat_employment: 'معدل التوظيف',
                stat_partners: 'شركاء الشركات',
                stat_since: 'منذ عام',
                // Features
                features_subtitle: 'المميزات الرئيسية',
                features_title: 'نظام الخريجين الرقمي',
                feature1_title: 'دليل الخريجين',
                feature1_desc: 'ابحث عن زملاء الدراسة أو الكبار أو الصغار. قم ببناء شبكتك المهنية بسهولة.',
                feature2_title: 'دراسة التتبع',
                feature2_desc: 'مشاركتك تساعد في تطوير المناهج. أكمل الاستبيانات بواجهة حديثة وسهلة الاستخدام.',
                feature3_title: 'مركز التوظيف',
                feature3_desc: 'احصل على وصول حصري لفرص العمل والتعاون من الخريجين والشركاء.',
                // CTA
                cta_title: 'هل شاركت؟',
                cta_description: 'بياناتك هي المفتاح لمستقبل أفضل لجامعتنا. خذ أقل من 10 دقائق لإكمال دراسة التتبع هذا العام.',
                // Footer
                footer_description: 'منصة رابطة الخريجين الرسمية لتعزيز الروابط والنهوض بجامعتنا.',
                footer_nav: 'التنقل',
                footer_home: 'الرئيسية',
                footer_support: 'الدعم',
                footer_help: 'مركز المساعدة',
                footer_contact: 'اتصل بنا',
                footer_legal: 'قانوني',
                footer_privacy: 'سياسة الخصوصية',
                footer_terms: 'الشروط والأحكام',
                footer_copyright: '© 2026 نظام معلومات الخريجين. جميع الحقوق محفوظة.'
            },
            zh: {
                // Navigation
                nav_features: '功能',
                nav_tracer: '追踪调查',
                nav_news: '新闻',
                // Buttons
                btn_dashboard: '仪表板',
                btn_login: '登录',
                btn_register: '注册',
                btn_to_dashboard: '进入仪表板',
                btn_start_now: '立即开始',
                btn_learn_features: '了解功能',
                btn_start_survey: '开始调查',
                btn_login_survey: '登录并填写调查',
                // Hero
                hero_badge: '2024年追踪调查现已开放',
                hero_title_1: '重新连接',
                hero_title_2: '你的足迹',
                hero_description: '构建强大的校友网络，追踪职业成功，为母校的发展做出贡献。',
                // Stats
                stat_alumni: '注册校友',
                stat_employment: '就业率',
                stat_partners: '合作企业',
                stat_since: '始于年份',
                // Features
                features_subtitle: '主要功能',
                features_title: '数字校友生态系统',
                feature1_title: '校友名录',
                feature1_desc: '找到同学、学长或学弟学妹。通过集成数据库轻松建立您的专业网络。',
                feature2_title: '追踪调查',
                feature2_desc: '您的参与有助于课程开发。使用现代且易于使用的界面填写问卷。',
                feature3_title: '职业中心',
                feature3_desc: '获得来自校友和合作伙伴的就业机会和合作机会的独家访问权。',
                // CTA
                cta_title: '您参与了吗？',
                cta_description: '您的数据是母校更美好未来的关键。花不到10分钟完成今年的追踪调查。',
                // Footer
                footer_description: '官方校友会平台，加强联系，促进母校发展。',
                footer_nav: '导航',
                footer_home: '首页',
                footer_support: '支持',
                footer_help: '帮助中心',
                footer_contact: '联系我们',
                footer_legal: '法律',
                footer_privacy: '隐私政策',
                footer_terms: '条款和条件',
                footer_copyright: '© 2026 校友信息系统。保留所有权利。'
            },
            ja: {
                // Navigation
                nav_features: '機能',
                nav_tracer: 'トレーサー調査',
                nav_news: 'ニュース',
                // Buttons
                btn_dashboard: 'ダッシュボード',
                btn_login: 'ログイン',
                btn_register: '登録',
                btn_to_dashboard: 'ダッシュボードへ',
                btn_start_now: '今すぐ始める',
                btn_learn_features: '機能を学ぶ',
                btn_start_survey: '調査を開始',
                btn_login_survey: 'ログインして調査に回答',
                // Hero
                hero_badge: '2024年トレーサー調査開始',
                hero_title_1: '再びつながる',
                hero_title_2: 'あなたの足跡',
                hero_description: '強力な同窓生ネットワークを構築し、キャリアの成功を追跡し、母校の発展に貢献します。',
                // Stats
                stat_alumni: '登録同窓生',
                stat_employment: '就職率',
                stat_partners: '提携企業',
                stat_since: '設立年',
                // Features
                features_subtitle: '主な機能',
                features_title: 'デジタル同窓生エコシステム',
                feature1_title: '同窓生名簿',
                feature1_desc: '同期生、先輩、後輩を探しましょう。統合データベースで簡単にプロフェッショナルネットワークを構築。',
                feature2_title: 'トレーサー調査',
                feature2_desc: 'あなたの参加がカリキュラム開発に役立ちます。モダンで使いやすいインターフェースでアンケートに回答。',
                feature3_title: 'キャリアセンター',
                feature3_desc: '同窓生やパートナーからの就職機会やコラボレーションの機会に独占的にアクセス。',
                // CTA
                cta_title: '参加しましたか？',
                cta_description: 'あなたのデータは母校のより良い未来への鍵です。今年のトレーサー調査を完了するのに10分もかかりません。',
                // Footer
                footer_description: '絆を強め、母校を発展させる公式同窓会プラットフォーム。',
                footer_nav: 'ナビゲーション',
                footer_home: 'ホーム',
                footer_support: 'サポート',
                footer_help: 'ヘルプセンター',
                footer_contact: 'お問い合わせ',
                footer_legal: '法的事項',
                footer_privacy: 'プライバシーポリシー',
                footer_terms: '利用規約',
                footer_copyright: '© 2026 同窓生情報システム。全著作権所有。'
            }
        };

        const langLabels = {
            id: 'ID',
            en: 'EN',
            ar: 'AR',
            zh: '中',
            ja: '日'
        };

        function setLanguage(lang) {
            const trans = translations[lang];
            if (!trans) return;

            // Update all elements with data-i18n attribute
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (trans[key]) {
                    el.textContent = trans[key];
                }
            });

            // Update html lang attribute
            document.documentElement.lang = lang;

            // Update language label
            const langLabel = document.getElementById('current-lang-label');
            if (langLabel) {
                langLabel.textContent = langLabels[lang] || lang.toUpperCase();
            }

            // Save preference to localStorage
            localStorage.setItem('preferred_language', lang);

            // Close dropdown
            document.querySelectorAll('[x-data]').forEach(el => {
                if (el.__x) el.__x.$data.open = false;
            });
        }

        // Load saved language on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedLang = localStorage.getItem('preferred_language') || 'id';
            setLanguage(savedLang);
        });
    </script>

    @fluxScripts
</body>
</html>
