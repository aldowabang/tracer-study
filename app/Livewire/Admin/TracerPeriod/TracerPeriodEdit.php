<?php

namespace App\Livewire\Admin\TracerPeriod;

use App\Models\TracerPeriod;
use Livewire\Component;

class TracerPeriodEdit extends Component
{
    public TracerPeriod $period;

    public string $tahun_lulusan = '';
    public string $judul = '';
    public string $tgl_mulai = '';
    public string $tgl_selesai = '';
    public bool $is_active = false;

    public function mount(int $id): void
    {
        $this->period = TracerPeriod::findOrFail($id);

        $this->tahun_lulusan = $this->period->tahun_lulusan;
        $this->judul = $this->period->judul;
        $this->tgl_mulai = $this->period->tgl_mulai;
        $this->tgl_selesai = $this->period->tgl_selesai;
        $this->is_active = $this->period->is_active;
    }

    protected function rules(): array
    {
        return [
            'tahun_lulusan' => 'required|string|max:50',
            'judul' => 'required|string|max:255',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'is_active' => 'boolean',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        $this->period->update($validated);

        session()->flash('message', 'Periode tracer study berhasil diperbarui.');

        $this->redirect(route('admin.tracer-periods.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.tracer-period.tracer-period-edit');
    }
}
