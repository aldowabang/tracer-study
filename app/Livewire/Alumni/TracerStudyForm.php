<?php

namespace App\Livewire\Alumni;

use App\Models\AlumniProfile;
use App\Models\TracerAnswer;
use App\Models\TracerPeriod;
use App\Models\TracerQuestion;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class TracerStudyForm extends Component
{
    public ?TracerPeriod $period = null;
    public ?AlumniProfile $alumniProfile = null;
    public array $answers = [];
    public bool $hasSubmitted = false;
    public bool $noPeriodAvailable = false;
    public bool $hasStarted = false;
    
    // Step wizard properties
    public int $currentStep = 0;
    public array $sections = [];
    public array $sectionKeys = [];

    public function mount(): void
    {
        $user = Auth::user();
        $this->alumniProfile = AlumniProfile::where('user_id', $user->id)->first();

        if (!$this->alumniProfile) {
            $this->noPeriodAvailable = true;
            return;
        }

        // Cari periode tracer study yang sesuai dengan tahun lulus alumni
        $this->period = TracerPeriod::where('tahun_lulusan', $this->alumniProfile->tahun_lulus)
            ->where('is_active', true)
            ->first();

        if (!$this->period) {
            $this->noPeriodAvailable = true;
            return;
        }

        // Initialize sections
        $this->sections = [
            'A. Identitas Responden' => [1, 5],
            'B. Status Setelah Lulus' => [6, 8],
            'C. Profil Pekerjaan' => [9, 11],
            'D. Kesesuaian Bidang Kerja' => [12, 13],
            'E. Penilaian Kompetensi Lulusan (CPL)' => [14, 26],
            'F. Relevansi Kurikulum' => [27, 29],
            'G. Pengalaman Pembelajaran' => [30, 31],
            'H. Kepuasan Lulusan' => [32, 36],
            'I. Masukan untuk Prodi' => [37, 39],
        ];
        $this->sectionKeys = array_keys($this->sections);

        // Pre-fill tahun lulus dan NIM dari profil alumni
        $questions = $this->period->tracerQuestions()->orderBy('urutan')->get();
        foreach ($questions as $question) {
            // Pertanyaan urutan 1 = Tahun lulus
            if ($question->urutan == 1) {
                $this->answers[$question->id] = (string) $this->alumniProfile->tahun_lulus;
            }
            // Pertanyaan urutan 2 = NIM
            if ($question->urutan == 2) {
                $this->answers[$question->id] = $this->alumniProfile->nim;
            }
        }

        // Cek apakah alumni sudah pernah mengisi
        $existingAnswers = TracerAnswer::where('user_id', $user->id)
            ->where('tracer_period_id', $this->period->id)
            ->count();

        if ($existingAnswers > 0) {
            $this->hasSubmitted = true;
            // Load existing answers
            $this->loadExistingAnswers();
        }
    }

    private function loadExistingAnswers(): void
    {
        $existingAnswers = TracerAnswer::where('user_id', Auth::id())
            ->where('tracer_period_id', $this->period->id)
            ->get();

        foreach ($existingAnswers as $answer) {
            $question = TracerQuestion::find($answer->tracer_question_id);
            
            if ($question) {
                if (in_array($question->tipe, ['checkbox'])) {
                    // For checkbox, answers are stored as array
                    if (!isset($this->answers[$answer->tracer_question_id])) {
                        $this->answers[$answer->tracer_question_id] = [];
                    }
                    $this->answers[$answer->tracer_question_id][] = (string) $answer->tracer_option_id;
                } elseif (in_array($question->tipe, ['radio', 'select', 'scale'])) {
                    $this->answers[$answer->tracer_question_id] = (string) $answer->tracer_option_id;
                } else {
                    $this->answers[$answer->tracer_question_id] = $answer->jawaban_text;
                }
            }
        }
    }

    public function startQuestionnaire(): void
    {
        $this->hasStarted = true;
    }

    public function edit(): void
    {
        $this->hasSubmitted = false;
        $this->hasStarted = true;
        $this->currentStep = 0;
    }

    public function goToStep(int $step): void
    {
        if ($step >= 0 && $step < count($this->sectionKeys)) {
            // Jika ingin maju ke step yang lebih tinggi, validasi dulu section saat ini
            if ($step > $this->currentStep) {
                // Validasi semua section dari current sampai target-1
                for ($i = $this->currentStep; $i < $step; $i++) {
                    if (!$this->validateSection($i)) {
                        $this->currentStep = $i; // Tetap di section yang gagal validasi
                        return;
                    }
                }
            }
            $this->saveProgress();
            $this->currentStep = $step;
        }
    }

    public function nextStep(): void
    {
        // Validate current section first
        if (!$this->validateCurrentSection()) {
            return;
        }
        
        // Save progress
        $this->saveProgress();
        
        if ($this->currentStep < count($this->sectionKeys) - 1) {
            $this->currentStep++;
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 0) {
            $this->saveProgress();
            $this->currentStep--;
        }
    }

    private function validateSection(int $stepIndex): bool
    {
        $this->resetErrorBag();
        
        $sectionName = $this->sectionKeys[$stepIndex] ?? null;
        if (!$sectionName) {
            return true;
        }

        $range = $this->sections[$sectionName];
        $questions = $this->period->tracerQuestions()
            ->where('urutan', '>=', $range[0])
            ->where('urutan', '<=', $range[1])
            ->get();

        foreach ($questions as $question) {
            if ($question->wajib_diisi) {
                $answer = $this->answers[$question->id] ?? null;
                if (empty($answer) && $answer !== '0') {
                    $this->addError('answers.' . $question->id, 'Pertanyaan ini wajib diisi.');
                }
            }
        }

        return $this->getErrorBag()->isEmpty();
    }

    private function validateCurrentSection(): bool
    {
        return $this->validateSection($this->currentStep);
    }

    public function saveProgress(): void
    {
        if (!$this->period) {
            return;
        }

        $user = Auth::user();
        
        // Get current section questions
        $currentSectionName = $this->sectionKeys[$this->currentStep] ?? null;
        if (!$currentSectionName) {
            return;
        }

        $range = $this->sections[$currentSectionName];
        $questions = $this->period->tracerQuestions()
            ->where('urutan', '>=', $range[0])
            ->where('urutan', '<=', $range[1])
            ->get();

        // Delete existing answers for current section
        $questionIds = $questions->pluck('id')->toArray();
        TracerAnswer::where('user_id', $user->id)
            ->where('tracer_period_id', $this->period->id)
            ->whereIn('tracer_question_id', $questionIds)
            ->delete();

        // Save current section answers
        foreach ($questions as $question) {
            $answer = $this->answers[$question->id] ?? null;

            if ($answer === null || $answer === '' || (is_array($answer) && empty($answer))) {
                continue;
            }

            if (in_array($question->tipe, ['checkbox'])) {
                if (is_array($answer)) {
                    foreach ($answer as $optionId) {
                        TracerAnswer::create([
                            'tracer_period_id' => $this->period->id,
                            'user_id' => $user->id,
                            'tracer_question_id' => $question->id,
                            'tracer_option_id' => $optionId,
                            'jawaban_text' => null,
                        ]);
                    }
                }
            } elseif (in_array($question->tipe, ['radio', 'select', 'scale'])) {
                TracerAnswer::create([
                    'tracer_period_id' => $this->period->id,
                    'user_id' => $user->id,
                    'tracer_question_id' => $question->id,
                    'tracer_option_id' => $answer,
                    'jawaban_text' => null,
                ]);
            } else {
                TracerAnswer::create([
                    'tracer_period_id' => $this->period->id,
                    'user_id' => $user->id,
                    'tracer_question_id' => $question->id,
                    'tracer_option_id' => null,
                    'jawaban_text' => $answer,
                ]);
            }
        }
    }

    public function submit(): void
    {
        // Validate all sections
        $this->resetErrorBag();
        
        $questions = $this->period->tracerQuestions()->orderBy('urutan')->get();
        
        foreach ($questions as $question) {
            if ($question->wajib_diisi) {
                $answer = $this->answers[$question->id] ?? null;
                if (empty($answer) && $answer !== '0') {
                    $this->addError('answers.' . $question->id, 'Pertanyaan ini wajib diisi.');
                }
            }
        }

        if ($this->getErrorBag()->isNotEmpty()) {
            // Find which section has the error and go there
            foreach ($this->getErrorBag()->keys() as $key) {
                $questionId = str_replace('answers.', '', $key);
                $question = $questions->firstWhere('id', $questionId);
                if ($question) {
                    foreach ($this->sections as $index => $range) {
                        if ($question->urutan >= $range[0] && $question->urutan <= $range[1]) {
                            $this->currentStep = array_search($index, $this->sectionKeys);
                            break 2;
                        }
                    }
                }
            }
            return;
        }

        // Save all remaining answers
        $this->saveProgress();
        
        $this->hasSubmitted = true;
        session()->flash('message', 'Jawaban kuesioner berhasil disimpan. Terima kasih atas partisipasi Anda!');
    }

    public function render()
    {
        $questions = collect();
        $currentSectionQuestions = collect();
        $currentSectionName = '';

        if ($this->period) {
            $questions = $this->period->tracerQuestions()
                ->with('tracerOptions')
                ->orderBy('urutan')
                ->get();

            // Get current section questions
            if (isset($this->sectionKeys[$this->currentStep])) {
                $currentSectionName = $this->sectionKeys[$this->currentStep];
                $range = $this->sections[$currentSectionName];
                
                $currentSectionQuestions = $questions->filter(function ($q) use ($range) {
                    return $q->urutan >= $range[0] && $q->urutan <= $range[1];
                });
            }
        }

        return view('livewire.alumni.tracer-study-form', [
            'questions' => $questions,
            'currentSectionQuestions' => $currentSectionQuestions,
            'currentSectionName' => $currentSectionName,
            'totalSteps' => count($this->sectionKeys),
        ]);
    }
}
