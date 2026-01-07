<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManageUsers extends Component
{
    public $users;
    public $name, $email, $password, $role = 'cashier';
    public $editingUserId = null;
    public $showModal = false; // modal visibility

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::all();
    }

    // Open modal for new user
    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    // Close modal
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'cashier';
        $this->editingUserId = null;
    }

    public function saveUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->editingUserId,
            'password' => $this->editingUserId ? 'nullable|min:6' : 'required|min:6',
            'role' => 'required|in:admin,manager,cashier',
        ]);

        if ($this->editingUserId) {
            $user = User::find($this->editingUserId);
            $user->name = $this->name;
            $user->email = $this->email;
            if ($this->password) {
                $user->password = Hash::make($this->password);
            }
            $user->role = $this->role;
            $user->save();
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => $this->role,
            ]);
        }

        $this->loadUsers();
        $this->closeModal(); // close modal after saving
        session()->flash('success', 'User saved successfully.');
    }

    // Edit user: open modal with pre-filled data
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = ''; // optional: leave empty for edit
        $this->showModal = true; // open modal for editing
    }

    // Delete user safely
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Check if user has related sales
        if ($user->sales()->count() > 0) {
            session()->flash('error', 'Cannot delete user: user has associated sales.');
            return;
        }

        $user->delete();
        $this->loadUsers();
        session()->flash('success', 'User deleted successfully.');
    }

    public function render()
    {
        return view('livewire.users.manage-users');
    }
}
