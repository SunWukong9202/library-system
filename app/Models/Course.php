<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    public function applicants(): BelongsToMany
    {
        // return $this->belongsToMany(
        //     User::class,
        //     table: 'inscriptions',
        //     foreignPivotKey: 'course_id',
        //     relatedPivotKey: 'student_id',
        // )->withPivot('status')
        //  ->withTimestamps()
        //  ->as('inscription');
        return $this->belongsToMany(User::class, 'inscriptions', 'course_id', 'student_id')
            ->as('inscription')->withPivot('status')->withTimestamps()
            ->using(Inscription::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(
                User::class,
                table: 'grades',
                foreignPivotKey: 'course_id',
                relatedPivotKey: 'student_id',
            )->withPivot('grade')
            ->withTimestamps()
            ->as('period');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
