<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
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

Route::middleware(['auth:sanctum','admin'])
    ->group(function (){
        Route::get('/user', [AuthController::class , 'getUserLogged']);
        Route::post('/logout',[AuthController::class,'logout']);
        Route::get('/countries' , [\App\Http\Controllers\API\CountryController::class,'index']);

        Route::apiResource('products', ProductController::class);
        Route::apiResource('orders', OrderController::class);
        Route::apiResource('users', UserController::class);
        Route::apiResource('customers', CustomerController::class);

        Route::get('/dashboard/customers-count',[DashboardController::class,'customersTotal']);
        Route::get('/dashboard/products-count',[DashboardController::class,'activeProducts']);
        Route::get('/dashboard/total-profit',[DashboardController::class,'totalProfit']);
        Route::get('/dashboard/orders-paid-count',[DashboardController::class,'paidOrders']);
        Route::get('/dashboard/orders-by-country',[DashboardController::class,'ordersPaidByCountry']);
        Route::get('/dashboard/latest-customers',[DashboardController::class,'latestCustomers']);
        Route::get('/dashboard/latest-orders',[DashboardController::class,'latestOrders']);

});

Route::post('/login', [AuthController::class,'login']);
