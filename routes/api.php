<?php

use App\Http\Controllers\Api\MinuteController;
use App\Http\Controllers\Api\MinutesPreferenceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/v1/me/minutes-preferences', [MinutesPreferenceController::class, 'show']);

    Route::post('/v1/minutes', [MinuteController::class, 'store']);
});
