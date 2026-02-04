<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl max-w-2xl">
        {{-- Header --}}
        <div class="flex items-center gap-4">
            <flux:button variant="ghost" :href="route('admin.users.index')" wire:navigate icon="arrow-left" />
            <div>
                <flux:heading size="xl">{{ __('Tambah User') }}</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Tambah user Admin atau Program Studi') }}</flux:text>
            </div>
        </div>

        {{-- Form --}}
        <form wire:submit="save" class="space-y-6">
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6 space-y-4">
                <flux:input wire:model="name" :label="__('Nama Lengkap')" type="text" required />

                <flux:input wire:model="email" :label="__('Email')" type="email" required />

                <flux:select wire:model="role" :label="__('Role')" required>
                    <option value="prodi">Program Studi</option>
                    <option value="admin">Admin</option>
                </flux:select>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input wire:model="password" :label="__('Password')" type="password" required />
                    <flux:input wire:model="password_confirmation" :label="__('Konfirmasi Password')" type="password" required />
                </div>
            </div>

            <div class="flex items-center justify-end gap-4">
                <flux:button variant="ghost" :href="route('admin.users.index')" wire:navigate>{{ __('Batal') }}</flux:button>
                <flux:button variant="primary" type="submit">{{ __('Simpan') }}</flux:button>
            </div>
        </form>
    </div>
</div>
