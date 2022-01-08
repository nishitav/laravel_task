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

Route::prefix('app')->middleware([\App\Http\Middleware\UserStatusVerify::class])->group(function(){
    Route::post('/create_product', 'ProductsController@store');
    Route::get('/get_products', 'ProductsController@index');
    Route::post('/edit_product', 'ProductsController@update');
    Route::post('/delete_product', 'ProductsController@destroy');

    Route::post('/login', 'HomeController@login');
});

Route::get('/logout', 'HomeController@logout');
Route::get('/', 'HomeController@index');
Route::any('{slug}', 'HomeController@index')->where('path','[-a-z0-9_\s]+');
