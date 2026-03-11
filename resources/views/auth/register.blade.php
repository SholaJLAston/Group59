@extends('layouts.app')

@section('title', 'Create Account – Apex Hardware Supply & Tools')

@section('extra-css')
  <style>
    body {
      background: #ffffff;
      color: #070707;
      min-height: 100vh;
      margin: 0;
      display: flex;
      flex-direction: column;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    }

    main {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

    .register-wrapper {
      width: 100%;
      max-width: 460px;
      text-align: center;
    }

    .header-text {
      margin-bottom: 36px;
    }

    .header-text h1 {
      font-size: 2.5rem;
      font-weight: 700;
      color: #D47C17;
      margin: 0 0 10px 0;
    }

    .header-text p {
      font-size: 1.08rem;
      color: #555;
      margin: 0;
    }

    .form-card {
      background: #f8f9fa;
      padding: 44px 36px;
      border-radius: 20px;
      border: 1px solid #e5e7eb;
    }

    .field {
      margin-bottom: 22px;
    }

    .field.full {
      width: 100%;
    }

    .field-group {
      display: flex;
      gap: 18px;
      margin-bottom: 22px;
    }

    .field-group .field {
      flex: 1;
      margin-bottom: 0;
    }

    .field input {
      width: 100%;
      padding: 15px 18px;
      border-radius: 12px;
      border: 1px solid #d1d5db;
      font-size: 1.02rem;
      background: white;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    .field input:focus {
      outline: none;
      border-color: #D47C17;
      box-shadow: 0 0 0 3px rgba(212, 124, 23, 0.09);
    }

    .field .toggle-password {
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      width: 22px;
      height: 22px;
      color: #6b7280;
    }

    .relative {
      position: relative;
    }

    .submit-btn {
      width: 100%;
      padding: 15px;
      background: #D47C17;
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 1.08rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s;
      margin-top: 8px;
    }

    .submit-btn:hover {
      background: #b96d12;
    }

    .divider {
      margin: 32px 0;
      color: #6b7280;
      font-size: 0.97rem;
      position: relative;
    }

    .divider::before,
    .divider::after {
      content: "";
      position: absolute;
      top: 50%;
      width: 42%;
      height: 1px;
      background: #d1d5db;
    }

    .divider::before { left: 0; }
    .divider::after  { right: 0; }

    .social-btn {
      width: 100%;
      padding: 14px;
      margin-bottom: 18px;
      border-radius: 12px;
      border: 1px solid #d1d5db;
      background: white;
      font-size: 1.02rem;
      font-weight: 500;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      transition: all 0.2s;
    }

    .social-btn:hover {
      background: #fff8f0;
      border-color: #D47C17;
    }

    .social-btn.google svg {
      width: 22px;
      height: 22px;
    }

    .bottom-link {
      margin-top: 28px;
      font-size: 1rem;
      color: #555;
    }

    .bottom-link a {
      color: #D47C17;
      font-weight: 600;
      text-decoration: none;
    }

    .bottom-link a:hover {
      text-decoration: underline;
    }

    .error-message {
      color: #dc2626;
      font-size: 0.92rem;
      margin-top: 6px;
      text-align: left;
      padding-left: 6px;
    }

    @media (max-width: 520px) {
      .register-wrapper { max-width: 100%; }
      .form-card { padding: 36px 28px; }
      .field-group { flex-direction: column; gap: 22px; }
      .header-text h1 { font-size: 2.2rem; }
    }
  </style>
@endsection

@section('content')
  <main>
    <div class="register-wrapper">

      <div class="header-text">
        <h1>Create Account</h1>
        <p>Join Apex Hardware Supply today</p>
      </div>

      <div class="form-card">
        <form method="POST" action="{{ route('register') }}">
          @csrf

          <!-- First Name + Last Name side by side -->
          <div class="field-group">
            <div class="field">
              <input type="text" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" required autofocus>
              @error('first_name')
                <div class="error-message">{{ $message }}</div>
              @enderror
            </div>

            <div class="field">
              <input type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" required>
              @error('last_name')
                <div class="error-message">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Email full width -->
          <div class="field full">
            <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
            @error('email')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Password + Confirm Password side by side -->
          <div class="field-group">
            <div class="field relative">
              <input type="password" name="password" id="password" placeholder="Password" required>
              <svg class="toggle-password" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" onclick="togglePassword()">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
              </svg>
              @error('password')
                <div class="error-message">{{ $message }}</div>
              @enderror
            </div>

            <div class="field">
              <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
              <!-- No toggle for confirm password -->
              @error('password_confirmation')
                <div class="error-message">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <button type="submit" class="submit-btn">Create Account</button>

          <div class="divider">Or</div>

          <button type="button" class="social-btn google">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
              <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
              <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
              <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
              <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
            </svg>
            Sign up with Google
          </button>

          <div class="bottom-link">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
          </div>

        </form>
      </div>

    </div>
  </main>
@endsection

@section('extra-js')
  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.querySelector('.toggle-password');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.innerHTML = `
          <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"></path>
          <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"></path>
          <line x1="1" y1="1" x2="23" y2="23"></line>
          <circle cx="12" cy="12" r="3"></circle>
        `;
      } else {
        passwordInput.type = 'password';
        toggleIcon.innerHTML = `
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
          <circle cx="12" cy="12" r="3"></circle>
        `;
      }
    }
  </script>
@endsection