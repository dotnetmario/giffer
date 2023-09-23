<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];


    /**
     * 
     * RELATION
     * 
     */

    /**
     * The memes that belong to the category.
     */
    public function memes(): BelongsToMany
    {
        return $this->belongsToMany(Meme::class, 'tag_meme', 'tag_id', 'meme_id');
    }
}
