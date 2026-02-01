<?php

namespace App\Livewire\Admin\TracerQuestion;

use App\Models\TracerQuestion;
use App\Models\TracerPeriod;
use Livewire\Component;

class TracerQuestionCreate extends Component
{
    public ?int $tracer_period_id = null;
    public string $kode_dikti = '';
    public string $pertanyaan = '';
    public string $tipe = 'text';
    public int $urutan = 0;
    public bool $wajib_diisi = true;

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

        TracerQuestion::create($validated);

        session()->flash('message', 'Pertanyaan berhasil ditambahkan.');

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

        return view('livewire.admin.tracer-question.tracer-question-create', [
            'periods' => $periods,
            'tipeOptions' => $tipeOptions,
        ]);
    }
}
