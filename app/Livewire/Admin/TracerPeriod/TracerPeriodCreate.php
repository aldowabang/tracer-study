<?php

namespace App\Livewire\Admin\TracerPeriod;

use App\Models\TracerPeriod;
use Livewire\Component;

class TracerPeriodCreate extends Component
{
    public string $tahun_lulusan = '';
    public string $judul = '';
    public string $tgl_mulai = '';
    public string $tgl_selesai = '';
    public bool $is_active = false;

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

        TracerPeriod::create($validated);

        session()->flash('message', 'Periode tracer study berhasil ditambahkan.');

        $this->redirect(route('admin.tracer-periods.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.tracer-period.tracer-period-create');
    }
}
