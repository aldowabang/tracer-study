<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl max-w-2xl">
        {{-- Header --}}
        <div class="flex items-center gap-4">
            <flux:button variant="ghost" :href="route('admin.tracer-questions.index')" wire:navigate icon="arrow-left" />
            <div>
                <flux:heading size="xl">{{ __('Tambah Pertanyaan Tracer') }}</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Buat pertanyaan tracer study baru') }}</flux:text>
            </div>
        </div>

        {{-- Form --}}
        <form wire:submit="save" class="space-y-6">
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6 space-y-4">
                <flux:select wire:model="tracer_period_id" :label="__('Periode Tracer')" required>
                    <option value="">{{ __('Pilih Periode') }}</option>
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}">{{ $period->judul }}</option>
                    @endforeach
                </flux:select>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input wire:model="kode_dikti" :label="__('Kode Dikti')" type="text" placeholder="f8, f505" />
                    <flux:input wire:model="urutan" :label="__('Urutan')" type="number" min="0" required />
                </div>

                <flux:textarea wire:model="pertanyaan" :label="__('Pertanyaan')" rows="3" required />

                <flux:select wire:model="tipe" :label="__('Tipe Input')" required>
                    @foreach ($tipeOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </flux:select>

                <flux:checkbox wire:model="wajib_diisi" :label="__('Wajib Diisi')" />
            </div>

            <div class="flex items-center justify-end gap-4">
                <flux:button variant="ghost" :href="route('admin.tracer-questions.index')" wire:navigate>{{ __('Batal') }}</flux:button>
                <flux:button variant="primary" type="submit">{{ __('Simpan') }}</flux:button>
            </div>
        </form>
    </div>
</div>
