<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl max-w-2xl">
        {{-- Header --}}
        <div class="flex items-center gap-4">
            <flux:button variant="ghost" :href="route('admin.alumni.index')" wire:navigate icon="arrow-left" />
            <div>
                <flux:heading size="xl">{{ __('Edit Alumni') }}</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Perbarui data alumni') }}</flux:text>
            </div>
        </div>

        {{-- Form --}}
        <form wire:submit="save" class="space-y-6">
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6 space-y-4">
                <flux:select wire:model="user_id" :label="__('User Account')" required>
                    <option value="">{{ __('Pilih User') }}</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </flux:select>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input wire:model="nim" :label="__('NIM')" type="text" required />
                    <flux:input wire:model="nama_lengkap" :label="__('Nama Lengkap')" type="text" required />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input wire:model="prodi" :label="__('Program Studi')" type="text" required />
                    <flux:input wire:model="tahun_lulus" :label="__('Tahun Lulus')" type="number" min="1900" :max="date('Y') + 1" required />
                </div>

                <flux:input wire:model="no_hp" :label="__('No. HP')" type="text" />

                <flux:textarea wire:model="alamat" :label="__('Alamat')" rows="3" />
            </div>

            <div class="flex items-center justify-end gap-4">
                <flux:button variant="ghost" :href="route('admin.alumni.index')" wire:navigate>{{ __('Batal') }}</flux:button>
                <flux:button variant="primary" type="submit">{{ __('Perbarui') }}</flux:button>
            </div>
        </form>
    </div>
</div>

