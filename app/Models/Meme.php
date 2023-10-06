<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meme extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'title',
        'body',
        'file'
    ];


    /**
     * 
     * RELATION
     * 
     */

    /**
     * The user that owns the meme.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The categories that the meme belongs to.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_meme', 'meme_id', 'category_id');
    }

    /**
     * The tags that the meme belongs to.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_meme', 'meme_id', 'tag_id');
    }

    /**
     * The likes that belongs to the meme.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * The comments that belongs to the meme.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
