<?php

namespace App\Models;

use App\Utils\FilterableSortableSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;
    use FilterableSortableSearchable;

    protected $guarded = [];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->as('transaction')
            ->withPivot('id', 'type')
            ->withTimestamps();
    }

    public static function formatISBN(string $isbn): string
    {
        $fmt = strlen($isbn) == 13 ? 'XXX-X-XXX-XXXXX-X' : 'X-XXX-XXXXX-X';
        $j = 0;//0-306-40615-2
        for($i = 0; $i < strlen($fmt); $i++) {
            if($fmt[$i] == 'X') {
                $fmt[$i] = $isbn[$j];
                $j++;
            } 
        }
        return $fmt;
    }

    public function groupById(): void
    {
        # code...
    }
}


