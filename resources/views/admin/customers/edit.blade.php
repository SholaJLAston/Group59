@extends('layouts.admin')

@section('title', 'Edit Customer')
@section('page-title', 'Edit Customer')

@section('extra-css')
<style>
.admin-wrap{max-width:760px;margin:0 auto;padding:28px 16px 50px}.card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:16px}.field{margin-bottom:10px}.field label{display:block;font-size:13px;color:#374151;margin-bottom:4px}.field input,.field select{width:100%;padding:9px 10px;border:1px solid #ddd;border-radius:8px}.btn-admin{background:#111827;color:#fff;text-decoration:none;padding:9px 14px;border-radius:8px;font-size:13px;border:none;cursor:pointer}.btn-admin:hover{background:#d47c17;color:#fff}
</style>
@endsection

@section('content')
<div class="admin-wrap">
    <h1 style="margin:0 0 14px;">Edit Customer</h1>

    <form method="POST" action="{{ route('admin.customers.update', $user) }}" class="card">
        @csrf @method('PATCH')
        <div class="field"><label>First Name</label><input name="first_name" value="{{ old('first_name', $user->first_name) }}"></div>
        <div class="field"><label>Last Name</label><input name="last_name" value="{{ old('last_name', $user->last_name) }}"></div>
        <div class="field"><label>Email</label><input name="email" type="email" value="{{ old('email', $user->email) }}"></div>
        <div class="field"><label>Phone</label><input name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"></div>
        <div class="field"><label>Role</label>
            <select name="role">
                <option value="customer" {{ old('role', $user->role)==='customer' ? 'selected' : '' }}>Customer</option>
                <option value="admin" {{ old('role', $user->role)==='admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <button class="btn-admin" type="submit">Save</button>
    </form>
</div>
@endsection

