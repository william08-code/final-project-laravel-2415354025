@extends('layouts.app')

@section('content')

<div class="mb-8">
    <h1 class="text-4xl font-bold primary-color mb-2">
        Dashboard
    </h1>

    <p class="text-gray-500">
        Welcome back to ERP Management System
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

    <div class="bg-white rounded-3xl p-6 card-shadow">
        <p class="secondary-color mb-2">
            Total Customers
        </p>

        <h2 class="text-4xl font-bold primary-color">
            {{ $totalCustomers }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl p-6 card-shadow">
        <p class="secondary-color mb-2">
            Total Services
        </p>

        <h2 class="text-4xl font-bold primary-color">
            {{ $totalServices }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl p-6 card-shadow">
        <p class="secondary-color mb-2">
            Total Subscriptions
        </p>

        <h2 class="text-4xl font-bold primary-color">
            {{ $totalSubscriptions }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl p-6 card-shadow">
        <p class="secondary-color mb-2">
            Active Users
        </p>

        <h2 class="text-4xl font-bold primary-color">
            {{ $activeUsers }}
        </h2>
    </div>

</div>

@endsection