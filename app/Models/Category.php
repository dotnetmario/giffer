<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rank',
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
        return $this->belongsToMany(Meme::class, 'category_meme', 'category_id', 'meme_id');
    }
}