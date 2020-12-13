<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('availability')->namespace('App\Availability\Infrastructure\Http')->group(function () {
    Route::post('resource/{id}/reservation', 'ReservationController@reserve');
});

Route::prefix('go-cart')->namespace('App\GoCart\Http')->group(function () {
    Route::get('/all', 'GoCartInventoryController@all');
    Route::get('/{id}/reservation', 'GoCartInventoryController@reservations');
    Route::post('/', 'GoCartInventoryController@create');
});
