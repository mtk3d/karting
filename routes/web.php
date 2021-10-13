<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index');

Route::prefix('reservation')->group(function () {
    Route::get('/', 'ReservationController@index');
    Route::get('/create', 'ReservationController@create');
    Route::post('/create', 'ReservationController@reserve');
});

Route::prefix('track')->group(function () {
    Route::get('/', 'TrackController@index');
});
