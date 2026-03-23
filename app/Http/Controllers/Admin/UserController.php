<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // View all users
    public function index(Request $request): View
    {
        $query = User::query()->withCount('orders')->latest();

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($inner) use ($search) {
                $inner->where('email', 'like', '%' . $search . '%')
                    ->orWhere('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%');
            });
        }

        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        $users = $query->paginate(20)->withQueryString();

        return view('admin.customers.customers-list', compact('users'));
    }

    // Show user details
    public function show(User $user): View
    {
        $user->loadCount('orders');
        $latestOrders = $user->orders()->latest()->take(5)->get();

        return view('admin.customers.customer-detail', compact('user', 'latestOrders'));
    }

    // Show form to edit user
    public function edit(User $user): View
    {
        return view('admin.customers.customer-form', compact('user'));
    }

    // Update user profile
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone_number' => ['nullable', 'string', 'max:50'],
            'role' => ['required', 'in:admin,customer'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('admin.customers.show', $user)->with('status', 'Customer updated successfully.');
    }

    // View user activity and orders
    public function viewActivity(User $user): View
    {
        $orders = $user->orders()->latest()->take(10)->get();
        $contacts = $user->contactRequest()->latest()->take(10)->get();

        return view('admin.customers.customer-activity', compact('user', 'orders', 'contacts'));
    }

    // View user's order history
    public function viewOrders(User $user): View
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('admin.customers.customer-orders-history', compact('user', 'orders'));
    }

    // Delete user
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.customers.index')->with('status', 'Customer deleted successfully.');
    }

    public function messages(Request $request): View
    {
        $query = ContactRequest::with('user')->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($inner) use ($search) {
                $inner->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('subject', 'like', '%' . $search . '%')
                    ->orWhere('message', 'like', '%' . $search . '%');
            });
        }

        $messages = $query->paginate(20)->withQueryString();

        return view('admin.messages.messages-list', compact('messages'));
    }

    public function updateMessageStatus(Request $request, ContactRequest $message)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,in_progress,resolved'],
        ]);

        $message->update([
            'status' => $validated['status'],
        ]);

        return back()->with('status', 'Message status updated.');
    }
}
