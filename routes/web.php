<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\GuestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

// use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');



// Route::get('/guest', [GuestController::class, 'index'])->name('index');  
Route::get('/', [HomeController::class, 'home'])->name('home');






Route::middleware('auth')->group(function () {
    // admin area
    Route::prefix('/admin')->group(function(){
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });

    // users area
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // logged in users
    
    
});



require __DIR__.'/auth.php';