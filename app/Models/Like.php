<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * 
     * RELATION
     * 
     */

    /**
     * The user that owns the like.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The meme that owns the like.
     */
    public function meme(): BelongsTo
    {
        return $this->belongsTo(Meme::class);
    }
}
