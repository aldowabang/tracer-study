<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        @if(Auth::user()->role === 'admin')
            @include('dashboard.admin')
        @elseif(Auth::user()->role === 'prodi')
            @include('dashboard.prodi')
        @elseif(Auth::user()->role === 'alumni')
            @include('dashboard.alumni')
        @else
            {{-- Fallback or Default Dashboard --}}
            <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Dashboard</h1>
                <p class="text-zinc-500 dark:text-zinc-400">Selamat datang, {{ Auth::user()->name }}!</p>
            </div>
        @endif
    </div>
</x-layouts::app>
