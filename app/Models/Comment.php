<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const UPDATED_AT = null;

    public function publication(): BelongsTo
    {
        return $this->belongsTo(Publication::class);
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }
}
