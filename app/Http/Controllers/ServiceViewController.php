<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ServiceViewController extends Controller
{
    // GET ALL DATA
    public function index(Request $request): View
    {
        try {
            $query = Service::query();

            if ($request->has("status")) {
                $query->where("status", $request->status === "active");
            }

            $services = $query->get();

            return view("services.index", [
                "active" => "services",
                "services" => $services,
            ]);

        } catch (\Exception $e) {
            return view("services.index", [
                "active" => "services",
                "services" => [],
            ]);
        }
    }

    // CREATE DATA
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'name' => 'required',
                'price' => 'required',
            ]);

            Service::create([
                "name" => $request->name,
                "price" => $request->price,
                "description" => $request->description,
                "status" => $request->status === "active",
            ]);

            return redirect()
                ->route("services.index")
                ->with("toast_success", "Service created successfully");

        } catch (\Exception $e) {
            return redirect()
                ->route("services.index")
                ->with("toast_error", "Failed to create service: " . $e->getMessage());
        }
    }

    // UPDATE DATA
    public function update(Request $request, int $id): RedirectResponse 
    {
        try {
            $request->validate([
                'name' => 'required',
                'price' => 'required',
            ]);

            $service = Service::findOrFail($id);
            
            $service->update([
                "name" => $request->name,
                "price" => $request->price,
                "description" => $request->description,
                "status" => $request->status === "active",
            ]);

            return redirect()
                ->route("services.index")
                ->with("toast_success", "Service updated successfully");

        } catch (\Exception $e) {
            return redirect()
                ->route("services.index")
                ->with("toast_error", "Failed to update service");
        }
    }

    // DELETE DATA (Dengan Validasi Improvement Modul)
    public function destroy(int $id): RedirectResponse
    {
        try {
            $service = Service::findOrFail($id);

            // Validasi: Service yang sudah memiliki Subscription tidak boleh dihapus
            if ($service->subscriptions()->exists()) {
                return redirect()
                    ->route("services.index")
                    ->with("toast_error", "Service tidak boleh dihapus karena sedang digunakan dalam subscription!");
            }

            $service->delete();

            return redirect()
                ->route("services.index")
                ->with("toast_success", "Service deleted successfully");
        } catch (\Exception $e) {
            return redirect()
                ->route("services.index")
                ->with("toast_error", "Failed to delete service");
        }
    }

    // ACTIVATE
    public function activate(int $id): RedirectResponse
    {
        try {
            $service = Service::findOrFail($id);
            $service->update(['status' => true]);
            return redirect()->route("services.index")->with("toast_success", "Service activated successfully");
        } catch (\Exception $e) {
            return redirect()->route("services.index")->with("toast_error", "Failed to activate service");
        }
    }

    // DEACTIVATE
    public function deactivate(int $id): RedirectResponse
    {
        try {
            $service = Service::findOrFail($id);
            $service->update(['status' => false]);
            return redirect()->route("services.index")->with("toast_success", "Service deactivated successfully");
        } catch (\Exception $e) {
            return redirect()->route("services.index")->with("toast_error", "Failed to deactivate service");
        }
    }
}