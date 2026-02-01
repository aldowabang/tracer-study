<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <flux:heading size="xl">{{ __('Periode Tracer Study') }}</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Daftar kuesioner tracer study yang tersedia untuk Anda.') }}</flux:text>
            </div>
        </div>

        {{-- No Alumni Profile --}}
        @if (!$alumniProfile)
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-12 text-center">
                <div class="flex flex-col items-center gap-4">
                    <flux:icon name="exclamation-circle" class="size-16 text-zinc-400" />
                    <flux:heading>{{ __('Profil Belum Lengkap') }}</flux:heading>
                    <flux:text class="text-zinc-500 dark:text-zinc-400 max-w-md">
                        {{ __('Silakan lengkapi profil alumni Anda terlebih dahulu untuk melihat kuesioner yang tersedia.') }}
                    </flux:text>
                    <flux:button variant="primary" href="{{ route('settings.profile') }}" wire:navigate>
                        {{ __('Lengkapi Profil') }}
                    </flux:button>
                </div>
            </div>
        @elseif ($periods->isEmpty())
            {{-- No Periods Available --}}
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-12 text-center">
                <div class="flex flex-col items-center gap-4">
                    <flux:icon name="document-text" class="size-16 text-zinc-400" />
                    <flux:heading>{{ __('Belum Ada Kuesioner') }}</flux:heading>
                    <flux:text class="text-zinc-500 dark:text-zinc-400 max-w-md">
                        {{ __('Saat ini belum ada kuesioner tracer study yang tersedia untuk tahun lulus Anda.') }}
                    </flux:text>
                </div>
            </div>
        @else
            {{-- Alumni Info Card --}}
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-14 h-14 rounded-full bg-blue-100 dark:bg-blue-900/30">
                        <flux:icon name="user-circle" class="size-7 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div class="flex-1">
                        <flux:heading size="lg">{{ $alumniProfile->nama_lengkap }}</flux:heading>
                        <flux:text class="text-zinc-500 dark:text-zinc-400">
                            {{ $alumniProfile->nim }} • {{ $alumniProfile->prodi }} • {{ __('Lulus') }} {{ $alumniProfile->tahun_lulus }}
                        </flux:text>
                    </div>
                    <div class="text-right">
                        <flux:badge color="blue">{{ $periods->count() }} {{ __('Kuesioner') }}</flux:badge>
                    </div>
                </div>
            </div>

            {{-- Periods Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($periods as $period)
                    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden hover:shadow-lg transition-shadow">
                        {{-- Card Header --}}
                        <div class="bg-gradient-to-r {{ $period->is_active ? 'from-blue-600 to-indigo-600' : 'from-zinc-500 to-zinc-600' }} px-6 py-4">
                            <div class="flex items-center justify-between">
                                <flux:icon name="clipboard-document-list" class="size-8 text-white/80" />
                                @if ($period->has_submitted)
                                    <flux:badge color="green" icon="check-circle">{{ __('Sudah Diisi') }}</flux:badge>
                                @elseif ($period->is_active)
                                    <flux:badge color="yellow" icon="clock">{{ __('Belum Diisi') }}</flux:badge>
                                @else
                                    <flux:badge color="zinc">{{ __('Ditutup') }}</flux:badge>
                                @endif
                            </div>
                            <h3 class="text-lg font-semibold text-white mt-3">{{ $period->judul }}</h3>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-6">
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center justify-between">
                                    <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Tahun Lulusan') }}</flux:text>
                                    <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $period->tahun_lulusan }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Jumlah Pertanyaan') }}</flux:text>
                                    <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $period->questions_count }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Status') }}</flux:text>
                                    @if ($period->is_active)
                                        <span class="inline-flex items-center gap-1 text-sm font-medium text-green-600 dark:text-green-400">
                                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                            {{ __('Aktif') }}
                                        </span>
                                    @else
                                        <span class="text-sm font-medium text-zinc-500">{{ __('Tidak Aktif') }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Action Button --}}
                            @if ($period->is_active)
                                <flux:button 
                                    variant="{{ $period->has_submitted ? 'outline' : 'primary' }}" 
                                    href="{{ route('alumni.tracer-study') }}" 
                                    wire:navigate 
                                    class="w-full"
                                    icon="{{ $period->has_submitted ? 'pencil-square' : 'arrow-right' }}"
                                >
                                    {{ $period->has_submitted ? __('Lihat/Edit Jawaban') : __('Isi Kuesioner') }}
                                </flux:button>
                            @else
                                <flux:button variant="ghost" disabled class="w-full">
                                    {{ __('Kuesioner Ditutup') }}
                                </flux:button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
