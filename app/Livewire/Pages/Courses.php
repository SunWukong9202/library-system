<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\CourseForm;
use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Courses extends Component
{
    use WithPagination;

    public CourseForm $form;

    public function load(Course $course): void
    {
        $this->form->setCourse($course);

        $this->dispatch('open-course-form');
    }

    public function create(): void
    {
        $name = $this->saveAndClear();
        
        $this->js("alert('Materia $name creada!');".'$dispatch("close-course-form")');
    }

    public function update(): void
    {
        $name = $this->saveAndClear();

        $this->js("alert('Materia $name actualizada!');".'$dispatch("close-course-form")');
    }

    public function delete(Course $course): void
    {
        $name = $course->name;

        $course->delete();

        $this->resetPage();

        $this->form->pull();

        $this->js("alert('Materia $name eliminada!')");
    }

    public function saveAndClear(): string
    {
        $this->form->save();

        $name = $this->form->name;

        $this->form->pull();

        return $name;
    }

    public function render()
    {
        return view('livewire.pages.courses', [
            'courses' => Course::paginate(6),
        ]);
    }
}
