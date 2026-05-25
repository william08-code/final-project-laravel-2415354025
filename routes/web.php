<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomersViewController;
use App\Http\Controllers\ServiceViewController;
use App\Http\Controllers\SubscriptionViewController;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



/*
|--------------------------------------------------------------------------
| CUSTOMERS
|--------------------------------------------------------------------------
*/

Route::get('/customers', [CustomersViewController::class, 'index'])
    ->name('customers.index');

Route::post('/customers', [CustomersViewController::class, 'store'])
    ->name('customers.store');

Route::patch('/customers/{id}', [CustomersViewController::class, 'update'])
    ->name('customers.update');

Route::delete('/customers/{id}', [CustomersViewController::class, 'destroy'])
    ->name('customers.destroy');

Route::patch('/customers/{id}/activate', [CustomersViewController::class, 'activate'])
    ->name('customers.activate');

Route::patch('/customers/{id}/deactivate', [CustomersViewController::class, 'deactivate'])
    ->name('customers.deactivate');



/*
|--------------------------------------------------------------------------
| SERVICES
|--------------------------------------------------------------------------
*/

Route::get('/services', [ServiceViewController::class, 'index'])
    ->name('services.index');

Route::post('/services', [ServiceViewController::class, 'store'])
    ->name('services.store');

Route::patch('/services/{id}', [ServiceViewController::class, 'update'])
    ->name('services.update');

Route::delete('/services/{id}', [ServiceViewController::class, 'destroy'])
    ->name('services.destroy');

Route::patch('/services/{id}/activate', [ServiceViewController::class, 'activate'])
    ->name('services.activate');

Route::patch('/services/{id}/deactivate', [ServiceViewController::class, 'deactivate'])
    ->name('services.deactivate');



/*
|--------------------------------------------------------------------------
| SUBSCRIPTIONS
|--------------------------------------------------------------------------
*/

Route::get('/subscriptions', [SubscriptionViewController::class, 'index'])
    ->name('subscriptions.index');

Route::post('/subscriptions', [SubscriptionViewController::class, 'store'])
    ->name('subscriptions.store');

Route::patch('/subscriptions/{id}', [SubscriptionViewController::class, 'update'])
    ->name('subscriptions.update');

Route::delete('/subscriptions/{id}', [SubscriptionViewController::class, 'destroy'])
    ->name('subscriptions.destroy');

// INI ROUTE BARU YANG MEMEGANG SEMUA AKSI PERUBAHAN STATUS (ACTIVATE, ISOLIR, TRIAL, DEACTIVATE, DISMANTLE)
Route::patch('/subscriptions/{id}/change-status', [SubscriptionViewController::class, 'changeStatus'])
    ->name('subscriptions.changeStatus');