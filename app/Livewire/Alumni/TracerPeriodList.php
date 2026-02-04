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
            $periods = TracerPeriod::where('tahun_lulusan', $this->alumniProfile->tahun_lulus)
                ->orderBy('created_at', 'desc')
                ->get();

            // Get user participations for these periods
            $participations = \App\Models\TracerParticipation::where('user_id', $user->id)
                ->whereIn('tracer_period_id', $periods->pluck('id'))
                ->get()
                ->keyBy('tracer_period_id');

            $this->periods = $periods->map(function ($period) use ($participations) {
                // Check participation status
                $participation = $participations->get($period->id);
                
                $period->participation_status = $participation ? $participation->status : null; // null, 'belum_selesai', 'selesai_isi', 'selesai_cek'
                $period->has_submitted = $participation && in_array($participation->status, ['selesai_isi', 'selesai_cek']); 
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
