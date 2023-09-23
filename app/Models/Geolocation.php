<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Geolocation extends Model
{
    // data comming from => https://api.ipbase.com/v1/json/$ip_address
    use HasFactory, SoftDeletes;


    // ip : "41.249.24.187"
    // country_code : "MA"
    // country_name : "Morocco"
    // region_code : null
    // region_name : "Rabat-Salé-Zemmour-Zaer"
    // city : "Rabat"
    // zip_code : "10104"
    // time_zone : "Africa/Casablanca"
    // latitude : 33.957115173339844
    // longitude : -6.868826866149902
    // metro_code : 0
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ip',
        'country_code',
        'country_name',
        'region_code',
        'region_name',
        'city',
        'zip_code',
        'time_zone',
        'latitude',
        'longitude',
        'metro_code'
    ];


    /**
     * 
     * RELATION
     * 
     */

    /**
     * The user that owns the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
