<?php
use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


$api = app('Dingo\Api\Routing\Router');

# Public Actions
$api->version('v1', function ($api) {
    $api->post('users/register', 'App\Http\Controllers\UserController@store');
    $api->post('users/login/', 'App\Http\Controllers\UserController@login');
    $api->post('users/send-password-reset-code', 'App\Http\Controllers\UserController@sendPasswordResetCode');
    $api->post('users/reset-password', 'App\Http\Controllers\UserController@setPassword');
});

# Private Actions
$api->version('v1', ['middleware' => 'jwt.auth'], function ($api) {
    $api->resource('users', 'App\Http\Controllers\UserController');
});

