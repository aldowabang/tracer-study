<?php

namespace App\Exports;

use App\Models\TracerPeriod;
use App\Models\TracerParticipation;
use App\Models\TracerAnswer;
use App\Models\AlumniProfile;
use App\Models\TracerOption;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TracerAnswersExport implements FromCollection, WithHeadings
{
    protected $periodId;
    protected $questions;

    public function __construct($periodId)
    {
        $this->periodId = $periodId;
        $period = TracerPeriod::with(['tracerQuestions' => function($q) {
            $q->orderBy('urutan');
        }])->findOrFail($periodId);
        
        $this->questions = $period->tracerQuestions;
    }

    public function headings(): array
    {
        $headers = [
            'NIM',
            'Nama Lengkap',
            'Email',
            'Prodi',
            'Tahun Lulus',
            'Status Pengisian'
        ];

        foreach ($this->questions as $question) {
            $headers[] = $question->pertanyaan;
        }

        return $headers;
    }

    public function collection()
    {
        $participations = TracerParticipation::with('user.alumniProfile')
            ->where('tracer_period_id', $this->periodId)
            ->get();

        $data = collect();

        foreach ($participations as $participation) {
            $user = $participation->user;
            $alumni = $user->alumniProfile;

            // Base user info
            $row = [
                'NIM' => $alumni ? $alumni->nim : '-',
                'Nama Lengkap' => $alumni ? $alumni->nama_lengkap : $user->name,
                'Email' => $user->email,
                'Prodi' => $alumni ? $alumni->prodi : '-',
                'Tahun Lulus' => $alumni ? $alumni->tahun_lulus : '-',
                'Status Pengisian' => $this->formatStatus($participation->status)
            ];

            // Get user's answers for this period
            $answers = TracerAnswer::where('user_id', $user->id)
                ->where('tracer_period_id', $this->periodId)
                ->get()
                ->groupBy('tracer_question_id');

            // Map answers to each question column dynamically
            foreach ($this->questions as $question) {
                $userAnswers = $answers->get($question->id);
                
                if (!$userAnswers || $userAnswers->isEmpty()) {
                    $row[$question->pertanyaan] = '-';
                    continue;
                }

                $answerTexts = [];
                foreach ($userAnswers as $answer) {
                    if ($answer->tracer_option_id) {
                        $option = TracerOption::find($answer->tracer_option_id);
                        $answerTexts[] = $option ? $option->label : '-';
                    } else {
                        $answerTexts[] = $answer->jawaban_text;
                    }
                }

                $row[$question->pertanyaan] = implode(', ', array_filter($answerTexts));
            }

            $data->push($row);
        }

        return $data;
    }

    private function formatStatus($status)
    {
        return match ($status) {
            'selesai_isi' => 'Selesai Isi',
            'selesai_cek' => 'Terverifikasi',
            'belum_selesai' => 'Belum Selesai',
            default => 'Tidak Diketahui',
        };
    }
}
