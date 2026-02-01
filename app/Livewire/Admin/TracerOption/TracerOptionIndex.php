<?php

namespace App\Livewire\Admin\TracerOption;

use App\Models\TracerOption;
use App\Models\TracerQuestion;
use Livewire\Component;
use Livewire\WithPagination;

class TracerOptionIndex extends Component
{
    use WithPagination;

    public ?int $selectedQuestion = null;

    // Form untuk tambah/edit opsi
    public ?int $editingOptionId = null;
    public string $label = '';
    public string $value = '';
    public int $urutan = 0;
    public bool $is_active = true;

    // Mode tambah
    public bool $showAddForm = false;

    protected function rules(): array
    {
        return [
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'urutan' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ];
    }

    public function updatedSelectedQuestion(): void
    {
        $this->resetPage();
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->editingOptionId = null;
        $this->label = '';
        $this->value = '';
        $this->urutan = 0;
        $this->is_active = true;
        $this->showAddForm = false;
        $this->resetValidation();
    }

    public function showAdd(): void
    {
        if (!$this->selectedQuestion) {
            session()->flash('error', 'Pilih pertanyaan terlebih dahulu.');
            return;
        }

        $this->resetForm();
        $this->showAddForm = true;

        // Auto set urutan to next number
        $maxUrutan = TracerOption::where('tracer_question_id', $this->selectedQuestion)->max('urutan');
        $this->urutan = ($maxUrutan ?? 0) + 1;
    }

    public function edit(int $id): void
    {
        $option = TracerOption::findOrFail($id);
        $this->editingOptionId = $option->id;
        $this->label = $option->label;
        $this->value = $option->value;
        $this->urutan = $option->urutan ?? 0;
        $this->is_active = $option->is_active ?? true;
        $this->showAddForm = false;
    }

    public function save(): void
    {
        $validated = $this->validate();
        $validated['tracer_question_id'] = $this->selectedQuestion;

        if ($this->editingOptionId) {
            $option = TracerOption::findOrFail($this->editingOptionId);
            $option->update($validated);
            session()->flash('message', 'Opsi jawaban berhasil diperbarui.');
        } else {
            TracerOption::create($validated);
            session()->flash('message', 'Opsi jawaban berhasil ditambahkan.');
        }

        $this->resetForm();
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
    }

    public function toggleActive(int $id): void
    {
        $option = TracerOption::findOrFail($id);
        $option->update(['is_active' => !$option->is_active]);
    }

    public function delete(int $id): void
    {
        $option = TracerOption::findOrFail($id);
        $option->delete();

        session()->flash('message', 'Opsi jawaban berhasil dihapus.');
    }

    public function render()
    {
        $options = collect();

        if ($this->selectedQuestion) {
            $options = TracerOption::where('tracer_question_id', $this->selectedQuestion)
                ->orderBy('urutan')
                ->get();
        }

        $questions = TracerQuestion::with('tracerPeriod')
            ->whereIn('tipe', ['radio', 'checkbox', 'select', 'scale'])
            ->orderBy('tracer_period_id')
            ->orderBy('urutan')
            ->get();

        return view('livewire.admin.tracer-option.tracer-option-index', [
            'options' => $options,
            'questions' => $questions,
        ]);
    }
}
