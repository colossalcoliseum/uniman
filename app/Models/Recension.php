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

    protected $fillable = [
        'title',
        'term_paper_id',
        'remark_id',
        'reviewer_id',
        'status',
        'final_verdict',
        'passed',
    ];
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
