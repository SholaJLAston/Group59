@extends('layouts.auth')

@section('title', 'Create Account')

@section('content')
  <section class="auth-page">
    <div class="auth-header">
      <h1>Create Account</h1>
      <p>Set up your Apex account in one step.</p>
    </div>

    <div class="auth-card">
      <form method="POST" action="{{ route('register') }}" class="auth-stack">
        @csrf

        <div class="auth-grid-2">
          <div class="auth-field">
            <label for="first_name">First Name</label>
            <input id="first_name" class="auth-input" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus autocomplete="given-name">
            @error('first_name')
              <div class="auth-error">{{ $message }}</div>
            @enderror
          </div>

          <div class="auth-field">
            <label for="last_name">Last Name</label>
            <input id="last_name" class="auth-input" type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name">
            @error('last_name')
              <div class="auth-error">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="auth-field">
          <label for="email">Email Address</label>
          <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
          @error('email')
            <div class="auth-error">{{ $message }}</div>
          @enderror
        </div>

        <div class="auth-grid-2">
          <div class="auth-field">
            <label for="password">Password</label>
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
        </div>

        <button type="submit" class="auth-btn">Create Account</button>
      </form>

      <div class="auth-meta">
        Already registered? <a class="auth-link" href="{{ route('login') }}">Sign in</a>
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