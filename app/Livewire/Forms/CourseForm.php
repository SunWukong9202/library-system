<?php

namespace App\Livewire\Forms;

use App\Models\Course;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CourseForm extends Form
{
    public ?Course $course = null;

    #[Validate]
    public $key = '';
    public $name = '';
    public $credits = 8;
    public $start = '07:00';
    public $end = '08:00';
    public $teacher_id = null;

    public function setCourse(Course $course): void
    {
        $this->course = $course;
        $this->key = $course->key;
        $this->name = $course->name;
        $this->credits = $course->credits;
        $this->start = $course->start;
        $this->end = $course->end;
        $this->teacher_id = $course->teacher_id;
    }

    public function rules(): array
    {
        return [
            'key' => [
                'size:6',
                Rule::unique('courses')->ignore($this->course?->id),
            ],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'key' => trans('key')
        ];
    }

    public function save(): void
    {
        $this->validate();   

        Course::updateOrCreate(
            ['id' => $this->course?->id],
            $this->except(['course'])
        );
    }
}
