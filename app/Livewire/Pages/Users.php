<?php

namespace App\Livewire\Pages;

use App\Enums\Role;
use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Users extends Component
{
    public UserForm $form;

    public $password;
 
    public function loadUser(User $user): void
    {
        $this->form->setUser($user);

        $this->dispatch('open-user-form');
    }

    public function regenerate(): void
    {
        $this->password = $this->form->generatePassword();

        $this->save();

        $this->dispatch('updated-user');
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function test(): void
    {
        $this->dispatch('created-user');
    }

    public function create(): void
    {
        $this->password = $this->form->generatePassword();
        $name = $this->save();
        $this->dispatch('updated-user');
    }

    public function save(): string
    {
        $this->form->save();

        $name = $this->form->name;

        $this->form->pull();

        return $name;
    }

    public function update(): void
    {        
        $name = $this->form->save();

        $this->js("alert('Usuario $name editado!');".'$dispatch("close-user-form")');
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
            'users' => User::all(),
        ]);
    }
}
