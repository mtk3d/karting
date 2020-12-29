<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('availability')->namespace('App\Availability\Infrastructure\Http')->group(function () {
    Route::post('resources/{id}/reservations', 'ReservationController@reserve');
    Route::patch('resources/{id}', 'AvailabilityController@changeResource');
});

Route::prefix('go-cart')->namespace('App\GoCart\Http')->group(function () {
    Route::get('/all', 'GoCartInventoryController@all');
    Route::get('/{id}/reservations', 'GoCartInventoryController@reservations');
    Route::post('/', 'GoCartInventoryController@create');
});

Route::prefix('track')->namespace('App\Track\Http')->group(function () {
    Route::get('/all', 'TrackInventoryController@all');
    Route::get('/{id}/reservations', 'TrackInventoryController@reservations');
    Route::post('/', 'TrackInventoryController@create');
});
