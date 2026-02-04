<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Dashboard Program Studi</h1>
        <p class="text-zinc-500 dark:text-zinc-400">Pantau perkembangan alumni dan laporan tracer study.</p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm hover:border-blue-500/50 transition-colors">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg text-blue-600 dark:text-blue-400">
                    <flux:icon name="academic-cap" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Alumni Prodi</p>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">
                        {{-- Placeholder: Replace with actual query filtering by prodi if available --}}
                        {{ \App\Models\AlumniProfile::count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm hover:border-green-500/50 transition-colors">
            <div class="flex items-center gap-4">
                <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-lg text-green-600 dark:text-green-400">
                    <flux:icon name="chart-pie" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Response Rate</p>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">
                        {{-- Calculation placeholder --}}
                        85%
                    </h3>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm hover:border-purple-500/50 transition-colors">
            <div class="flex items-center gap-4">
                <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg text-purple-600 dark:text-purple-400">
                    <flux:icon name="clock" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Waktu Tunggu (Rata-rata)</p>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">3.5 Bln</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Reports Section -->
        <div class="lg:col-span-2 space-y-6">
            <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Laporan Terbaru</h3>
                    <flux:button variant="ghost" size="sm" icon="arrow-right">Lihat Semua</flux:button>
                </div>
                
                <div class="space-y-3">
                    <div class="flex items-center gap-4 p-3 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded-lg transition-colors border border-zinc-100 dark:border-zinc-800/50">
                        <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center text-red-600 dark:text-red-400">
                            <flux:icon name="document-text" class="w-5 h-5" />
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-zinc-900 dark:text-white">Laporan Tracer Study 2023</h4>
                            <p class="text-xs text-zinc-500">Generated on Feb 01, 2024</p>
                        </div>
                        <flux:button variant="subtle" size="sm" icon="arrow-down-tray"></flux:button>
                    </div>
                    
                    <div class="flex items-center gap-4 p-3 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded-lg transition-colors border border-zinc-100 dark:border-zinc-800/50">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400">
                            <flux:icon name="document-text" class="w-5 h-5" />
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-zinc-900 dark:text-white">Statistik Kepuasan Pengguna</h4>
                            <p class="text-xs text-zinc-500">Generated on Jan 15, 2024</p>
                        </div>
                        <flux:button variant="subtle" size="sm" icon="arrow-down-tray"></flux:button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification/Activity -->
        <div class="lg:col-span-1">
            <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm h-full">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Notifikasi</h3>
                <div class="space-y-6 relative before:absolute before:left-4 before:top-2 before:bottom-2 before:w-0.5 before:bg-zinc-200 dark:before:bg-zinc-800">
                    <div class="relative pl-10">
                        <div class="absolute left-[11px] top-1 w-3 h-3 bg-blue-500 rounded-full ring-4 ring-white dark:ring-zinc-900"></div>
                        <p class="text-sm text-zinc-900 dark:text-white font-medium">Periode Tracer Baru Dimulai</p>
                        <p class="text-xs text-zinc-500 mt-1">2 jam yang lalu</p>
                    </div>
                    <div class="relative pl-10">
                        <div class="absolute left-[11px] top-1 w-3 h-3 bg-green-500 rounded-full ring-4 ring-white dark:ring-zinc-900"></div>
                        <p class="text-sm text-zinc-900 dark:text-white font-medium">15 Alumni Baru Mengisi Kuesioner</p>
                        <p class="text-xs text-zinc-500 mt-1">Hari ini</p>
                    </div>
                    <div class="relative pl-10">
                        <div class="absolute left-[11px] top-1 w-3 h-3 bg-zinc-300 dark:bg-zinc-700 rounded-full ring-4 ring-white dark:ring-zinc-900"></div>
                        <p class="text-sm text-zinc-900 dark:text-white font-medium">Batas Waktu Pengisian Diperpanjang</p>
                        <p class="text-xs text-zinc-500 mt-1">Kemarin</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
