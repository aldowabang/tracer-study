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
    public ?string $participationStatus = null;
    
    public function mount($period_id): void
    {
        $user = Auth::user();
        $this->alumniProfile = AlumniProfile::where('user_id', $user->id)->first();

        if (!$this->alumniProfile) {
            $this->noPeriodAvailable = true;
            return;
        }

        // Cari periode tracer study berdasarkan ID yang diminta
        // Dan pastikan tahun lulusan sesuai dengan alumni
        $this->period = TracerPeriod::where('id', $period_id)
            ->where('tahun_lulusan', $this->alumniProfile->tahun_lulus)
            ->first();

        if (!$this->period) {
            $this->noPeriodAvailable = true;
            return;
        }
        
        // Cek status aktif (opsional: admin mungkin ingin preview meski non-aktif, tapi untuk alumni harus aktif)
        // Kecuali jika alumni sudah mengisi, mungkin masih boleh lihat?
        // Untuk sekarang kita batasi hanya yang aktif atau sudah submit
        // if (!$this->period->is_active) { ... } -> Di-handle di view atau logic lain

        // Pre-fill tahun lulus dan NIM dari profil alumni
        $questions = $this->period->tracerQuestions()->orderBy('urutan')->get();
        foreach ($questions as $question) {
            // Ensure checkbox questions are initialized as array so Livewire binds them correctly
            if ($question->tipe === 'checkbox') {
                $this->answers[$question->id] = [];
            }

            // Pertanyaan urutan 1 = Tahun lulus
            if ($question->urutan == 1) {
                $this->answers[$question->id] = (string) $this->alumniProfile->tahun_lulus;
            }
            // Pertanyaan urutan 2 = NIM
            if ($question->urutan == 2) {
                $this->answers[$question->id] = $this->alumniProfile->nim;
            }
        }

        // Cek status partisipasi
        $participation = \App\Models\TracerParticipation::where('user_id', $user->id)
            ->where('tracer_period_id', $this->period->id)
            ->first();

        if ($participation) {
            $this->participationStatus = $participation->status;
            $this->hasStarted = true;
            if (in_array($participation->status, ['selesai_isi', 'selesai_cek'])) {
                $this->hasSubmitted = true;
            }
            // Load existing answers logic (can remain as checking count or just loading)
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
        
        // Create or update participation record
        \App\Models\TracerParticipation::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'tracer_period_id' => $this->period->id
            ],
            ['status' => 'belum_selesai']
        );
    }

    public function edit(): void
    {
        // Check if verified
        $participation = \App\Models\TracerParticipation::where('user_id', Auth::id())
            ->where('tracer_period_id', $this->period->id)
            ->first();
            
        if ($participation && $participation->status === 'selesai_cek') {
            session()->flash('error', 'Jawaban Anda sudah diverifikasi dan tidak dapat diubah.');
            return;
        }

        $this->hasSubmitted = false;
        $this->hasStarted = true;
        
        // Update status to belum_selesai if editing
        \App\Models\TracerParticipation::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'tracer_period_id' => $this->period->id
            ],
            ['status' => 'belum_selesai']
        );
        $this->participationStatus = 'belum_selesai';
    }
    
    public function saveProgress(): void
    {
        if (!$this->period) {
            return;
        }

        $user = Auth::user();
        
        // Ensure participation record exists (in case saveProgress is called directly)
        \App\Models\TracerParticipation::firstOrCreate(
            [
                'user_id' => $user->id,
                'tracer_period_id' => $this->period->id
            ],
            ['status' => 'belum_selesai']
        );
        
        // Get all questions
        $questions = $this->period->tracerQuestions()->get();

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

        session()->flash('message', 'Progress berhasil disimpan.');
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
            return;
        }

        // Save all remaining answers
        $this->saveProgress();
        
        // Update participation status to selesai_isi
        \App\Models\TracerParticipation::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'tracer_period_id' => $this->period->id
            ],
            ['status' => 'selesai_isi']
        );
        $this->participationStatus = 'selesai_isi';
        
        $this->hasSubmitted = true;
        session()->flash('message', 'Jawaban kuesioner berhasil disimpan. Terima kasih atas partisipasi Anda!');
    }

    public function finalizeSubmission(): void
    {
        // Update participation status to selesai_cek (Final/Verified by User)
        \App\Models\TracerParticipation::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'tracer_period_id' => $this->period->id
            ],
            ['status' => 'selesai_cek']
        );
        $this->participationStatus = 'selesai_cek';
        
        $this->redirect(route('alumni.tracer-periods'), navigate: true);
    }

    public function render()
    {
        $questions = collect();

        if ($this->period) {
            $questions = $this->period->tracerQuestions()
                ->with('tracerOptions')
                ->orderBy('urutan')
                ->get();
        }

        return view('livewire.alumni.tracer-study-form', [
            'questions' => $questions,
        ]);
    }
}
