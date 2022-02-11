<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'App\Http\Controllers\Api\AuthController@register');
Route::post('login', 'App\Http\Controllers\Api\AuthController@login')->name('login');

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function () {
        return \Illuminate\Support\Facades\Auth::user();
    });
    Route::post('logout', 'App\Http\Controllers\Api\AuthController@logout');

    Route::get('/articles', 'App\Http\Controllers\Api\ArticleController@collection')->name('articles');
    Route::post('/articles', 'App\Http\Controllers\Api\ArticleController@create');
    Route::get('/articles/{id}', 'App\Http\Controllers\Api\ArticleController@show');
    Route::put('/articles/{id}', 'App\Http\Controllers\Api\ArticleController@update');
    Route::delete('/articles/{id}', 'App\Http\Controllers\Api\ArticleController@delete');

    Route::get('/categories','App\Http\Controllers\Api\CategoryController@collection');
    Route::post('/categories', 'App\Http\Controllers\Api\CategoryController@create');
    Route::get('/categories/{id}', 'App\Http\Controllers\Api\CategoryController@show');
    Route::put('/categories/{id}', 'App\Http\Controllers\Api\CategoryController@update');
    Route::delete('/categories/{id}', 'App\Http\Controllers\Api\CategoryController@delete');

    Route::get('/statistics', 'App\Http\Controllers\Api\StatisticsController@calculate');

    Route::post('/newsletter', 'App\Http\Controllers\Api\NewsletterController@create');

});

