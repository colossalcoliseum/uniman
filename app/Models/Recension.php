<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recension extends Model
{
    /** @use HasFactory<\Database\Factories\RecensionFactory> */
    use HasFactory;
    use SoftDeletes;


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
        return $this->belongsTo(User::class, 'reviewer_id');
    }

}
