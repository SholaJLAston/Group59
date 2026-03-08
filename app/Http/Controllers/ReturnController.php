<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ReturnModel;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index(Request $request)
    {
        //
        $returns = ReturnModel::with('order')->whereHas('order', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->get();
        return view('returns.index', [
            'returns' => $returns,
        ]);
    }

    public function store(Request $request, Order $order)
    {
        //
        $validated = $request->validate([
            'reason' => 'required|string',
            'comments' => 'nullable|string',
        ]);

        $return = ReturnModel::create([
            'order_id' => $order->id,
            'reason' => $validated['reason'],
            'comments' => $validated['comments'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with("success", "Return request submitted successfully!");
    }

    public function show(ReturnModel $return)
    {
        //
        return view('returns.show', [
            'return' => $return->load('order'),
        ]);
    }
}
