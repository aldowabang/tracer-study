<?php

namespace App\Livewire\Admin\TracerOption;

use App\Models\TracerOption;
use App\Models\TracerQuestion;
use Livewire\Component;

class TracerOptionCreate extends Component
{
    public ?int $tracer_question_id = null;
    public string $label = '';
    public string $value = '';

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

        TracerOption::create($validated);

        session()->flash('message', 'Opsi jawaban berhasil ditambahkan.');

        $this->redirect(route('admin.tracer-options.index'), navigate: true);
    }

    public function render()
    {
        $questions = TracerQuestion::with('tracerPeriod')
            ->whereIn('tipe', ['radio', 'checkbox', 'select', 'scale'])
            ->orderBy('urutan')
            ->get();

        return view('livewire.admin.tracer-option.tracer-option-create', [
            'questions' => $questions,
        ]);
    }
}
