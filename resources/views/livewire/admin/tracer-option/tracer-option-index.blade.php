<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <flux:heading size="xl">{{ __('Manajemen Opsi Jawaban') }}</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Kelola daftar pilihan untuk pertanyaan Tracer Study tipe pilihan ganda, checkbox, dan skala.') }}</flux:text>
            </div>
            <div class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
                <flux:icon name="information-circle" class="size-5" />
                <span>{{ __('Perubahan langsung diterapkan') }}</span>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('message'))
            <flux:callout variant="success" icon="check-circle">
                {{ session('message') }}
            </flux:callout>
        @endif

        @if (session('error'))
            <flux:callout variant="danger" icon="exclamation-circle">
                {{ session('error') }}
            </flux:callout>
        @endif

        {{-- Question Selector & Add Button --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
                <div class="flex-1 w-full sm:max-w-xl">
                    <flux:select wire:model.live="selectedQuestion" :label="__('Pilih Pertanyaan Tracer Study')">
                        <option value="">{{ __('-- Pilih Pertanyaan --') }}</option>
                        @foreach ($questions as $question)
                            <option value="{{ $question->id }}">[{{ strtoupper($question->tipe) }}] {{ Str::limit($question->pertanyaan, 60) }} ({{ $question->tracerPeriod->judul ?? '-' }})</option>
                        @endforeach
                    </flux:select>
                </div>
                <flux:button variant="primary" wire:click="showAdd" icon="plus" :disabled="!$selectedQuestion">
                    {{ __('Tambah Opsi') }}
                </flux:button>
            </div>
        </div>

        {{-- Add Form --}}
        @if ($showAddForm && $selectedQuestion)
        <div class="rounded-xl border border-blue-200 dark:border-blue-700 bg-blue-50 dark:bg-blue-900/20 p-6">
            <flux:heading size="sm" class="mb-4">{{ __('Tambah Opsi Baru') }}</flux:heading>
            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <flux:input wire:model="urutan" :label="__('Urutan')" type="number" min="0" required />
                    <flux:input wire:model="label" :label="__('Label Tampilan')" type="text" placeholder="Label yang ditampilkan" required class="md:col-span-1" />
                    <flux:input wire:model="value" :label="__('Nilai (Value)')" type="text" placeholder="Nilai yang disimpan" required class="md:col-span-1" />
                    <div class="flex items-end gap-2">
                        <flux:checkbox wire:model="is_active" :label="__('Aktif')" />
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-2">
                    <flux:button variant="primary" type="submit" size="sm">{{ __('Simpan') }}</flux:button>
                    <flux:button variant="ghost" type="button" wire:click="cancelEdit" size="sm">{{ __('Batal') }}</flux:button>
                </div>
            </form>
        </div>
        @endif

        {{-- Options Table --}}
        @if ($selectedQuestion)
        <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">Urut</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Label Tampilan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Nilai (Value)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($options as $option)
                        @if ($editingOptionId === $option->id)
                        {{-- Inline Edit Form --}}
                        <tr class="bg-yellow-50 dark:bg-yellow-900/20">
                            <td class="px-4 py-3">
                                <flux:input wire:model="urutan" type="text" size="sm" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-16" />
                            </td>
                            <td class="px-4 py-3">
                                <flux:input wire:model="label" type="text" size="sm" />
                            </td>
                            <td class="px-4 py-3">
                                <flux:input wire:model="value" type="text" size="sm" />
                            </td>
                            <td class="px-4 py-3">
                                <flux:checkbox wire:model="is_active" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <flux:button size="xs" variant="primary" color="blue" wire:click="save" icon="check" />
                                    <flux:button size="xs" variant="danger" color="red" wire:click="cancelEdit" icon="x-mark" />
                                </div>
                            </td>
                        </tr>
                        @else
                        {{-- Display Row --}}
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    {{ $option->urutan ?? $loop->iteration }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100 font-medium">
                                {{ $option->label }}
                            </td>
                            <td class="px-4 py-3">
                                <code class="px-2 py-1 rounded bg-zinc-100 dark:bg-zinc-800 text-sm text-zinc-600 dark:text-zinc-400">{{ $option->value }}</code>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <flux:badge :color="($option->is_active ?? true) ? 'green' : 'zinc'" size="sm" icon="{{ ($option->is_active ?? true) ? 'check-circle' : 'x-circle' }}">
                                    {{ ($option->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                                </flux:badge>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <flux:button size="xs" variant="filled" color="amber" wire:click="edit({{ $option->id }})" icon="pencil" />
                                    <flux:button size="xs" variant="filled" color="red" wire:click="delete({{ $option->id }})" wire:confirm="Apakah Anda yakin ingin menghapus opsi '{{ $option->label }}'?" icon="trash" />
                                </div>
                            </td>
                        </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                <div class="flex flex-col items-center gap-2">
                                    <flux:icon name="inbox" class="size-8 text-zinc-400" />
                                    <span>{{ __('Belum ada opsi jawaban untuk pertanyaan ini.') }}</span>
                                    <flux:button variant="primary" size="sm" wire:click="showAdd" icon="plus">
                                        {{ __('Tambah Opsi Pertama') }}
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @else
        {{-- No Question Selected --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-12 text-center">
            <div class="flex flex-col items-center gap-3">
                <flux:icon name="question-mark-circle" class="size-12 text-zinc-400" />
                <flux:heading size="lg">{{ __('Pilih Pertanyaan') }}</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400 max-w-md">
                    {{ __('Pilih pertanyaan tracer study dari dropdown di atas untuk mengelola opsi jawabannya.') }}
                </flux:text>
            </div>
        </div>
        @endif
    </div>
</div>
