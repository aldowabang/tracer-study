<?php

namespace App\Livewire\Admin\TracerQuestion;

use App\Models\TracerQuestion;
use App\Models\TracerPeriod;
use Livewire\Component;

class TracerQuestionEdit extends Component
{
    public TracerQuestion $question;

    public ?int $tracer_period_id = null;
    public string $kode_dikti = '';
    public string $pertanyaan = '';
    public string $tipe = 'text';
    public int $urutan = 0;
    public bool $wajib_diisi = true;

    public function mount(int $id): void
    {
        $this->question = TracerQuestion::findOrFail($id);

        $this->tracer_period_id = $this->question->tracer_period_id;
        $this->kode_dikti = $this->question->kode_dikti ?? '';
        $this->pertanyaan = $this->question->pertanyaan;
        $this->tipe = $this->question->tipe;
        $this->urutan = $this->question->urutan;
        $this->wajib_diisi = $this->question->wajib_diisi;
    }

    protected function rules(): array
    {
        return [
            'tracer_period_id' => 'required|exists:tracer_periods,id',
            'kode_dikti' => 'nullable|string|max:20',
            'pertanyaan' => 'required|string',
            'tipe' => 'required|in:text,number,textarea,radio,checkbox,select,scale',
            'urutan' => 'required|integer|min:0',
            'wajib_diisi' => 'boolean',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        $this->question->update($validated);

        session()->flash('message', 'Pertanyaan berhasil diperbarui.');

        $this->redirect(route('admin.tracer-questions.index'), navigate: true);
    }

    public function render()
    {
        $periods = TracerPeriod::orderBy('created_at', 'desc')->get();

        $tipeOptions = [
            'text' => 'Text',
            'number' => 'Number',
            'textarea' => 'Textarea',
            'radio' => 'Radio Button',
            'checkbox' => 'Checkbox',
            'select' => 'Select/Dropdown',
            'scale' => 'Scale/Rating',
        ];

        return view('livewire.admin.tracer-question.tracer-question-edit', [
            'periods' => $periods,
            'tipeOptions' => $tipeOptions,
        ]);
    }
}
