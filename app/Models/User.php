<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'name',
        'role',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => Role::class,
        'password' => 'hashed',
    ];

    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'inscriptions', 'student_id', 'course_id')
            ->as('inscription')->withPivot('status')->withTimestamps()
            ->using(Inscription::class);
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)
            ->as('transaction')
            ->withPivot('type')
            ->withTimestamps();
    }
}

