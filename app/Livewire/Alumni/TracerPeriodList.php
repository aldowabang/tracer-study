<?php

namespace App\Livewire\Alumni;

use App\Models\AlumniProfile;
use App\Models\TracerPeriod;
use App\Models\TracerAnswer;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class TracerPeriodList extends Component
{
    public ?AlumniProfile $alumniProfile = null;
    public $periods = [];

    public function mount(): void
    {
        $user = Auth::user();
        $this->alumniProfile = AlumniProfile::where('user_id', $user->id)->first();

        if ($this->alumniProfile) {
            // Get all periods matching alumni's graduation year
            $this->periods = TracerPeriod::where('tahun_lulusan', $this->alumniProfile->tahun_lulus)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($period) use ($user) {
                    // Check if alumni has submitted for this period
                    $answersCount = TracerAnswer::where('user_id', $user->id)
                        ->where('tracer_period_id', $period->id)
                        ->count();
                    
                    $period->has_submitted = $answersCount > 0;
                    $period->questions_count = $period->tracerQuestions()->count();
                    
                    return $period;
                });
        }
    }

    public function render()
    {
        return view('livewire.alumni.tracer-period-list');
    }
}
