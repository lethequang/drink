<?php

// Authentication Routes...
Route::get('login', 'LoginController@showLoginForm')->name('partner.auth.login');
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout')->name('partner.auth.logout');
Route::post('logout', 'LoginController@logout');

Route::group([
    'middleware' => ['web', 'partner'],
], function () {

    Route::get('/', 'IndexController@index')->name('partner');

});
