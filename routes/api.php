<?php

use App\Http\Controllers\AgancyController;
use App\Http\Controllers\Customer;
use App\Http\Controllers\UserController;
use App\Models\Agancy;
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
//for vue [ web application ]
Route::group(['middleware' => ['auth:sanctum']], function ($route) {

    // manager [post] control routes
    $route->post('/add_agancy', [AgancyController::class, 'createAgancy']);
    $route->post('add_place', [AgancyController::class, 'addPlace']);
    $route->post('add_time', [AgancyController::class, 'addTime']);
    $route->post('create_tour', [AgancyController::class, 'createTour']);
    $route->post('add-tour-with-image', [AgancyController::class, 'addTourPlaceWithImage']);
    $route->post('add_place2tour', [AgancyController::class, 'addPlace2Tour']);
    $route->post('/approve_request',[AgancyController::class,'approveRequest']);
    
    // manager [get] control routes
    $route->get('get_my_agancy', [AgancyController::class, 'getAgancy']);
    $route->get('get_times', [AgancyController::class, 'getTimes']);
    $route->get('get_places', [AgancyController::class, 'getPlaces']);
    $route->get('get_my_agancy_tours', [AgancyController::class, 'getMyAgancyTours']);
    $route->get('get_tour_schedule', [AgancyController::class, 'getTourSchedule']);
    $route->get('get_all_cities', [AgancyController::class, 'getAllCities']);
    $route->get('get_all_requests',[AgancyController::class, 'getAllRequests']);
    $route->get('get_all_places',[AgancyController::class, 'getAllPlaces']);
    $route->get('get_all_times',[AgancyController::class, 'getAllTimes']);
    $route->get('get_agancy_tours_by_manager', [AgancyController::class, 'getAgancyTours']);
});

// for android
Route::group(['middleware' => ['auth:sanctum']], function ($route) {

    // customer [post] control routes
    $route->post('request_adding2tour', [AgancyController::class, 'requestTour']);

    // customer [get] control routes
    $route->get('get_agancy', [Customer::class, 'getAgancy']);
    $route->get('get_all_agancy', [Customer::class, 'getAllAgancy']);
    $route->get('get_agancy_tours', [Customer::class, 'getAgancyTours']);
    $route->get('get_tours',[Customer::class,'getToures']);
    $route->get('get_tour_schedule', [AgancyController::class, 'getTourSchedule']);
    $route->get('get_place_by_id/{id}', [AgancyController::class, 'getPlaceById']);
    $route->post("book_on_tour/{id}",[AgancyController::class,'bookOnTour']);
    $route->post("cancel_tour",[AgancyController::class,'cancelTour']);
    $route->post('get_tours_by_ids', [AgancyController::class, 'getToursByIds']);
    $route->post('get_ids_approved', [AgancyController::class, 'getIdsApproved']);
});
