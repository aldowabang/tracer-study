<?php

namespace App\Livewire\Admin\Alumni;

use App\Models\AlumniProfile;
use App\Models\User;
use Livewire\Component;

class AlumniEdit extends Component
{
    public AlumniProfile $alumni;

    public ?int $user_id = null;
    public string $nim = '';
    public string $nama_lengkap = '';
    public string $prodi = '';
    public ?int $tahun_lulus = null;
    public string $no_hp = '';
    public string $alamat = '';

    public function mount(int $id): void
    {
        $this->alumni = AlumniProfile::findOrFail($id);

        $this->user_id = $this->alumni->user_id;
        $this->nim = $this->alumni->nim;
        $this->nama_lengkap = $this->alumni->nama_lengkap;
        $this->prodi = $this->alumni->prodi;
        $this->tahun_lulus = $this->alumni->tahun_lulus;
        $this->no_hp = $this->alumni->no_hp ?? '';
        $this->alamat = $this->alumni->alamat ?? '';
    }

    protected function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id|unique:alumni_profiles,user_id,' . $this->alumni->id,
            'nim' => 'required|string|max:20|unique:alumni_profiles,nim,' . $this->alumni->id,
            'nama_lengkap' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'tahun_lulus' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        $this->alumni->update($validated);

        session()->flash('message', 'Data alumni berhasil diperbarui.');

        $this->redirect(route('admin.alumni.index'), navigate: true);
    }

    public function render()
    {
        $users = User::where('role', 'alumni')
            ->where(function ($query) {
                $query->whereDoesntHave('alumniProfile')
                    ->orWhere('id', $this->alumni->user_id);
            })
            ->orderBy('name')
            ->get();

        return view('livewire.admin.alumni.alumni-edit', [
            'users' => $users,
        ]);
    }
}
