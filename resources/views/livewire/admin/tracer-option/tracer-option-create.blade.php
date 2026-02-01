<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl max-w-2xl">
        {{-- Header --}}
        <div class="flex items-center gap-4">
            <flux:button variant="ghost" :href="route('admin.tracer-options.index')" wire:navigate icon="arrow-left" />
            <div>
                <flux:heading size="xl">{{ __('Tambah Opsi Jawaban') }}</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Buat opsi jawaban baru') }}</flux:text>
            </div>
        </div>

        {{-- Form --}}
        <form wire:submit="save" class="space-y-6">
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6 space-y-4">
                <flux:select wire:model="tracer_question_id" :label="__('Pertanyaan')" required>
                    <option value="">{{ __('Pilih Pertanyaan') }}</option>
                    @foreach ($questions as $question)
                        <option value="{{ $question->id }}">[{{ $question->tracerPeriod->judul ?? '' }}] {{ Str::limit($question->pertanyaan, 60) }}</option>
                    @endforeach
                </flux:select>

                <flux:input wire:model="label" :label="__('Label')" type="text" placeholder="Label yang ditampilkan" required />

                <flux:input wire:model="value" :label="__('Value')" type="text" placeholder="Nilai yang disimpan" required />
            </div>

            <div class="flex items-center justify-end gap-4">
                <flux:button variant="ghost" :href="route('admin.tracer-options.index')" wire:navigate>{{ __('Batal') }}</flux:button>
                <flux:button variant="primary" type="submit">{{ __('Simpan') }}</flux:button>
            </div>
        </form>
    </div>
</div>

