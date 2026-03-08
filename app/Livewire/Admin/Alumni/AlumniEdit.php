<?php

namespace App\Livewire\Admin\Alumni;

use App\Models\AlumniProfile;
use App\Models\User;
use Livewire\Component;

class AlumniEdit extends Component
{
    public AlumniProfile $alumni;

    public string $email = '';
    public string $nim = '';
    public string $nama_lengkap = '';
    public string $prodi = '';
    public ?int $tahun_lulus = null;
    public string $no_hp = '';
    public string $alamat = '';
    public ?string $password = null;
    public ?string $password_confirmation = null;

    public function mount(int $id): void
    {
        $this->alumni = AlumniProfile::findOrFail($id);

        $this->email = $this->alumni->user->email;
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
            'email' => 'required|email|max:255|unique:users,email,' . $this->alumni->user_id,
            'nim' => 'required|string|max:20|unique:alumni_profiles,nim,' . $this->alumni->id,
            'nama_lengkap' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'tahun_lulus' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        $user = User::find($this->alumni->user_id);
        if ($user) {
            $userData = [
                'name' => $validated['nama_lengkap'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
            }

            $user->update($userData);
        }

        unset($validated['email'], $validated['password'], $validated['password_confirmation']);

        $this->alumni->update($validated);

        session()->flash('message', 'Data alumni berhasil diperbarui.');

        $this->redirect(route('admin.alumni.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.alumni.alumni-edit');
    }
}
