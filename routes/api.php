<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*
Route::post('/login', 'Api\LoginController@authenticate');

Route::get('profile', function () {
    return Auth::user();
})->middleware('auth');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'Api\AuthController@login');
    Route::post('logout', 'Api\AuthController@logout');
    
    Route::post('forgot', 'Api\AuthController@forgotPassword');

    Route::post('refresh', 'Api\AuthController@refresh');
    //Route::post('reset', 'Api\AuthController@resetPassword');
    Route::post('me', 'Api\AuthController@me')->name('me');
    
});



Route::get('users', 'Api\Admin\UserController@index')->middleware('admin');