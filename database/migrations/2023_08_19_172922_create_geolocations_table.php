<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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
        Schema::create('geolocations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->ipAddress('ip')->nullable();
            $table->string('country_code')->nullable();
            $table->string('country_name')->nullable();
            $table->string('region_code')->nullable();
            $table->string('region_name')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('metro_code')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geolocations');
    }
};
