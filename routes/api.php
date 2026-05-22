<?php
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SubscriptionController;

Route::get('customers', [CustomerController::class, 'index']);
Route::get('customers/{id}', [CustomerController::class, 'show']);
Route::post('customers', [CustomerController::class, 'store']);
Route::put('customers/{id}', [CustomerController::class, 'update']);
Route::delete('customers/{id}', [CustomerController::class, 'destroy']);

Route::apiResource('subscriptions', SubscriptionController::class);

Route::get('subscriptions/status/{status}', [SubscriptionController::class, 'getByStatus']);
Route::patch('subscriptions/{id}/status', [SubscriptionController::class, 'changeStatus']);

Route::get('customers/status/{status}', [CustomerController::class, 'getByStatus']);
Route::patch('customers/{id}/status', [CustomerController::class, 'changeStatus']);