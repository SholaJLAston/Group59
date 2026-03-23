@extends('layouts.auth')

@section('title', 'Login')

@section('content')
  <section class="auth-page">
    <div class="auth-header">
      <h1>Welcome Back</h1>
      <p>Sign in to continue shopping.</p>
    </div>

    <div class="auth-card">
      @if (session('status'))
        <div class="auth-status success">{{ session('status') }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}" class="auth-stack">
        @csrf

        <div class="auth-field">
          <label for="email">Email Address</label>
          <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
          @error('email')
            <div class="auth-error">{{ $message }}</div>
          @enderror
        </div>

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

        <div class="auth-help">
          <label>
            <input type="checkbox" name="remember"> Remember me
          </label>
          <a class="auth-link" href="{{ route('password.request') }}">Forgot password?</a>
        </div>

        <button type="submit" class="auth-btn">Sign In</button>
      </form>

      <div class="auth-meta">
        No account yet? <a class="auth-link" href="{{ route('register') }}">Create one</a>
      </div>
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