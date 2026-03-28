<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recension extends Model
{
    /** @use HasFactory<\Database\Factories\RecensionFactory> */
    use HasFactory;

    public function termPaper(): BelongsTo
    {
        return $this->belongsTo(TermPaper::class);
    }
    public function remark(): BelongsTo
    {
        return $this->belongsTo(Remark::class);
    }
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
