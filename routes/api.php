<?php

use App\Http\Controllers\AgancyController;
use App\Http\Controllers\UserController;
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

Route::post('login', [UserController::class, 'login']);
Route::post('signup', [UserController::class, 'signUp']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth:sanctum']], function ($route) {

    // manager [post] control routes
    $route->post('add_agancy', [AgancyController::class, 'createAgancy']);
    $route->post('add_place', [AgancyController::class, 'addPlace']);
    $route->post('add_time', [AgancyController::class, 'addTime']);
    $route->post('create_tour', [AgancyController::class, 'createTour']);
    $route->post('add_place2tour', [AgancyController::class, 'addPlace2Tour']);

    // manager [get] control routes
    $route->get('get_agancy', [AgancyController::class, 'getAgancy']);
    $route->get('get_times', [AgancyController::class, 'getTimes']);
    $route->get('get_places', [AgancyController::class, 'getPlaces']);
    $route->get('get_my_agancy_tours', [AgancyController::class, 'getMyAgancyTours']);
    $route->get('get_tour_schedule', [AgancyController::class, 'getTourSchedule']);
});
