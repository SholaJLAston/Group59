@extends('layouts.app')

@section('title', 'Customers')

@section('extra-css')
<style>
.admin-wrap{max-width:1200px;margin:0 auto;padding:28px 16px 50px}.table{width:100%;border-collapse:collapse;background:#fff;border:1px solid #e5e7eb}.table th,.table td{padding:10px;border-bottom:1px solid #f1f5f9;font-size:14px;text-align:left}.btn-admin{background:#111827;color:#fff;text-decoration:none;padding:8px 12px;border-radius:8px;font-size:13px}.btn-admin:hover{background:#d47c17;color:#fff}
</style>
@endsection

@section('content')
<div class="admin-wrap">
    <h1 style="margin:0 0 14px;">Customer Management</h1>
    @include('admin._menu')

    @if(session('status'))<div style="margin-bottom:10px;color:#065f46;">{{ session('status') }}</div>@endif

    <form method="GET" action="{{ route('admin.customers.index') }}" style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:12px;">
        <input name="q" value="{{ request('q') }}" placeholder="Name / email" style="padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
        <select name="role" style="padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
            <option value="">All roles</option>
            <option value="customer" {{ request('role')==='customer' ? 'selected' : '' }}>Customer</option>
            <option value="admin" {{ request('role')==='admin' ? 'selected' : '' }}>Admin</option>
        </select>
        <button class="btn-admin" type="submit">Filter</button>
    </form>

    <table class="table">
        <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Orders</th><th>Action</th></tr></thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>{{ $user->orders_count }}</td>
                <td>
                    <a class="btn-admin" href="{{ route('admin.customers.show', $user) }}">View</a>
                    <a class="btn-admin" href="{{ route('admin.customers.edit', $user) }}">Edit</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No users found.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px;">{{ $users->links() }}</div>
</div>
@endsection