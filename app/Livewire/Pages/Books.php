<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Books extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.pages.books');
    }
}
