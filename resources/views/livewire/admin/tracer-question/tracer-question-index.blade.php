<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <flux:heading size="xl">{{ __('Manajemen Pertanyaan Tracer') }}</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Kelola pertanyaan tracer study') }}</flux:text>
            </div>
            <flux:button variant="primary" :href="route('admin.tracer-questions.create')" wire:navigate icon="plus">
                {{ __('Tambah Pertanyaan') }}
            </flux:button>
        </div>

        {{-- Flash Message --}}
        @if (session('message'))
            <flux:callout variant="success" icon="check-circle">
                {{ session('message') }}
            </flux:callout>
        @endif

        {{-- Filters --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="{{ __('Cari pertanyaan...') }}" icon="magnifying-glass" class="max-w-sm" />
            <flux:select wire:model.live="filterPeriod" class="max-w-xs">
                <option value="">{{ __('Semua Periode') }}</option>
                @foreach ($periods as $period)
                    <option value="{{ $period->id }}">{{ $period->judul }}</option>
                @endforeach
            </flux:select>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Urutan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Kode Dikti</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Pertanyaan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Opsi</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($questions as $question)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">{{ $question->urutan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $question->kode_dikti ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100 max-w-xs truncate">{{ Str::limit($question->pertanyaan, 50) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:badge color="blue" size="sm">{{ ucfirst($question->tipe) }}</flux:badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $question->tracerPeriod->judul ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $question->tracerOptions->count() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button size="sm" variant="ghost" :href="route('admin.tracer-questions.edit', $question->id)" wire:navigate icon="pencil" />
                                    <flux:button size="sm" variant="ghost" wire:click="delete({{ $question->id }})" wire:confirm="Apakah Anda yakin ingin menghapus pertanyaan ini?" icon="trash" class="text-red-600 hover:text-red-700" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                {{ __('Tidak ada pertanyaan tracer study.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $questions->links() }}
        </div>
    </div>
</div>
