<?php

declare(strict_types=1);

use App\Http\Controller\ReservationController;
use App\Http\Controller\TrackController;
use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index');

Route::prefix('reservation')->group(function () {
    Route::get('/', [ReservationController::class, 'index']);
    Route::get('/create', [ReservationController::class, 'create']);
    Route::post('/create', [ReservationController::class, 'reserve']);
});

Route::prefix('track')->group(function () {
    Route::get('/', [TrackController::class, 'index']);
});
