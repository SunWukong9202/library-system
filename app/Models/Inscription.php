<?php

namespace App\Models;

use App\Enums\InscriptionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Inscription extends Pivot
{
    use HasFactory;

    protected $table = 'inscriptions';
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    protected function casts(): array
    {
        return [
            'status' => InscriptionStatus::class,
        ];
    }
}
