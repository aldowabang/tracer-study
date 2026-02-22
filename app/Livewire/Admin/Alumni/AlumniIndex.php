<?php

namespace App\Livewire\Admin\Alumni;

use App\Models\AlumniProfile;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AlumniIndex extends Component
{
    use WithPagination, \Livewire\WithFileUploads;

    public string $search = '';
    public $excelFile;
    public ?AlumniProfile $selectedAlumni = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function viewAlumni(int $id): void
    {
        $this->selectedAlumni = AlumniProfile::with('user')->findOrFail($id);
        \Flux::modal('view-alumni')->show();
    }

    public function importExcel(): void
    {
        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls,csv|max:10240', // Max 10MB
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\AlumniImport, $this->excelFile);
            $this->reset('excelFile');
            session()->flash('message', 'Data alumni berhasil diimport.');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat mengimport data: ' . $e->getMessage());
        }
    }

    public function exportExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AlumniExport, 'data-alumni.xlsx');
    }

    public function delete(int $id): void
    {
        $alumni = AlumniProfile::findOrFail($id);
        $alumni->delete();

        session()->flash('message', 'Data alumni berhasil dihapus.');
    }

    public function render()
    {
        $alumni = AlumniProfile::with('user')
            ->when($this->search, function ($query) {
                $query->where('nama_lengkap', 'like', '%' . $this->search . '%')
                    ->orWhere('nim', 'like', '%' . $this->search . '%')
                    ->orWhere('prodi', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.alumni.alumni-index', [
            'alumniList' => $alumni,
        ]);
    }
}
