@extends('layouts.admin')

@section('title', 'Edit Customer')
@section('page-title', 'Edit Customer')

@section('extra-css')
<style>
.admin-wrap{max-width:920px;margin:0 auto}
.card{background:#fff;border:1px solid #e8e8e8;border-radius:22px;padding:22px}
.card-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
.card-title{margin:0;font-size:24px;font-weight:800;color:#111827}
.close-btn{display:inline-flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:999px;border:1px solid #ececec;color:#6b7280;text-decoration:none}
.close-btn:hover{background:#fff4e8;color:#d88411;border-color:#ffe1ba}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.field{display:flex;flex-direction:column;gap:7px}
.field.full{grid-column:1/-1}
.field label{font-size:13px;font-weight:700;color:#374151}
.field input,.field select{width:100%;padding:12px 13px;border:1px solid #dbdbdb;border-radius:12px;background:#fff;font-size:14px;color:#111827}
.field input:focus,.field select:focus{outline:none;border-color:#d88411;box-shadow:0 0 0 3px #f8e8cf}
.actions{display:flex;justify-content:flex-end;gap:10px;margin-top:16px}
.btn{padding:11px 16px;border-radius:12px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;border:1px solid transparent;cursor:pointer}
.btn-cancel{background:#fff;border-color:#e5e7eb;color:#374151}
.btn-cancel:hover{background:#f9fafb}
.btn-save{background:#d88411;color:#fff}
.btn-save:hover{background:#be730f}

@media (max-width: 900px){
    .grid{grid-template-columns:1fr}
}
</style>
@endsection

@section('content')
<div class="admin-wrap">
    <form method="POST" action="{{ route('admin.customers.update', $user) }}" class="card">
        @csrf
        @method('PATCH')

        <div class="card-head">
            <h1 class="card-title">Edit Customer</h1>
            <a href="{{ route('admin.customers.show', $user) }}" class="close-btn" title="Close"><i class="fa-solid fa-xmark"></i></a>
        </div>

        <div class="grid">
            <div class="field">
                <label for="first_name">First Name</label>
                <input id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
            </div>

            <div class="field">
                <label for="last_name">Last Name</label>
                <input id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
            </div>

            <div class="field full">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="field">
                <label for="phone_number">Phone</label>
                <input id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
            </div>

            <div class="field">
                <label for="role">Role</label>
                <select id="role" name="role">
                    <option value="customer" {{ old('role', $user->role)==='customer' ? 'selected' : '' }}>Customer</option>
                    <option value="admin" {{ old('role', $user->role)==='admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('admin.customers.show', $user) }}" class="btn btn-cancel">Cancel</a>
            <button class="btn btn-save" type="submit">Save Customer</button>
        </div>
    </form>
</div>
@endsection

