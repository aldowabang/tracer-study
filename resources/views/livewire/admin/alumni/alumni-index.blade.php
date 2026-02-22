<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <flux:heading size="xl">{{ __('Manajemen Alumni') }}</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Kelola data alumni') }}</flux:text>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <flux:button variant="primary" icon="arrow-down-tray" color="sky" wire:click="exportExcel">
                    {{ __('Export Excel') }}
                </flux:button>

                <flux:modal.trigger name="import-excel">
                    <flux:button variant="primary" icon="arrow-up-tray" color="green">
                        {{ __('Import Excel') }}
                    </flux:button>
                </flux:modal.trigger>

                <flux:button variant="primary" :href="route('admin.alumni.create')" wire:navigate icon="plus">
                    {{ __('Tambah Alumni') }}
                </flux:button>
            </div>
        </div>

        {{-- Import Excel Modal --}}
        <flux:modal name="import-excel" class="md:w-96">
            <form wire:submit="importExcel" class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ __('Import Data Alumni') }}</flux:heading>
                    <flux:text class="text-sm mt-2">
                        Unggah file Excel (.xlsx, .xls, .csv). Pastikan baris pertama (header) sesuai dengan format berikut:
                        <br><br>
                        <code class="text-xs bg-zinc-100 dark:bg-zinc-800 p-1 rounded font-mono break-all">nim, nama_lengkap, email, prodi, tahun_lulus, no_hp, alamat</code>
                    </flux:text>
                    
                    @error('excelFile')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <input type="file" wire:model="excelFile" accept=".xlsx,.xls,.csv" required class="block w-full text-sm text-zinc-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100
                        dark:file:bg-zinc-800 dark:file:text-zinc-300
                    " />
                    <div wire:loading wire:target="excelFile" class="text-sm text-indigo-500 mt-2">Uploading...</div>
                </div>

                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">{{ __('Batal') }}</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">
                        <span wire:loading.remove wire:target="importExcel">{{ __('Import') }}</span>
                        <span wire:loading wire:target="importExcel">{{ __('Mengimport...') }}</span>
                    </flux:button>
                </div>
            </form>
        </flux:modal>

        {{-- Flash Message --}}
        @if (session('message'))
            <flux:callout variant="success" icon="check-circle">
                {{ session('message') }}
            </flux:callout>
        @endif

        {{-- Search --}}
        <div class="flex items-center gap-4">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="{{ __('Cari alumni...') }}" icon="magnifying-glass" class="max-w-sm" />
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIM</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Prodi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Tahun Lulus</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">No HP</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($alumniList as $alumni)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">{{ $alumni->nim }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">{{ $alumni->nama_lengkap }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $alumni->prodi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $alumni->tahun_lulus }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $alumni->no_hp ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button size="sm" variant="filled" color="sky" wire:click="viewAlumni({{ $alumni->id }})" icon="eye" />
                                    <flux:button size="sm" variant="filled" color="amber" :href="route('admin.alumni.edit', $alumni->id)" wire:navigate icon="pencil" />
                                    <flux:button size="sm" variant="filled" color="red" wire:click="delete({{ $alumni->id }})" wire:confirm="Apakah Anda yakin ingin menghapus data alumni ini?" icon="trash" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                {{ __('Tidak ada data alumni.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- View Detail Modal --}}
        <flux:modal name="view-alumni" class="md:w-[32rem]">
            @if($selectedAlumni)
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">{{ __('Detail Alumni') }}</flux:heading>
                        <flux:text class="text-sm mt-1">{{ __('Informasi lengkap alumni mahasiswa.') }}</flux:text>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <span class="block text-xs font-semibold text-zinc-500 uppercase tracking-wide">NIM</span>
                            <span class="block text-sm text-zinc-900 dark:text-zinc-100 mt-1">{{ $selectedAlumni->nim }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-zinc-500 uppercase tracking-wide">Nama Lengkap</span>
                            <span class="block text-sm text-zinc-900 dark:text-zinc-100 mt-1">{{ $selectedAlumni->nama_lengkap }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-zinc-500 uppercase tracking-wide">Email</span>
                            <span class="block text-sm text-zinc-900 dark:text-zinc-100 mt-1">{{ optional($selectedAlumni->user)->email ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-zinc-500 uppercase tracking-wide">Prodi</span>
                            <span class="block text-sm text-zinc-900 dark:text-zinc-100 mt-1">{{ $selectedAlumni->prodi }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-zinc-500 uppercase tracking-wide">Tahun Lulus</span>
                            <span class="block text-sm text-zinc-900 dark:text-zinc-100 mt-1">{{ $selectedAlumni->tahun_lulus }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-zinc-500 uppercase tracking-wide">No HP</span>
                            <span class="block text-sm text-zinc-900 dark:text-zinc-100 mt-1">{{ $selectedAlumni->no_hp ?? '-' }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="block text-xs font-semibold text-zinc-500 uppercase tracking-wide">Alamat</span>
                            <span class="block text-sm text-zinc-900 dark:text-zinc-100 mt-1 whitespace-pre-wrap">{{ $selectedAlumni->alamat ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <flux:modal.close>
                            <flux:button variant="ghost">{{ __('Tutup') }}</flux:button>
                        </flux:modal.close>
                    </div>
                </div>
            @endif
        </flux:modal>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $alumniList->links() }}
        </div>
    </div>
</div>

