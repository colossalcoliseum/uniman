<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultation extends Model
{
    /** @use HasFactory<\Database\Factories\ConsultationFactory> */
    use HasFactory;

    public function termPaper(): BelongsTo
    {
        return $this->belongsTo(TermPaper::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
