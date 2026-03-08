<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Halo, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-zinc-500 dark:text-zinc-400">Selamat datang kembali di Dashboard Alumni.</p>
        </div>
        <div>
            <flux:button href="{{ route('profile.edit') }}" variant="outline" icon="user">Edit Profil</flux:button>
        </div>
    </div>

    @php
        $alumniProfile = \App\Models\AlumniProfile::where('user_id', Auth::id())->first();
        $isProfileComplete = $alumniProfile ? true : false;
        
        // This logic mimics the TracerPeriodList controller logic
        $activePeriod = null;
        $hasSubmitted = false;
        if($isProfileComplete) {
             $activePeriod = \App\Models\TracerPeriod::where('tahun_lulusan', $alumniProfile->tahun_lulus)
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->first();
             
             if ($activePeriod) {
                 $hasSubmitted = \App\Models\TracerParticipation::where('user_id', Auth::id())
                    ->where('tracer_period_id', $activePeriod->id)
                    ->where('status', '!=', 'belum_selesai') // Check if status is completed or verified
                    ->exists();
             }
        }
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Status Card -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Status -->
            @if(!$isProfileComplete)
            <div class="p-6 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-amber-100 dark:bg-amber-800/50 rounded-lg text-amber-600 dark:text-amber-400">
                        <flux:icon name="exclamation-triangle" class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-amber-900 dark:text-amber-100">Profil Belum Lengkap</h3>
                        <p class="text-amber-800 dark:text-amber-300 mt-1 mb-4">Silakan lengkapi data alumni Anda untuk dapat mengakses tracer study dan fitur lainnya.</p>
                        <flux:button href="{{ route('profile.edit') }}" variant="primary" class="bg-amber-600 hover:bg-amber-700 border-0">Lengkapi Profil Sekarang</flux:button>
                    </div>
                </div>
            </div>
            @endif

            <!-- Tracer Study Status -->
            <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Status Tracer Study</h3>
                
                @if($activePeriod)
                    @if($hasSubmitted)
                        <div class="flex items-center gap-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                            <div class="text-green-600 dark:text-green-400">
                                <flux:icon name="check-circle" class="w-8 h-8" />
                            </div>
                            <div>
                                <h4 class="font-bold text-green-900 dark:text-green-100">Terima Kasih!</h4>
                                <p class="text-sm text-green-800 dark:text-green-300">Anda telah menyelesaikan kuesioner Tracer Study untuk periode {{ $activePeriod->tahun_lulusan }}.</p>
                            </div>
                        </div>
                    @else
                        <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded mb-2">Aktif</span>
                                    <h4 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $activePeriod->nama_periode ?? 'Tracer Study Tahun Ini' }}</h4>
                                    <p class="text-sm text-zinc-500 mb-4">Periode pengisian berakhir pada {{ \Carbon\Carbon::parse($activePeriod->tanggal_berakhir)->format('d M Y') }}</p>
                                </div>
                                <div class="w-12 h-12 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center text-zinc-400">
                                    <flux:icon name="pencil-square" class="w-6 h-6" />
                                </div>
                            </div>
                            <flux:button href="{{ route('alumni.tracer-study', ['period_id' => $activePeriod->id]) }}" variant="primary" class="w-full justify-center">Mulai Isi Kuesioner</flux:button>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                        <flux:icon name="calendar" class="w-12 h-12 mx-auto mb-3 opacity-50" />
                        <p>Belum ada periode Tracer Study yang aktif untuk angkatan Anda saat ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar / Info -->

    </div>
</div>
