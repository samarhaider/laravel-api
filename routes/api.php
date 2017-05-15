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
//    $api->post('users/register', 'App\Http\Controllers\UserController@store');
////    $api->post('auth/login', 'App\Http\Controllers\UserController@login');
    $api->post('auth/login', 'App\Http\Controllers\Auth\LoginController@login');
//    $api->post('users/forgot', 'App\Http\Controllers\UserController@sendPasswordResetCode');
//    $api->post('users/reset-password', 'App\Http\Controllers\UserController@setPassword');
});

# Private Actions
$api->version('v1', ['middleware' => 'jwt.auth'], function ($api) {
    # Users
    $api->resource('users', 'App\Http\Controllers\UserController');
    # Clients
    $api->resource('clients', 'App\Http\Controllers\ClientController');
    # Measurements
    $api->get('measurements/client/{id}', 'App\Http\Controllers\MeasurementController@clientMeasurement');
    $api->resource('measurements', 'App\Http\Controllers\MeasurementController');
    #Bookings
    $api->get('bookings/client/{id}', 'App\Http\Controllers\BookingController@clientBooking');
    $api->resource('bookings', 'App\Http\Controllers\BookingController');
    # Payments
    $api->get('payments/client/{id}', 'App\Http\Controllers\PaymentController@clientPayment');
    $api->resource('payments', 'App\Http\Controllers\PaymentController');
    # Session Types
    $api->resource('session-types', 'App\Http\Controllers\SessionTypeController');
});

//$api->version('v1', ['middleware' => 'auth:client'], function ($api) {
//    $api->get('measurements/client/{id}', 'App\Http\Controllers\MeasurementController@clientMeasurement');
//    $api->get('measurements/{id}', 'App\Http\Controllers\MeasurementController@show');
//
//    $api->get('payments', 'App\Http\Controllers\PaymentController');
//    $api->get('payments/{id}', 'App\Http\Controllers\PaymentController@show');
//});

