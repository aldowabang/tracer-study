<?php

namespace App\Livewire\Admin\Tracer;

use App\Models\AlumniProfile;
use App\Models\TracerAnswer;
use App\Models\TracerOption;
use App\Models\TracerParticipation;
use App\Models\TracerPeriod;
use App\Models\TracerQuestion;
use Livewire\Component;

class TracerStatistics extends Component
{
    public $selectedPeriodId = null;
    public $periods = [];
    public $stats = [];
    public $questionStats = [];

    public function mount(): void
    {
        $this->periods = TracerPeriod::orderBy('created_at', 'desc')->get();
        
        if ($this->periods->isNotEmpty()) {
            $this->selectedPeriodId = $this->periods->first()->id;
            $this->loadStatistics();
        }
    }

    public function updatedSelectedPeriodId(): void
    {
        $this->loadStatistics();
    }

    public function exportExcel()
    {
        if (!$this->selectedPeriodId) {
            return;
        }

        $period = TracerPeriod::find($this->selectedPeriodId);
        $fileName = 'tracer-answers-' . ($period->tahun_lulusan ?? 'semua') . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\TracerAnswersExport($this->selectedPeriodId),
            $fileName
        );
    }

    public function loadStatistics(): void
    {
        if (!$this->selectedPeriodId) {
            return;
        }

        $period = TracerPeriod::find($this->selectedPeriodId);
        
        if (!$period) {
            return;
        }

        // Get total target alumni for this period
        $totalTargetAlumni = AlumniProfile::where('tahun_lulus', $period->tahun_lulusan)->count();
        
        // Participation stats
        $participations = TracerParticipation::where('tracer_period_id', $this->selectedPeriodId)->get();
        $totalParticipants = $participations->count();
        $completedCount = $participations->where('status', 'selesai_isi')->count();
        $verifiedCount = $participations->where('status', 'selesai_cek')->count();
        $inProgressCount = $participations->where('status', 'belum_selesai')->count();

        $this->stats = [
            'total_target' => $totalTargetAlumni,
            'total_participants' => $totalParticipants,
            'completed' => $completedCount,
            'verified' => $verifiedCount,
            'in_progress' => $inProgressCount,
            'response_rate' => $totalTargetAlumni > 0 ? round(($completedCount + $verifiedCount) / $totalTargetAlumni * 100, 1) : 0,
            'period_name' => $period->nama_periode ?? 'Periode ' . $period->tahun_lulusan,
        ];

        // Get questions with option-based answers for charts
        // Tipe yang memiliki opsi: radio, checkbox, scale, select
        $questions = TracerQuestion::where('tracer_period_id', $this->selectedPeriodId)
            ->whereIn('tipe', ['radio', 'checkbox', 'scale', 'select'])
            ->orderBy('urutan')
            ->get();

        

        $this->questionStats = [];

        foreach ($questions as $question) {
            $options = TracerOption::where('tracer_question_id', $question->id)->get();
            
            $answerDistribution = [];
            $totalAnswers = 0;

            foreach ($options as $option) {
                $count = TracerAnswer::where('tracer_question_id', $question->id)
                    ->where('tracer_option_id', $option->id)
                    ->count();
                
                $answerDistribution[] = [
                    'label' => $option->label,
                    'count' => $count,
                ];
                $totalAnswers += $count;
            }

            // Calculate percentages
            foreach ($answerDistribution as &$item) {
                $item['percentage'] = $totalAnswers > 0 ? round($item['count'] / $totalAnswers * 100, 1) : 0;
            }

            $this->questionStats[] = [
                'id' => $question->id,
                'kode' => $question->kode_dikti,
                'pertanyaan' => $question->pertanyaan,
                'tipe' => $question->tipe,
                'total_answers' => $totalAnswers,
                'distribution' => $answerDistribution,
            ];
        }
    }

    public function render()
    {
        return view('livewire.admin.tracer.tracer-statistics');
    }
}
