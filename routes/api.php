<?php

declare(strict_types=1);

use App\Http\ApiController\KartController;
use App\Http\ApiController\ReservationController;
use App\Http\ApiController\TrackController;
use Illuminate\Support\Facades\Route;

Route::prefix('track')->group(function () {
    Route::post('/', [TrackController::class, 'create']);
    Route::get('/', [TrackController::class, 'all']);
    Route::patch('/{id}/state', [TrackController::class, 'state'])->whereUuid('id');
    Route::get('/{id}/reservation', [TrackController::class, 'reservations'])->whereUuid('id');
});

Route::prefix('kart')->group(function () {
    Route::post('/', [KartController::class, 'create']);
    Route::get('/', [KartController::class, 'all']);
    Route::patch('/{id}/state', [KartController::class, 'state'])->whereUuid('id');
    Route::get('/{id}/reservation', [KartController::class, 'reservation'])->whereUuid('id');
});

Route::prefix('reservation')->group(function () {
    Route::post('/', [ReservationController::class, 'create']);
    Route::get('/', [ReservationController::class, 'all']);
});
