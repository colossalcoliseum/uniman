<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deadline extends Model
{
    /** @use HasFactory<\Database\Factories\DeadlineFactory> */
    use HasFactory;

    public function termPaper(): BelongsTo
    {
        return $this->belongsTo(TermPaper::class);
    }
}
