<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;

class UserForm extends Form
{
    public ?User $user = null;
    #[Validate('required', attribute: 'Nombre')]
    public $name = '';
    #[Validate]
    public $email = '';
    #[Validate]
    public $key = '';
    public $generated_password;
    public $password;
    public $role = Role::Student;

    public function rules(): array
    {
        return [
            'key' => [
                'size:6',
                Rule::unique('users')->ignore($this->user?->id),
            ],
            'email' => Rule::unique('users')->ignore($this->user?->id)
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'key' => trans('key'),
            'email' => trans('email'),
        ];
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->key = $user->key;
        $this->role = $user->role;
        $this->generated_password = null;
    }

    public function generatePassword() {
        $this->generated_password = Str::password(12);
        return $this->generated_password;
    }

    public function save(): void
    {
        $remove = ['generated_password', 'user'];

        $this->validate();

        if($this->generated_password) {
            $this->password = Hash::make($this->generated_password);
        } else {
            $remove[] = 'password';
        }

        User::updateOrCreate(
            ['id' => $this->user?->id],
            $this->except($remove)
        );
    }
}
