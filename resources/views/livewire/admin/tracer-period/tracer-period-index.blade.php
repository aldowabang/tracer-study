<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <flux:heading size="xl">{{ __('Manajemen Periode Tracer') }}</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Kelola periode tracer study') }}</flux:text>
            </div>
            <flux:button variant="primary" :href="route('admin.tracer-periods.create')" wire:navigate icon="plus">
                {{ __('Tambah Periode') }}
            </flux:button>
        </div>

        {{-- Flash Message --}}
        @if (session('message'))
            <flux:callout variant="success" icon="check-circle">
                {{ session('message') }}
            </flux:callout>
        @endif

        {{-- Search --}}
        <div class="flex items-center gap-4">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="{{ __('Cari periode...') }}" icon="magnifying-glass" class="max-w-sm" />
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Tahun Lulusan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Tanggal Mulai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Tanggal Selesai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($periods as $period)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">{{ $period->judul }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $period->tahun_lulusan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ \Carbon\Carbon::parse($period->tgl_mulai)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ \Carbon\Carbon::parse($period->tgl_selesai)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:badge :color="$period->is_active ? 'green' : 'zinc'" size="sm">
                                    {{ $period->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button size="sm" variant="ghost" wire:click="toggleActive({{ $period->id }})" :icon="$period->is_active ? 'pause' : 'play'" />
                                    <flux:button size="sm" variant="ghost" :href="route('admin.tracer-periods.edit', $period->id)" wire:navigate icon="pencil" />
                                    <flux:button size="sm" variant="ghost" wire:click="delete({{ $period->id }})" wire:confirm="Apakah Anda yakin ingin menghapus periode ini? Semua pertanyaan terkait juga akan dihapus." icon="trash" class="text-red-600 hover:text-red-700" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                {{ __('Tidak ada periode tracer study.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $periods->links() }}
        </div>
    </div>
</div>
