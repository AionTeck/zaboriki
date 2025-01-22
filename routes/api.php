<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::prefix('fences')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\V1\FenceController::class, 'index']);
        Route::get('/popular-specs', [App\Http\Controllers\Api\V1\FenceController::class, 'getPopularSpecs']);
        Route::get('/types', [App\Http\Controllers\Api\V1\FenceController::class, 'getTypes']);
        Route::get('/{id}', [App\Http\Controllers\Api\V1\FenceController::class, 'show']);
        Route::get('/{id}/specs', [App\Http\Controllers\Api\V1\FenceController::class, 'getSpecs']);
    });

    Route::prefix('gates')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\V1\GateController::class, 'index']);
        Route::get('/types', [App\Http\Controllers\Api\V1\GateController::class, 'getTypes']);
        Route::get('/popular-specs', [App\Http\Controllers\Api\V1\GateController::class, 'getPopularSpecs']);
        Route::get('/{id}', [App\Http\Controllers\Api\V1\GateController::class, 'show']);
        Route::get('/{id}/specs', [App\Http\Controllers\Api\V1\GateController::class, 'getSpecs']);
    });

    Route::prefix('automatic-for-gates')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\V1\AutomaticForGatesController::class, 'index']);
        Route::get('/{id}', [App\Http\Controllers\Api\V1\AutomaticForGatesController::class, 'show']);
    });

    Route::prefix('accessories')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\V1\AccessoriesController::class, 'index']);
        Route::get('/{id}', [App\Http\Controllers\Api\V1\AccessoriesController::class, 'show']);
    });

    Route::prefix('mountings')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\V1\MountingController::class, 'index']);
        Route::get('/{id}', [App\Http\Controllers\Api\V1\MountingController::class, 'view']);
    });

    Route::prefix('clients')->group(function () {
       Route::post('/', [App\Http\Controllers\Api\V1\ClientController::class, 'create']);
    });

    Route::prefix('calculations')->group(function () {
        Route::post('/', [App\Http\Controllers\Api\V1\Calculations::class, 'getDataForPrepareOrder']);
        Route::get('/{report_id}/download-report', [App\Http\Controllers\Api\V1\Calculations::class, 'downloadExportFile']);
    });

    Route::prefix('reports')->group(function () {
        Route::get('/{report_id}/status',
            [App\Http\Controllers\Api\V1\ReportsController::class, 'checkExportOrderStatus']
        );
    });

    Route::get('about', [\App\Http\Controllers\Api\V1\AboutController::class, 'index']);

    Route::post('contact', [\App\Http\Controllers\Api\V1\ContactController::class, 'index']);
});
