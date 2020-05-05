<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});

// Start Page
Route::get('/', 'CurrencyDateController@ChartInfoWelcome') -> name('welcome');

// CBR Currents
Route::get('/cbr-list', 'CurrencyController@load') -> name('cbr-list');
Route::get('/cbr-base', 'CurrencyDateController@load') -> name ('cbr-base');
Route::get('/cbr-last', 'CurrencyDateController@getLastValues') -> name ('cbr-last');
Route::get('/cbr-last/{NumCode}', 'CurrencyDateController@getLastValuesID') -> name('cbr-last-id');
Route::get('/cbr-chart/{NumCode}', 'CurrencyDateController@chartDataID') -> name('cbr-chart-id');
Route::get('/cbr-info', 'CurrencyDateController@ChartInfo') -> name('cbr-info');

Route::get('/start', 'StartController@index')->name('start');

Route::get('/start/get-json', 'StartController@getJson')->name('start_json');

Route::get('/start/data-chart', 'StartController@chartData')->name('start_chart');

Route::get('/start/random-chart', 'StartController@chartRandom')->name('start_random');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Резервный маршрут
Route::fallback(function() {
    return 'Хм… Почему ты оказался здесь?';
});


