<?php

namespace App\Livewire\Admin\Alumni;

use App\Models\AlumniProfile;
use App\Models\User;
use App\Mail\AlumniRegistered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class AlumniCreate extends Component
{
    public string $email = '';
    public string $nim = '';
    public string $nama_lengkap = '';
    public string $prodi = 'S1 Sistem Informasi';
    public ?int $tahun_lulus = null;
    public string $no_hp = '';
    public string $alamat = '';

    protected function rules(): array
    {
        return [
            'email' => 'required|email',
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

        $password = Str::password(12, true, true, false, false);
        
        $user = User::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['nama_lengkap'],
                'password' => Hash::make($password),
                'role' => 'alumni'
            ]
        );

        if (AlumniProfile::where('user_id', $user->id)->exists()) {
            $this->addError('email', 'Akun user ini sudah tertaut dengan profil alumni lain.');
            return;
        }

        AlumniProfile::create([
            'user_id' => $user->id,
            'nim' => $validated['nim'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'prodi' => $validated['prodi'],
            'tahun_lulus' => $validated['tahun_lulus'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
        ]);

        if ($user->wasRecentlyCreated) {
            Mail::to($user->email)->send(new AlumniRegistered($user, $password));
            session()->flash('message', 'Data alumni berhasil ditambahkan. Password dikirim ke email alumni.');
        } else {
            session()->flash('message', 'Data alumni berhasil ditambahkan (User sudah ada sebelumnya).');
        }

        $this->redirect(route('admin.alumni.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.alumni.alumni-create');
    }
}
