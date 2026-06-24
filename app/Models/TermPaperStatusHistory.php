<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TermPaperStatusHistory extends Model
{
    protected $fillable = ['term_paper_id', 'label', 'status', 'happened_at'];
    protected $casts = ['happened_at' => 'datetime'];

    public function termPaper(): BelongsTo
    {
        return $this->belongsTo(TermPaper::class);
    }
}
