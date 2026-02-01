<?php

namespace App\Livewire\Admin\Alumni;

use App\Models\AlumniProfile;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AlumniIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
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
