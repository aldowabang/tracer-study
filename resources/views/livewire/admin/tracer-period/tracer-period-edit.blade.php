<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl max-w-2xl">
        {{-- Header --}}
        <div class="flex items-center gap-4">
            <flux:button variant="ghost" :href="route('admin.tracer-periods.index')" wire:navigate icon="arrow-left" />
            <div>
                <flux:heading size="xl">{{ __('Edit Periode Tracer') }}</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Perbarui periode tracer study') }}</flux:text>
            </div>
        </div>

        {{-- Form --}}
        <form wire:submit="save" class="space-y-6">
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6 space-y-4">
                <flux:input wire:model="judul" :label="__('Judul Periode')" type="text" placeholder="Tracer Study Lulusan 2024" required />

                <flux:input wire:model="tahun_lulusan" :label="__('Tahun Lulusan')" type="text" placeholder="2024" required />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input wire:model="tgl_mulai" :label="__('Tanggal Mulai')" type="date" required />
                    <flux:input wire:model="tgl_selesai" :label="__('Tanggal Selesai')" type="date" required />
                </div>

                <flux:checkbox wire:model="is_active" :label="__('Aktifkan Periode')" />
            </div>

            <div class="flex items-center justify-end gap-4">
                <flux:button variant="ghost" :href="route('admin.tracer-periods.index')" wire:navigate>{{ __('Batal') }}</flux:button>
                <flux:button variant="primary" type="submit">{{ __('Perbarui') }}</flux:button>
            </div>
        </form>
    </div>
</div>

