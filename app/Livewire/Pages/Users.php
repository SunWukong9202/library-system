<?php

namespace App\Livewire\Pages;

use App\Enums\Role;
use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Users extends Component
{
    use WithPagination;

    public UserForm $form;

    public function proxyAction($name, User $user = null): void
    {
        $this->form->handleAction($name, $user);
    }

    public function updateRole(User $user, $role): void
    {
        // dd($user, $role);
        $user->role = Role::from($role);
        $user->update();
        $message = trans('Role updated successfully.');
        $this->js("alert('$message')");
    }

    public function render()
    {
        return view('livewire.pages.users', [
            'users' => User::paginate(6),
        ]);
    }
}
