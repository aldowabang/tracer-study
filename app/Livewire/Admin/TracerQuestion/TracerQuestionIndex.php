<?php

namespace App\Livewire\Admin\TracerQuestion;

use App\Models\TracerQuestion;
use App\Models\TracerPeriod;
use Livewire\Component;
use Livewire\WithPagination;

class TracerQuestionIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $filterPeriod = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterPeriod(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $question = TracerQuestion::findOrFail($id);
        $question->delete();

        session()->flash('message', 'Pertanyaan berhasil dihapus.');
    }

    public function render()
    {
        $questions = TracerQuestion::with('tracerPeriod', 'tracerOptions')
            ->when($this->search, function ($query) {
                $query->where('pertanyaan', 'like', '%' . $this->search . '%')
                    ->orWhere('kode_dikti', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterPeriod, function ($query) {
                $query->where('tracer_period_id', $this->filterPeriod);
            })
            ->orderBy('tracer_period_id')
            ->orderBy('urutan')
            ->paginate(10);

        $periods = TracerPeriod::orderBy('created_at', 'desc')->get();

        return view('livewire.admin.tracer-question.tracer-question-index', [
            'questions' => $questions,
            'periods' => $periods,
        ]);
    }
}
