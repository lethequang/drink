<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
//Route::get('/', function () {
//    return view('welcome');
//});
//
// Auth::routes();

// Trang chủ
Route::get('/', ['as' => 'fe.home', 'uses' => 'Frontend\IndexController@index']);
Route::get('/v2', ['as' => 'fe.home-v2', 'uses' => 'Frontend\IndexController@index_v2']);
Route::get('/tim-kiem', ['as' => 'fe.search.index', 'uses' => 'Frontend\SearchController@index']);
Route::get('/tin-noi-bat', ['as' => 'fe.asset.hot', 'uses' => 'Frontend\AssetController@hot']);
Route::get('/nha-dat-cho-thue', ['as' => 'fe.asset.lease', 'uses' => 'Frontend\AssetController@index']);
Route::get('/nha-dat-can-thue', ['as' => 'fe.asset.buy', 'uses' => 'Frontend\AssetController@buy']);
Route::get('/{slug}-a{id}.html', ['as' => 'fe.asset.show', 'uses' => 'Frontend\AssetController@show'])
    ->where(['slug' => '[a-z\-0-9]+', 'id' => '[0-9]+']);

Route::get('/tin-tuc', ['as' => 'fe.article.index', 'uses' => 'Frontend\ArticleController@index']);
Route::get('/lien-he', ['as' => 'fe.contact.index', 'uses' => 'Frontend\ContactController@index']);
Route::post('/lien-he', ['uses' => 'Frontend\ContactController@store'])->name('fecontact');

Route::get('/phong-thuy', ['as' => 'fe.article.fengshui', 'uses' => 'Frontend\ArticleController@fengshui']);
Route::get('tin-tuc/{slug}-n{id}.html', ['as' => 'fe.article.show', 'uses' => 'Frontend\ArticleController@show'])
    ->where(['slug' => '[a-z\-0-9]+', 'id' => '[0-9]+']);
Route::get('phong-thuy/{slug}-n{id}.html', ['as' => 'fe.article.show', 'uses' => 'Frontend\ArticleController@showFengshui'])
    ->where(['slug' => '[a-z\-0-9]+', 'id' => '[0-9]+']);

Route::group(['prefix' => 'location'], function () {
    Route::get('/', 'LocationController@index')->name('location');
    Route::get('get-provinces', 'LocationController@get_provinces')->name('location.provinces');
    Route::get('get-provinces', 'LocationController@get_provinces');
    Route::get('get-districts', 'LocationController@get_districts');
    Route::get('get-wards', 'LocationController@get_wards');
    Route::get('geo-ids-by-address', 'LocationController@geoIdsByAddress');
});

Route::group(['prefix' => 'cache'], function () {
    Route::get('/update-js-data', 'CacheController@update_js_data')->name('cache.update-js-data');
    Route::get('/update-img', 'CacheController@update_img')->name('cache.update-img');
    Route::get('/update-js', 'CacheController@update_js')->name('cache.update-js');
    Route::get('/update-css', 'CacheController@update_css')->name('cache.update-css');
    Route::get('/update-all', 'CacheController@update_all')->name('cache.update-all');
});

/** CATCH-ALL ROUTE for Backpack/PageManager - needs to be at the end of your routes.php file  **/
Route::get('{page}/{subs?}', ['uses' => 'PageController@index'])
    ->where(['page' => '^((?!panel-kht|html|html-admin|uploads|css|js|templates|).)*$', 'subs' => '.*']);


