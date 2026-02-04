<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Admin Dashboard</h1>
        <p class="text-zinc-500 dark:text-zinc-400">Overview statistik dan manajemen data alumni.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                    <flux:icon name="users" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Alumni</p>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ \App\Models\AlumniProfile::count() }}</h3>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg text-green-600 dark:text-green-400">
                    <flux:icon name="document-text" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Tracer Periode</p>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ \App\Models\TracerPeriod::count() }}</h3>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg text-purple-600 dark:text-purple-400">
                    <flux:icon name="chart-bar" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Partisipasi</p>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ \App\Models\TracerAnswer::distinct('user_id')->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-orange-100 dark:bg-orange-900/30 rounded-lg text-orange-600 dark:text-orange-400">
                    <flux:icon name="user" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">User Baru</p>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ \App\Models\User::where('created_at', '>=', now()->subDays(7))->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Quick Actions -->
        <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.alumni.create') }}" class="flex flex-col items-center justify-center p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                    <flux:icon name="user-plus" class="w-6 h-6 text-blue-600 mb-2" />
                    <span class="text-sm font-medium">Tambah Alumni</span>
                </a>
                <a href="{{ route('admin.tracer-periods.create') }}" class="flex flex-col items-center justify-center p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                    <flux:icon name="calendar-days" class="w-6 h-6 text-green-600 mb-2" />
                    <span class="text-sm font-medium">Buat Periode Tracer</span>
                </a>
                <a href="{{ route('admin.tracer-questions.index') }}" class="flex flex-col items-center justify-center p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                    <flux:icon name="clipboard-document-list" class="w-6 h-6 text-purple-600 mb-2" />
                    <span class="text-sm font-medium">Atur Pertanyaan</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                    <flux:icon name="arrow-down-tray" class="w-6 h-6 text-orange-600 mb-2" />
                    <span class="text-sm font-medium">Export Laporan</span>
                </a>
            </div>
        </div>

        <!-- Recent Activities (Placeholder) -->
        <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                    <div class="flex items-center gap-3 pb-3 border-b border-zinc-100 dark:border-zinc-800 last:border-0 last:pb-0">
                        <div class="w-8 h-8 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-xs font-bold">
                            {{ $user->initials() }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $user->name }}</p>
                            <p class="text-xs text-zinc-500">Mendaftar sebagai {{ $user->role }}</p>
                        </div>
                        <span class="text-xs text-zinc-400">{{ $user->created_at?->diffForHumans() ?? '-' }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
