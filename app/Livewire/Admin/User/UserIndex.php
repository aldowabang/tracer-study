<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $user = User::findOrFail($id);
        
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun sendiri.');
            return;
        }
        
        $user->delete();
        session()->flash('message', 'User berhasil dihapus.');
    }

    public function render()
    {
        $users = User::whereIn('role', ['admin', 'prodi'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.user.user-index', [
            'users' => $users,
        ]);
    }
}
