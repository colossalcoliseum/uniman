<?php

namespace App\Models;

use App\Enums\TermPaperStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TermPaper extends Model
{
    /** @use HasFactory<\Database\Factories\TermPaperFactory> */
    use HasFactory;

    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => TermPaperStatus::class,
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function remark(): BelongsTo
    {
        return $this->belongsTo(Remark::class);
    }  public function institution(): BelongsTo
    {
        return $this->belongsTo(Remark::class);
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Remark::class);
    }
}
