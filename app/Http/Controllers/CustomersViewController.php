<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CustomersViewController extends Controller
{
    // GET ALL DATA
    public function index(Request $request): View
    {
        try {
            $query = Customer::query();

            if ($request->has("status")) {
                $query->where("status", $request->status === "active");
            }

            $customers = $query->get();

            return view("customers.index", [
                "active" => "customers",
                "customers" => $customers,
            ]);

        } catch (\Exception $e) {
            return view("customers.index", [
                "active" => "customers",
                "customers" => [],
            ]);
        }
    }

    // CREATE DATA
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
            ]);

            Customer::create([
                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
                "status" => $request->status === "active",
            ]);

            return redirect()
                ->route("customers.index")
                ->with("toast_success", "Customer created successfully");

        } catch (\Exception $e) {
            return redirect()
                ->route("customers.index")
                ->with("toast_error", "Failed to create customer: " . $e->getMessage());
        }
    }

    // UPDATE DATA
    public function update(Request $request, int $id): RedirectResponse 
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
            ]);

            $customer = Customer::findOrFail($id);
            
            $customer->update([
                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
                "status" => $request->status === "active",
            ]);

            return redirect()
                ->route("customers.index")
                ->with("toast_success", "Customer updated successfully");

        } catch (\Exception $e) {
            return redirect()
                ->route("customers.index")
                ->with("toast_error", "Failed to update customer");
        }
    }

    // DELETE DATA (Dengan Validasi Improvement Modul)
    public function destroy(int $id): RedirectResponse
    {
        try {
            $customer = Customer::findOrFail($id);

            // Validasi: Customer yang sudah memiliki Subscription tidak boleh dihapus
            if ($customer->subscriptions()->exists()) {
                return redirect()
                    ->route("customers.index")
                    ->with("toast_error", "Customer tidak boleh dihapus karena memiliki subscription aktif!");
            }

            $customer->delete();

            return redirect()
                ->route("customers.index")
                ->with("toast_success", "Customer deleted successfully");
        } catch (\Exception $e) {
            return redirect()
                ->route("customers.index")
                ->with("toast_error", "Failed to delete customer");
        }
    }

    // ACTIVATE
    public function activate(int $id): RedirectResponse
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->update(['status' => true]);
            return redirect()->route("customers.index")->with("toast_success", "Customer activated successfully");
        } catch (\Exception $e) {
            return redirect()->route("customers.index")->with("toast_error", "Failed to activate customer");
        }
    }

    // DEACTIVATE
    public function deactivate(int $id): RedirectResponse
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->update(['status' => false]);
            return redirect()->route("customers.index")->with("toast_success", "Customer deactivated successfully");
        } catch (\Exception $e) {
            return redirect()->route("customers.index")->with("toast_error", "Failed to deactivate customer");
        }
    }
}