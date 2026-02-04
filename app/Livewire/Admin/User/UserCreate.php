<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserCreate extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'prodi';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,prodi',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role tidak valid.',
        ];
    }

    public function save(): void
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'email_verified_at' => now(),
        ]);

        session()->flash('message', 'User berhasil ditambahkan.');
        $this->redirect(route('admin.users.index'));
    }

    public function render()
    {
        return view('livewire.admin.user.user-create');
    }
}
