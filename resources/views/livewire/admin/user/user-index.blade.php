<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <flux:heading size="xl">{{ __('Manajemen User') }}</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Kelola user Admin dan Program Studi') }}</flux:text>
            </div>
            <flux:button variant="primary" :href="route('admin.users.create')" wire:navigate icon="plus">
                {{ __('Tambah User') }}
            </flux:button>
        </div>

        {{-- Flash Message --}}
        @if (session('message'))
            <flux:callout variant="success" icon="check-circle">
                {{ session('message') }}
            </flux:callout>
        @endif

        @if (session('error'))
            <flux:callout variant="danger" icon="x-circle">
                {{ session('error') }}
            </flux:callout>
        @endif

        {{-- Search --}}
        <div class="flex items-center gap-4">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="{{ __('Cari user...') }}" icon="magnifying-glass" class="max-w-sm" />
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Dibuat</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($users as $user)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $user->created_at?->format('d M Y') ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button size="sm" variant="filled" color="amber" :href="route('admin.users.edit', $user->id)" wire:navigate icon="pencil" />
                                    @if($user->id !== auth()->id())
                                        <flux:button size="sm" variant="filled" color="red" wire:click="delete({{ $user->id }})" wire:confirm="Apakah Anda yakin ingin menghapus user ini?" icon="trash" />
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                {{ __('Tidak ada data user.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
