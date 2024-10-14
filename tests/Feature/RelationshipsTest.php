<?php

namespace Tests\Feature;

use App\Enums\InscriptionStatus;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelationshipsTest extends TestCase
{
    use RefreshDatabase;

    private ?User $user;
    private ?Course $course;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->course = Course::factory()->create();

        $this->user->courses()->attach(
            $this->course->id,
            ['grade' => 80]
        );

        $this->user->applications()->attach(
            $this->course->id,
            ['status' => InscriptionStatus::Pending]
        );

        $this->user->teaches()->save($this->course);

    }

    public function test_student_can_make_applications_to_courses(): void
    {
        $this->assertTrue(
            $this->user->applications()->first()->id == $this->course->id
        );
    }

    public function test_student_application_status_can_cast_to_enum()
    {
        $this->assertTrue($this->user->applications()->first()->inscription->status === InscriptionStatus::Pending);
    }

    public function test_course_has_applications(): void
    {
        $this->assertTrue($this->course->applicants()->first()->id == $this->user->id);
    }

    public function test_teacher_can_select_courses(): void
    {
        $this->assertTrue($this->user->teaches()->first()->id == $this->course->id);
    }

    public function test_course_is_teached_by_a_teacher(): void
    {
        $this->assertTrue($this->course->teacher->id == $this->user->id);
    }    

    public function test_teacher_can_grade_students(): void 
    {
        $this->assertTrue($this->user->courses()->first()->id == $this->course->id);
    }

    public function test_can_read_grade_of_grades_table(): void
    {
        $this->assertTrue($this->user->courses()->first()->period->grade == 80);
    }

    public function test_course_has_students_to_grade(): void
    {
        $this->assertTrue($this->course->students()->first()->id == $this->user->id);
    }
}
