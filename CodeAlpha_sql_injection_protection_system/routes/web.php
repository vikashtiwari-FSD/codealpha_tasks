<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecurityController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/security', [SecurityController::class, 'index'])
        ->name('security');

    Route::post('/security/verify', [SecurityController::class, 'verify'])
        ->name('security.verify');

    Route::get('/security/dashboard', [SecurityController::class, 'dashboard'])
    ->middleware('capability')
    ->name('security.dashboard');

});

require __DIR__.'/auth.php';
