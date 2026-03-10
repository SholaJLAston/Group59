<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // View all orders
    public function index()
    {
        //
    }

    // Show order details
    public function show(Order $order)
    {
        //
    }

    // Update order status (pending -> processing -> shipped -> delivered)
    public function updateStatus(Request $request, Order $order)
    {
        //
    }

    // Process incoming stock orders
    public function processIncoming(Order $order)
    {
        //
    }

    // Handle filtering and search of orders
    public function search(Request $request)
    {
        //
    }
}
