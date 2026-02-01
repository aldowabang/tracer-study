<?php

namespace App\Livewire\Admin\Alumni;

use App\Models\AlumniProfile;
use App\Models\User;
use Livewire\Component;

class AlumniCreate extends Component
{
    public ?int $user_id = null;
    public string $nim = '';
    public string $nama_lengkap = '';
    public string $prodi = 'S1 Sistem Informasi';
    public ?int $tahun_lulus = null;
    public string $no_hp = '';
    public string $alamat = '';

    protected function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id|unique:alumni_profiles,user_id',
            'nim' => 'required|string|max:20|unique:alumni_profiles,nim',
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

        AlumniProfile::create($validated);

        session()->flash('message', 'Data alumni berhasil ditambahkan.');

        $this->redirect(route('admin.alumni.index'), navigate: true);
    }

    public function render()
    {
        $users = User::where('role', 'alumni')
            ->whereDoesntHave('alumniProfile')
            ->orderBy('name')
            ->get();

        return view('livewire.admin.alumni.alumni-create', [
            'users' => $users,
        ]);
    }
}
