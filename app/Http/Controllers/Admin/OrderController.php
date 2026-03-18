<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // View all orders
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'orderItems.product'])->latest();

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($inner) use ($search) {
                if (is_numeric($search)) {
                    $inner->orWhere('id', (int) $search);
                }

                $inner->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('email', 'like', '%' . $search . '%')
                        ->orWhere('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%');
                });
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(20)->withQueryString();
        $selectedOrder = null;

        if ($request->filled('selected')) {
            $selectedOrder = Order::with(['user', 'orderItems.product'])
                ->find((int) $request->input('selected'));
        }

        return view('admin.orders.orders-management', compact('orders', 'selectedOrder'));
    }

    // Show order details
    public function show(Order $order): View
    {
        $order->load(['user', 'orderItems.product']);

        return view('admin.orders.order-detail', compact('order'));
    }

    // Update order status (pending -> processing -> shipped -> delivered)
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,processing,shipped,delivered,cancelled'],
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('status', 'Order status updated successfully.');
    }

    // Process incoming stock orders
    public function processIncoming(Order $order)
    {
        if ($order->status === 'pending') {
            $order->update(['status' => 'processing']);
        } elseif ($order->status === 'processing') {
            $order->update(['status' => 'shipped']);
        }

        return back()->with('status', 'Order processed successfully.');
    }

    // Handle filtering and search of orders
    public function search(Request $request)
    {
        return redirect()->route('admin.orders', [
            'q' => $request->input('q'),
            'status' => $request->input('status'),
        ]);
    }
}
