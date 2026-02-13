<?php

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\MinuteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'marketing.home')->name('home');

Route::redirect('/dashboard', '/minutes')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/minutes', [MinuteController::class, 'index'])->name('minutes.index');

    Route::get('/settings/api-tokens', [ApiTokenController::class, 'index'])->name('settings.api-tokens.index');
    Route::post('/settings/api-tokens', [ApiTokenController::class, 'store'])->name('settings.api-tokens.store');
    Route::delete('/settings/api-tokens/{tokenId}', [ApiTokenController::class, 'destroy'])->name('settings.api-tokens.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
