<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Specialty extends Model
{
    /** @use HasFactory<\Database\Factories\SpecialtyFactory> */
    use HasFactory;

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }
}
