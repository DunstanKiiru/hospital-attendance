<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserManager extends Component
{
    public $name, $email, $password, $role, $user_id;
    public $isEdit = false;

    public $perPage = 10;
    public $search = '';

    public function updatedSearch()
    {
        // No need to reload users here, render will be called automatically
    }

    public function updatedPerPage()
    {
        // No need to reload users here, render will be called automatically
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.user-manager', ['users' => $users]);
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'Employee';
        $this->user_id = null;
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role
        ]);

        session()->flash('success', 'User created successfully.');
        $this->resetForm();
        $this->loadUsers();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,{$this->user_id}",
            'role' => 'required'
        ]);

        $user = User::findOrFail($this->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        session()->flash('success', 'User updated successfully.');
        $this->resetForm();
        $this->loadUsers();
    }

    public function delete($id)
    {
        User::destroy($id);
        session()->flash('success', 'User deleted.');
        $this->loadUsers();
    }

    public function sendResetLink($id)
    {
        $user = User::findOrFail($id);
        Password::sendResetLink(['email' => $user->email]);
        session()->flash('success', 'Reset link sent.');
    }
}
