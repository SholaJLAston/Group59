<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ReturnModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReturnController extends Controller
{
    public function index(Request $request): View
    {
        $returns = ReturnModel::with('order')
            ->whereHas('order', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->latest()
            ->get();

        return view('returns.index', [
            'returns' => $returns,
        ]);
    }

    public function store(Request $request, Order $order): RedirectResponse
    {
        $this->assertOrderOwnership($request, $order);

        $validated = $request->validate([
            'reason' => 'required|in:defective,wrong_item,no_longer_needed,other',
            'comments' => 'nullable|string|max:1000',
        ]);

        $hasExisting = ReturnModel::where('order_id', $order->id)->exists();
        if ($hasExisting) {
            return back()->with('error', 'A return request already exists for this order.');
        }

        ReturnModel::create([
            'order_id' => $order->id,
            'reason' => $validated['reason'],
            'comments' => $validated['comments'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('returns.index')->with('success', 'Return request submitted successfully!');
    }

    public function show(Request $request, ReturnModel $return): View
    {
        $return->load('order.user');

        if (!$return->order || $return->order->user_id !== $request->user()->id) {
            abort(403);
        }

        return view('returns.show', [
            'return' => $return,
        ]);
    }

    private function assertOrderOwnership(Request $request, Order $order): void
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }
    }
}
