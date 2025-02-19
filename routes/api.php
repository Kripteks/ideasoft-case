<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\DiscountController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('orders', [OrderController::class, 'index']);
Route::post('orders', [OrderController::class, 'store']);
Route::get('orders/{order}', [OrderController::class, 'show']);
Route::delete('orders/{order}', [OrderController::class, 'destroy']);


Route::get('orders/discount/{id}', [DiscountController::class, 'calculateDiscount']);
