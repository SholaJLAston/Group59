@extends('layouts.auth')

@section('title', 'Confirm Password')

@section('content')
    <section class="auth-page">
        <div class="auth-header">
            <h1>Confirm Password</h1>
            <p>Please confirm your password to continue.</p>
        </div>

        <div class="auth-card">
            <form method="POST" action="{{ route('password.confirm') }}" class="auth-stack">
                @csrf

                <div class="auth-field">
                    <label for="password">Password</label>
                    <div class="auth-input-wrap">
                        <input id="password" class="auth-input" type="password" name="password" required autocomplete="current-password">
                        <button type="button" class="auth-toggle" data-toggle-password="password" aria-label="Toggle password visibility">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="auth-btn">Confirm</button>
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
