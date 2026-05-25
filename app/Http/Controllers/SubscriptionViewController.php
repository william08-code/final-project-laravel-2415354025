<?php

namespace App\Http\Controllers;

use App\Models\Subscription; 
use App\Models\Customer;     
use App\Models\Service;      
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SubscriptionViewController extends Controller
{
    // 1. GET ALL DATA
    public function index(): View
    {
        try {
            $subscriptions = Subscription::with(['customer', 'service'])->get();
            $customers = Customer::all();
            $services = Service::all();

            return view("subscriptions.index", [
                "active" => "subscriptions",
                "subscriptions" => $subscriptions,
                "customers" => $customers,
                "services" => $services,
            ]);

        } catch (\Exception $e) {
            return view("subscriptions.index", [
                "active" => "subscriptions",
                "subscriptions" => [],
                "customers" => [],
                "services" => [],
            ]);
        }
    }

    // 2. FUNGSI SAVE (MENANGKAP DATE DARI FORM & PRICE DARI DATABASE)
    public function store(Request $request)
    {
        try {
            // Validasi inputan yang dikirim dari Form Blade
            $request->validate([
                'customer_id' => 'required',
                'service_id' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);

            // Ambil data service untuk mendapatkan harga aslinya secara otomatis
            $service = Service::findOrFail($request->service_id);

            // Simpan data langsung ke database
            $subscription = Subscription::create([
                "customer_id" => $request->customer_id,
                "service_id" => $request->service_id,
                "price" => $service->price ?? 0, // Otomatis mengambil harga asli dari database Service
                "billing_cycle" => 'monthly',    // Nilai default pengaman database
                "start_date" => $request->start_date,
                "end_date" => $request->end_date,
                "status" => $request->status ?? 'active', 
            ]);

            // Muat relasi nama customer dan service sebelum dilempar kembali ke AJAX
            $subscription->load(['customer', 'service']);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Subscription created successfully!',
                    'data' => [
                        'id' => $subscription->id,
                        'customer_name' => $subscription->customer->name ?? '-',
                        'service_name' => $subscription->service->name ?? '-',
                        'start_date' => $subscription->start_date,
                        'end_date' => $subscription->end_date,
                        'status' => $subscription->status
                    ]
                ]);
            }

            return redirect()->route("subscriptions.index")->with("toast_success", "Subscription created successfully");

        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            return redirect()->route("subscriptions.index")->with("toast_error", "Failed: " . $e->getMessage());
        }
    }

    // 3. UPDATE DATA
    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $request->validate([
                'customer_id' => 'required',
                'service_id' => 'required',
                'price' => 'required',
            ]);

            $subscription = Subscription::findOrFail($id);

            if ($subscription->status === 'dismantle') {
                return redirect()->route("subscriptions.index")->with("toast_error", "Status Subscription yang saat ini dismantle tidak bisa diubah ke status lain.");
            }

            $subscription->update([
                "customer_id" => $request->customer_id,
                "service_id" => $request->service_id,
                "price" => $request->price,
                "status" => $request->status,
            ]);

            return redirect()->route("subscriptions.index")->with("toast_success", "Subscription updated successfully");
        } catch (\Exception $e) {
            return redirect()->route("subscriptions.index")->with("toast_error", "Failed to update subscription");
        }
    }

    // 4. DELETE DATA
    public function destroy(int $id): RedirectResponse
    {
        try {
            $subscription = Subscription::findOrFail($id);
            $subscription->delete();

            return redirect()->route("subscriptions.index")->with("toast_success", "Subscription deleted successfully");
        } catch (\Exception $e) {
            return redirect()->route("subscriptions.index")->with("toast_error", "Failed to delete subscription");
        }
    }

    // 5. CHANGE STATUS ACTION
    public function changeStatus(Request $request, int $id): RedirectResponse
    {
        try {
            $subscription = Subscription::findOrFail($id);

            if ($subscription->status === 'dismantle') {
                return redirect()->route("subscriptions.index")->with("toast_error", "Status Subscription yang saat ini dismantle tidak bisa diubah ke status lain.");
            }

            $subscription->update(['status' => $request->status]);
            return redirect()->route("subscriptions.index")->with("toast_success", "Status updated to " . $request->status);
        } catch (\Exception $e) {
            return redirect()->route("subscriptions.index")->with("toast_error", "Failed to update status");
        }
    }
}