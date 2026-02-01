<?php

namespace App\Livewire\Admin\TracerPeriod;

use App\Models\TracerPeriod;
use Livewire\Component;
use Livewire\WithPagination;

class TracerPeriodIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $period = TracerPeriod::findOrFail($id);
        $period->delete();

        session()->flash('message', 'Periode tracer study berhasil dihapus.');
    }

    public function toggleActive(int $id): void
    {
        $period = TracerPeriod::findOrFail($id);
        $period->update(['is_active' => !$period->is_active]);

        session()->flash('message', 'Status periode berhasil diperbarui.');
    }

    public function render()
    {
        $periods = TracerPeriod::query()
            ->when($this->search, function ($query) {
                $query->where('judul', 'like', '%' . $this->search . '%')
                    ->orWhere('tahun_lulusan', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.tracer-period.tracer-period-index', [
            'periods' => $periods,
        ]);
    }
}
