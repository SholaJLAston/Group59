<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // View all users
    public function index()
    {
        //
    }

    // Show user details
    public function show(User $user)
    {
        //
    }

    // Show form to edit user
    public function edit(User $user)
    {
        //
    }

    // Update user profile
    public function update(Request $request, User $user)
    {
        //
    }

    // View user activity and orders
    public function viewActivity(User $user)
    {
        //
    }

    // View user's order history
    public function viewOrders(User $user)
    {
        //
    }

    // Delete user
    public function destroy(User $user)
    {
        //
    }
}
