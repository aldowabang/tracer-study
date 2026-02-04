<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                {{-- Admin & Prodi Management Menu --}}
                @if(in_array(auth()->user()->role, ['admin', 'prodi']))
                <flux:sidebar.group :heading="__('Manajemen')" class="grid">
                    <flux:sidebar.item icon="users" :href="route('admin.alumni.index')" :current="request()->routeIs('admin.alumni.*')" wire:navigate>
                        {{ __('Data Alumni') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="calendar" :href="route('admin.tracer-periods.index')" :current="request()->routeIs('admin.tracer-periods.*')" wire:navigate>
                        {{ __('Periode Tracer') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="question-mark-circle" :href="route('admin.tracer-questions.index')" :current="request()->routeIs('admin.tracer-questions.*')" wire:navigate>
                        {{ __('Pertanyaan Tracer') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="list-bullet" :href="route('admin.tracer-options.index')" :current="request()->routeIs('admin.tracer-options.*')" wire:navigate>
                        {{ __('Opsi Jawaban') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="chart-bar" :href="route('admin.tracer-statistics')" :current="request()->routeIs('admin.tracer-statistics')" wire:navigate>
                        {{ __('Statistik & Analisa') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
                @endif

                {{-- Admin Only: User Management --}}
                @if(auth()->user()->role === 'admin')
                <flux:sidebar.group :heading="__('Pengaturan')" class="grid">
                    <flux:sidebar.item icon="user-plus" :href="route('admin.users.index')" :current="request()->routeIs('admin.users.*')" wire:navigate>
                        {{ __('Manajemen User') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
                @endif

                {{-- Alumni Menu --}}
                @if(auth()->user()->role === 'alumni')
                <flux:sidebar.group :heading="__('Tracer Study')" class="grid">
                    <flux:sidebar.item icon="calendar-days" :href="route('alumni.tracer-periods')" :current="request()->routeIs('alumni.tracer-periods')" wire:navigate>
                        {{ __('Periode Tracer') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
                @endif
            </flux:sidebar.nav>

            <flux:spacer />

            {{-- Dark Mode Toggle - Desktop --}}
            <div class="hidden lg:flex px-4 py-2 border-t border-zinc-200 dark:border-zinc-700">
                <button
                    x-data
                    @click="$flux.appearance = $flux.dark ? 'light' : 'dark'"
                    class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all duration-200"
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
                    <span x-text="$flux.dark ? 'Light Mode' : 'Dark Mode'" class="text-sm font-medium"></span>
                </button>
            </div>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            {{-- Dark Mode Toggle - Mobile --}}
            <button
                x-data
                @click="$flux.appearance = $flux.dark ? 'light' : 'dark'"
                class="p-2.5 mr-2 rounded-lg text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all duration-200"
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

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
