<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('track')->group(function () {
    Route::post('/', 'TrackController@create');
    Route::get('/', 'TrackController@all');
    Route::patch('/{id}/state', 'KartController@state')->whereUuid('id');
    Route::get('/{id}/reservation', 'TrackController@reservations')->whereUuid('id');
});

Route::prefix('kart')->group(function () {
    Route::post('/', 'KartController@create');
    Route::get('/', 'KartController@all');
    Route::patch('/{id}/state', 'KartController@state')->whereUuid('id');
    Route::get('/{id}/reservation', 'KartController@reservations')->whereUuid('id');
});

Route::prefix('reservation')->group(function () {
    Route::post('/', 'ReservationController@create');
    Route::get('/', 'ReservationController@all');
});
