@extends('layouts.auth')

@section('title', 'Set New Password')

@section('content')
    <section class="auth-page">
        <div class="auth-header">
            <h1>Set New Password</h1>
            <p>Choose a strong password for your account.</p>
        </div>

        <div class="auth-card">
            <form method="POST" action="{{ route('password.store') }}" class="auth-stack">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="auth-field">
                    <label for="email">Email Address</label>
                    <input id="email" class="auth-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password">New Password</label>
                    <div class="auth-input-wrap">
                        <input id="password" class="auth-input" type="password" name="password" required autocomplete="new-password">
                        <button type="button" class="auth-toggle" data-toggle-password="password" aria-label="Toggle password visibility">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" class="auth-input" type="password" name="password_confirmation" required autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="auth-btn">Reset Password</button>
            </form>
        </div>
    </section>
@endsection

@section('extra-js')
    <script>
        document.querySelectorAll('[data-toggle-password]').forEach((button) => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-toggle-password');
                const input = document.getElementById(targetId);

                if (!input) {
                    return;
                }

                input.type = input.type === 'password' ? 'text' : 'password';
            });
        });
    </script>
@endsection
