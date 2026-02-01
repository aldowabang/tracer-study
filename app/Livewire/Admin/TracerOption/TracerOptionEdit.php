<?php

namespace App\Livewire\Admin\TracerOption;

use App\Models\TracerOption;
use App\Models\TracerQuestion;
use Livewire\Component;

class TracerOptionEdit extends Component
{
    public TracerOption $option;

    public ?int $tracer_question_id = null;
    public string $label = '';
    public string $value = '';

    public function mount(int $id): void
    {
        $this->option = TracerOption::findOrFail($id);

        $this->tracer_question_id = $this->option->tracer_question_id;
        $this->label = $this->option->label;
        $this->value = $this->option->value;
    }

    protected function rules(): array
    {
        return [
            'tracer_question_id' => 'required|exists:tracer_questions,id',
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        $this->option->update($validated);

        session()->flash('message', 'Opsi jawaban berhasil diperbarui.');

        $this->redirect(route('admin.tracer-options.index'), navigate: true);
    }

    public function render()
    {
        $questions = TracerQuestion::with('tracerPeriod')
            ->whereIn('tipe', ['radio', 'checkbox', 'select', 'scale'])
            ->orderBy('urutan')
            ->get();

        return view('livewire.admin.tracer-option.tracer-option-edit', [
            'questions' => $questions,
        ]);
    }
}
