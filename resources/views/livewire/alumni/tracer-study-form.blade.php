<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <flux:heading size="xl">{{ __('Kuesioner Tracer Study') }}</flux:heading>
                @if ($period)
                    <flux:text class="text-zinc-500 dark:text-zinc-400">{{ $period->judul }}</flux:text>
                @else
                    <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Isi kuesioner tracer study untuk membantu peningkatan kualitas program studi.') }}</flux:text>
                @endif
            </div>
            @if ($hasSubmitted)
                <flux:badge color="green" icon="check-circle">{{ __('Sudah Diisi') }}</flux:badge>
            @endif
        </div>

        {{-- Flash Messages --}}
        @if (session('message'))
            <flux:callout variant="success" icon="check-circle">
                {{ session('message') }}
            </flux:callout>
        @endif

        {{-- No Period Available --}}
        @if ($noPeriodAvailable)
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-12 text-center">
                <div class="flex flex-col items-center gap-4">
                    <flux:icon name="exclamation-circle" class="size-16 text-zinc-400" />
                    <flux:heading>{{ __('Tidak Ada Kuesioner') }}</flux:heading>
                    <flux:text class="text-zinc-500 dark:text-zinc-400 max-w-md">
                        {{ __('Saat ini tidak ada kuesioner tracer study yang tersedia untuk tahun lulus Anda, atau profil alumni Anda belum lengkap.') }}
                    </flux:text>
                    <flux:button variant="primary" href="{{ route('settings.profile') }}" wire:navigate>
                        {{ __('Lengkapi Profil') }}
                    </flux:button>
                </div>
            </div>
        @elseif (!$hasStarted && !$hasSubmitted)
            {{-- Intro Card --}}
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden">
                {{-- Header with gradient --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/20 mb-6">
                        <flux:icon name="clipboard-document-list" class="size-10 text-white" />
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $period->judul }}</h1>
                    <p class="text-blue-100">{{ __('Kuesioner Tracer Study') }}</p>
                </div>

                {{-- Period Info --}}
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="text-center p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                            <flux:icon name="calendar" class="size-8 text-blue-600 dark:text-blue-400 mx-auto mb-2" />
                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ __('Tahun Lulusan') }}</flux:text>
                            <p class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mt-1">{{ $period->tahun_lulusan }}</p>
                        </div>
                        <div class="text-center p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                            <flux:icon name="document-text" class="size-8 text-blue-600 dark:text-blue-400 mx-auto mb-2" />
                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ __('Jumlah Bagian') }}</flux:text>
                            <p class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mt-1">{{ $totalSteps }} {{ __('Bagian') }}</p>
                        </div>
                        <div class="text-center p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                            <flux:icon name="clock" class="size-8 text-blue-600 dark:text-blue-400 mx-auto mb-2" />
                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ __('Estimasi Waktu') }}</flux:text>
                            <p class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mt-1">15-20 {{ __('Menit') }}</p>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="mb-8">
                        <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 mb-3">{{ __('Tentang Kuesioner Ini') }}</h3>
                        <flux:text class="text-zinc-600 dark:text-zinc-400 leading-relaxed">
                            {{ __('Kuesioner tracer study ini bertujuan untuk melacak perkembangan karier dan pengalaman alumni setelah lulus. Data yang Anda berikan akan membantu program studi dalam meningkatkan kualitas pendidikan dan relevansi kurikulum dengan kebutuhan dunia kerja.') }}
                        </flux:text>
                    </div>

                    {{-- Sections Preview --}}
                    <div class="mb-8">
                        <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 mb-3">{{ __('Bagian Kuesioner') }}</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach ($sectionKeys as $sectionName)
                                <div class="flex items-center gap-2 p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 text-xs font-medium text-blue-700 dark:text-blue-300">
                                        {{ Str::before($sectionName, '.') }}
                                    </span>
                                    <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ Str::after($sectionName, '. ') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Alumni Info --}}
                    @if ($alumniProfile)
                        <div class="p-4 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50 mb-8">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30">
                                    <flux:icon name="user-circle" class="size-6 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $alumniProfile->nama_lengkap }}</p>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $alumniProfile->nim }} • {{ $alumniProfile->prodi }} • {{ __('Lulus') }} {{ $alumniProfile->tahun_lulus }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Start Button --}}
                    <div class="text-center">
                        <flux:button variant="primary" wire:click="startQuestionnaire" icon="arrow-right" class="px-8">
                            {{ __('Mulai Mengisi Kuesioner') }}
                        </flux:button>
                    </div>
                </div>
            </div>
        @elseif ($hasSubmitted)
            {{-- Success State --}}
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden">
                {{-- Alumni Profile Info --}}
                @if ($alumniProfile)
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30">
                                <flux:icon name="user-circle" class="size-6 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <flux:heading size="lg">{{ $alumniProfile->nama_lengkap }}</flux:heading>
                                <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Data Responden') }}</flux:text>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                                <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ __('NIM') }}</flux:text>
                                <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mt-1">{{ $alumniProfile->nim }}</p>
                            </div>
                            <div class="p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                                <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ __('Program Studi') }}</flux:text>
                                <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mt-1">{{ $alumniProfile->prodi }}</p>
                            </div>
                            <div class="p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                                <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ __('Tahun Lulus') }}</flux:text>
                                <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mt-1">{{ $alumniProfile->tahun_lulus }}</p>
                            </div>
                            <div class="p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                                <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ __('Periode Tracer') }}</flux:text>
                                <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mt-1">{{ $period->tahun_lulusan }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="p-12 text-center">
                    <flux:icon name="check-circle" class="size-16 text-green-600 dark:text-green-400 mx-auto mb-4" />
                    <flux:heading size="lg" class="text-green-800 dark:text-green-200">{{ __('Terima Kasih!') }}</flux:heading>
                    <flux:text class="text-zinc-600 dark:text-zinc-300 mt-2 max-w-md mx-auto">
                        {{ __('Jawaban kuesioner Anda telah tersimpan. Anda dapat mengubah jawaban dengan mengklik tombol di bawah.') }}
                    </flux:text>
                    <div class="mt-6">
                        <flux:button variant="primary" wire:click="edit" icon="pencil-square">
                            {{ __('Edit Jawaban') }}
                        </flux:button>
                    </div>
                </div>
            </div>
        @else
            {{-- Alumni Profile Info --}}
            @if ($alumniProfile)
                <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30">
                            <flux:icon name="user-circle" class="size-6 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div>
                            <flux:heading size="lg">{{ $alumniProfile->nama_lengkap }}</flux:heading>
                            <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Data Responden') }}</flux:text>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ __('NIM') }}</flux:text>
                            <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mt-1">{{ $alumniProfile->nim }}</p>
                        </div>
                        <div class="p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ __('Program Studi') }}</flux:text>
                            <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mt-1">{{ $alumniProfile->prodi }}</p>
                        </div>
                        <div class="p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ __('Tahun Lulus') }}</flux:text>
                            <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mt-1">{{ $alumniProfile->tahun_lulus }}</p>
                        </div>
                        <div class="p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ __('Periode Tracer') }}</flux:text>
                            <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mt-1">{{ $period->tahun_lulusan }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Step Progress Indicator --}}
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6">
                <div class="flex items-center justify-between mb-4">
                    <flux:text class="font-medium">{{ __('Progress Pengisian') }}</flux:text>
                    <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">
                        {{ __('Bagian :current dari :total', ['current' => $currentStep + 1, 'total' => $totalSteps]) }}
                    </flux:text>
                </div>
                
                {{-- Progress Bar --}}
                <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-2 mb-4">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ (($currentStep + 1) / $totalSteps) * 100 }}%"></div>
                </div>
                
                {{-- Step Buttons --}}
                <div class="flex flex-wrap gap-2">
                    @foreach ($sectionKeys as $index => $sectionName)
                        <button 
                            wire:click="goToStep({{ $index }})"
                            class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors
                                {{ $index === $currentStep 
                                    ? 'bg-blue-600 text-white' 
                                    : ($index < $currentStep 
                                        ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' 
                                        : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700') }}"
                        >
                            {{ Str::before($sectionName, '.') }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Current Section Form --}}
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden">
                {{-- Section Header --}}
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">{{ $currentSectionName }}</h2>
                </div>

                {{-- Section Questions --}}
                <div class="p-6 space-y-6">
                    @foreach ($currentSectionQuestions as $question)
                        <div class="space-y-3 @if (!$loop->last) pb-6 border-b border-zinc-100 dark:border-zinc-800 @endif">
                            {{-- Question Label --}}
                            <div class="flex items-start gap-3">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-sm font-medium text-blue-700 dark:text-blue-300 flex-shrink-0">
                                    {{ $question->urutan }}
                                </span>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $question->pertanyaan }}
                                        @if ($question->wajib_diisi)
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </label>
                                    @if ($question->kode_dikti)
                                        <span class="text-xs text-zinc-400">({{ $question->kode_dikti }})</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Answer Input based on Type --}}
                            <div class="ml-11">
                                @if ($question->tipe === 'text')
                                    <flux:input 
                                        type="text" 
                                        wire:model="answers.{{ $question->id }}"
                                        placeholder="Masukkan jawaban..."
                                    />
                                @elseif ($question->tipe === 'number')
                                    <flux:input 
                                        type="number" 
                                        wire:model="answers.{{ $question->id }}"
                                        placeholder="0"
                                        step="0.01"
                                        class="max-w-xs"
                                    />
                                @elseif ($question->tipe === 'textarea')
                                    <flux:textarea 
                                        wire:model="answers.{{ $question->id }}"
                                        placeholder="Tuliskan jawaban Anda..."
                                        rows="3"
                                    />
                                @elseif ($question->tipe === 'radio')
                                    <div class="space-y-2">
                                        @foreach ($question->tracerOptions->sortBy('urutan') as $option)
                                            <label class="flex items-center gap-3 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 cursor-pointer transition-colors {{ isset($answers[$question->id]) && $answers[$question->id] == $option->id ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-300 dark:border-blue-700' : '' }}">
                                                <input 
                                                    type="radio" 
                                                    wire:model.live="answers.{{ $question->id }}"
                                                    value="{{ $option->id }}"
                                                    class="w-4 h-4 text-blue-600 border-zinc-300 focus:ring-blue-500"
                                                />
                                                <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $option->label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif ($question->tipe === 'checkbox')
                                    <div class="space-y-2">
                                        @foreach ($question->tracerOptions->sortBy('urutan') as $option)
                                            @php
                                                $isChecked = isset($answers[$question->id]) && is_array($answers[$question->id]) && in_array((string) $option->id, $answers[$question->id]);
                                            @endphp
                                            <label class="flex items-center gap-3 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 cursor-pointer transition-colors {{ $isChecked ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-300 dark:border-blue-700' : '' }}">
                                                <input 
                                                    type="checkbox" 
                                                    wire:model.live="answers.{{ $question->id }}"
                                                    value="{{ $option->id }}"
                                                    class="w-4 h-4 text-blue-600 border-zinc-300 rounded focus:ring-blue-500"
                                                />
                                                <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $option->label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif ($question->tipe === 'scale')
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($question->tracerOptions->sortBy('urutan') as $option)
                                            <label class="flex-1 min-w-[80px] max-w-[120px] cursor-pointer">
                                                <input 
                                                    type="radio" 
                                                    wire:model.live="answers.{{ $question->id }}"
                                                    value="{{ $option->id }}"
                                                    class="sr-only peer"
                                                />
                                                <div class="p-3 text-center rounded-lg border border-zinc-200 dark:border-zinc-700 peer-checked:bg-blue-600 peer-checked:border-blue-600 peer-checked:text-white hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                                    <span class="block text-lg font-bold">{{ $option->value }}</span>
                                                    <span class="block text-xs mt-1">{{ Str::after($option->label, ' - ') }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif ($question->tipe === 'select')
                                    <flux:select wire:model="answers.{{ $question->id }}">
                                        <option value="">{{ __('-- Pilih --') }}</option>
                                        @foreach ($question->tracerOptions->sortBy('urutan') as $option)
                                            <option value="{{ $option->id }}">{{ $option->label }}</option>
                                        @endforeach
                                    </flux:select>
                                @endif

                                {{-- Error Message --}}
                                @error('answers.' . $question->id)
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Navigation Buttons --}}
            <div class="flex items-center justify-between p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
                <div>
                    @if ($currentStep > 0)
                        <flux:button variant="ghost" wire:click="previousStep" icon="arrow-left">
                            {{ __('Sebelumnya') }}
                        </flux:button>
                    @endif
                </div>
                
                <div class="flex items-center gap-3">
                    @if ($currentStep < $totalSteps - 1)
                        <flux:button variant="primary" wire:click="nextStep" icon-trailing="arrow-right">
                            {{ __('Selanjutnya') }}
                        </flux:button>
                    @else
                        <flux:button variant="primary" wire:click="submit" icon="paper-airplane">
                            {{ __('Kirim Jawaban') }}
                        </flux:button>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
