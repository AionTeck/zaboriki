<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::prefix('fences')->group(function () {
        Route::get('', [\App\Http\Controllers\Api\V1\FenceController::class, 'index']);
        Route::get('types', [\App\Http\Controllers\Api\V1\FenceController::class, 'getTypes']);
    });
});
