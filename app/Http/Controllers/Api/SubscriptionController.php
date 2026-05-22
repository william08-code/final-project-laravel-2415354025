<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    // 1. CREATE
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'service_id' => ['required', 'exists:services,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'string'],
        ]);

        $data['status'] = $data['status'] ?? 'active';

        $subscription = Subscription::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Subscription created successfully',
            'data' => $subscription,
        ], 201);
    }

    // 2. GET ALL
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Subscription::with(['customer', 'service'])->latest()->get(),
        ]);
    }

    // 3. GET BY ID
    public function show(int $id): JsonResponse
    {
        $subscription = Subscription::with(['customer', 'service'])->find($id);

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $subscription,
        ]);
    }

    // 4. UPDATE
    public function update(Request $request, int $id): JsonResponse
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
            ], 404);
        }

        $data = $request->validate([
            'start_date' => ['sometimes', 'date'],
            'end_date' => ['sometimes', 'date'],
            'status' => ['sometimes', 'string'],
        ]);

        $subscription->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Subscription updated successfully',
            'data' => $subscription,
        ]);
    }

    // 5. DELETE
    public function destroy(int $id): JsonResponse
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
            ], 404);
        }

        $subscription->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subscription deleted successfully',
        ]);
    }

    // 6. GET BY STATUS
    public function getByStatus(string $status): JsonResponse
    {
        $subscription = Subscription::with(['customer', 'service'])
            ->where('status', $status)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $subscription,
        ]);
    }

    // 7. CHANGE STATUS
    public function changeStatus(int $id): JsonResponse
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
            ], 404);
        }

        $statusList = ['active', 'inactive', 'trial', 'isolir', 'dismantle'];

        $currentIndex = array_search($subscription->status, $statusList);

        $nextIndex = ($currentIndex + 1) % count($statusList);

        $subscription->update([
            'status' => $statusList[$nextIndex]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription status updated',
            'data' => $subscription,
        ]);
    }
}