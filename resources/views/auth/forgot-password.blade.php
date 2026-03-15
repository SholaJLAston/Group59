@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
    <section class="auth-page">
        <div class="auth-header">
            <h1>Reset Password</h1>
            <p>Enter your email and we will send you a reset link.</p>
        </div>

        <div class="auth-card">
            @if (session('status'))
                <div class="auth-status info">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="auth-stack">
                @csrf

                <div class="auth-field">
                    <label for="email">Email Address</label>
                    <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="auth-btn">Email Password Reset Link</button>
            </form>

            <div class="auth-meta">
                Remembered it? <a class="auth-link" href="{{ route('login') }}">Back to login</a>
            </div>
        </div>
    </section>
@endsection
