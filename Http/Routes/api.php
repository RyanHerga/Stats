<?php

/**
 * This is publicly accessible
 */
Route::group(['middleware' => []], function() {
    Route::get('/', 'StatsController@index');
});

/**
 * This is required to have a valid API key
 */
Route::group(['middleware' => [
    'api.auth'
]], function() {
    Route::get('/hello', 'StatsController@hello');
});
