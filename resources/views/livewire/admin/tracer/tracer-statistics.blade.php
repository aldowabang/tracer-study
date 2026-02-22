<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <flux:heading size="xl">{{ __('Statistik Tracer Study') }}</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Analisa jawaban dan partisipasi alumni') }}</flux:text>
            </div>
            <div class="w-full sm:w-auto flex flex-col sm:flex-row items-center gap-4">
                <div class="w-full sm:w-64">
                    <flux:select wire:model.live="selectedPeriodId" :label="__('Pilih Periode')">
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}">{{ $period->nama_periode ?? 'Tahun Lulus ' . $period->tahun_lulusan }}</option>
                        @endforeach
                    </flux:select>
                </div>
                <div class="mt-6 sm:mt-0">
                    <flux:button variant="primary" color="green" icon="arrow-down-tray" wire:click="exportExcel">
                            {{ __('Export Excel') }}
                    </flux:button>
                </div>
            </div>
        </div>

        @if(empty($stats))
            <div class="p-12 text-center text-zinc-500 dark:text-zinc-400">
                <flux:icon name="chart-bar" class="w-12 h-12 mx-auto mb-4 opacity-50" />
                <p>{{ __('Tidak ada data statistik tersedia.') }}</p>
            </div>
        @else
            {{-- Stats Overview Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl">
                    <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Target Alumni</p>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">{{ $stats['total_target'] }}</h3>
                </div>
                <div class="p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl">
                    <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Partisipan</p>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">{{ $stats['total_participants'] }}</h3>
                </div>
                <div class="p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl">
                    <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Sedang Mengisi</p>
                    <h3 class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $stats['in_progress'] }}</h3>
                </div>
                <div class="p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl">
                    <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Selesai Isi</p>
                    <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $stats['completed'] }}</h3>
                </div>
                <div class="p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl">
                    <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Terverifikasi</p>
                    <h3 class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $stats['verified'] }}</h3>
                </div>
                <div class="p-4 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl text-white">
                    <p class="text-xs font-medium text-blue-100 uppercase tracking-wider">Response Rate</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $stats['response_rate'] }}%</h3>
                </div>
            </div>

            {{-- Question Analysis --}}
            <div class="space-y-6">
                <flux:heading size="lg">{{ __('Analisa Jawaban per Pertanyaan') }}</flux:heading>
                @forelse($questionStats as $qStat)
                    <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div>
                                @if($qStat['kode'])
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 rounded mb-2">{{ $qStat['kode'] }}</span>
                                @endif
                                <h4 class="font-medium text-zinc-900 dark:text-white">{{ $qStat['pertanyaan'] }}</h4>
                            </div>
                            <span class="text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">{{ $qStat['total_answers'] }} jawaban</span>
                        </div>

                        {{-- Horizontal Bar Chart --}}
                        <div class="space-y-3">
                            @foreach($qStat['distribution'] as $item)
                                <div>
                                    <div class="flex items-center justify-between text-sm mb-1">
                                        <span class="text-zinc-700 dark:text-zinc-300 truncate max-w-xs" title="{{ $item['label'] }}">{{ Str::limit($item['label'], 50) }}</span>
                                        <span class="text-zinc-500 dark:text-zinc-400 ml-2">{{ $item['count'] }} ({{ $item['percentage'] }}%)</span>
                                    </div>
                                    <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-3 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-500 ease-out
                                            @if($loop->index === 0) bg-blue-500
                                            @elseif($loop->index === 1) bg-indigo-500
                                            @elseif($loop->index === 2) bg-purple-500
                                            @elseif($loop->index === 3) bg-pink-500
                                            @elseif($loop->index === 4) bg-rose-500
                                            @else bg-zinc-500
                                            @endif"
                                            style="width: {{ $item['percentage'] }}%">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-zinc-500 dark:text-zinc-400 border border-dashed border-zinc-300 dark:border-zinc-700 rounded-xl">
                        <flux:icon name="clipboard-document-list" class="w-10 h-10 mx-auto mb-3 opacity-50" />
                        <p>{{ __('Tidak ada pertanyaan dengan pilihan ganda atau skala pada periode ini.') }}</p>
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</div>
