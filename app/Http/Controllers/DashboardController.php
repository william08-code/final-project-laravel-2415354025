<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil hitungan data dari database (Pastikan model-model ini sudah kamu buat)
        $totalCustomers = Customer::count();
        $totalServices = Service::count();
        $totalSubscriptions = Subscription::count();
        $activeUsers = User::count(); // atau User::where('status', 'active')->count();

        // 2. Arahkan ke folder dashboard.index sesuai struktur filemu
        return view('dashboard.index', compact(
            'totalCustomers', 
            'totalServices', 
            'totalSubscriptions', 
            'activeUsers'
        ));
    }
}