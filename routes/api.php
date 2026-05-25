<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SubscriptionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ================= ROUTE CUSTOMERS =================
Route::get('customers', [CustomerController::class, 'index']);
Route::get('customers/{id}', [CustomerController::class, 'show']);
Route::post('customers', [CustomerController::class, 'store']);
Route::put('customers/{id}', [CustomerController::class, 'update']);
Route::delete('customers/{id}', [CustomerController::class, 'destroy']);
Route::get('customers/status/{status}', [CustomerController::class, 'getByStatus']);
Route::patch('customers/{id}/status', [CustomerController::class, 'changeStatus']);

// ================= ROUTE SERVICES =================
// Menambahkan route service yang sebelumnya hilang
Route::get('services', [ServiceController::class, 'index']);
Route::get('services/{id}', [ServiceController::class, 'show']);
Route::post('services', [ServiceController::class, 'store']);
Route::put('services/{id}', [ServiceController::class, 'update']);
Route::delete('services/{id}', [ServiceController::class, 'destroy']);

// ================= ROUTE SUBSCRIPTIONS =================
Route::apiResource('subscriptions', SubscriptionController::class);
Route::get('subscriptions/status/{status}', [SubscriptionController::class, 'getByStatus']);
Route::patch('subscriptions/{id}/status', [SubscriptionController::class, 'changeStatus']);