@extends('layouts.app')

@section('title', 'Register – Apex Hardware Supply & Tools')

@section('extra-css')
  
  <style>
    body {
      background: #ffffff;
      color: #070707;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    main {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

    .container {
      width: 90%;
      max-width: 1150px;
      display: flex;
      gap: 60px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .left-side {
      flex: 1;
      min-width: 340px;
    }

    .left-side h1 {
      font-size: 3rem;
      color: #D47C17;
      margin-bottom: 15px;
    }

    .left-side p {
      color: #707070;
      font-size: 1.1rem;
      max-width: 420px;
      line-height: 1.7;
    }

    .image-grid {
      margin-top: 40px;
      display: grid;
      grid-template-columns: repeat(2, 180px);
      grid-auto-rows: auto;
      gap: 20px;
    }

    .image-grid img {
      width: 180px;
      height: 240px;
      border-radius: 20px;
      object-fit: cover;
      box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .image-grid img:nth-child(1) { grid-column: 1; }
    .image-grid img:nth-child(2) { grid-column: 2; }
    .image-grid img:nth-child(3) { grid-column: 1 / span 2; justify-self: center; }

    .right-side {
      flex: 1;
      min-width: 380px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-card {
      width: 100%;
      max-width: 420px;
      background: #f3f3f3;
      padding: 40px;
      border-radius: 18px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .form-title {
      font-size: 2rem;
      margin-bottom: 20px;
      color: #D47C17;
      text-align: center;
    }

    .role-select {
      margin-bottom: 20px;
      text-align: center;
    }

    .role-select label {
      margin: 0 20px;
      font-weight: 500;
      color: #444;
    }

    .field {
      position: relative;
      margin-bottom: 15px;
    }

    .field input {
      width: 100%;
      padding: 14px 16px;
      border-radius: 10px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }

    .field span {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #707070;
      font-size: 1.2rem;
    }

    .forgot {
      display: block;
      text-align: right;
      color: #D47C17;
      font-size: 0.95rem;
      margin-bottom: 20px;
      text-decoration: none;
    }

    .forgot:hover { text-decoration: underline; }

    button[type="submit"] {
      width: 100%;
      padding: 14px;
      background: #D47C17;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1.1rem;
      cursor: pointer;
      margin: 20px 0;
    }

    .divider {
      text-align: center;
      margin: 20px 0;
      color: #707070;
    }

    .social-btn {
      width: 100%;
      padding: 13px;
      margin-bottom: 12px;
      border-radius: 10px;
      border: 1px solid #ccc;
      background: white;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s;
    }

    .social-btn:hover { background: #ffe8d0; }

    .link {
      text-align: center;
      margin-top: 18px;
    }

    .link a {
      color: #D47C17;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
    }

    .error-message {
      color: #dc2626;
      font-size: 0.9rem;
      margin-top: 4px;
    }

    @media (max-width: 900px) {
      .container { flex-direction: column; gap: 60px; }
      .image-grid { grid-template-columns: repeat(2, 1fr); max-width: 100%; }
      .image-grid img { width: 100%; height: auto; }
    }

    @media (max-width: 600px) {
      .image-grid { grid-template-columns: 1fr; }
    }
  </style>
@endsection

@section('content')
  <main>
    <div class="container">

      <!-- LEFT SIDE – Images & Text (same as login) -->
      <div class="left-side">
        <h1>Let’s Connect</h1>
        <p>
          Sign in or create an account to access Apex Hardware services, manage orders,
          and explore professional tools built for both customers and administrators.
        </p>

        <div class="image-grid">
          <img src="{{ asset('images/Professional.avif') }}" alt="Professional">
          <img src="{{ asset('images/Store.avif') }}" alt="Store">
          <img src="{{ asset('images/Tools.avif') }}" alt="Tools">
        </div>
      </div>

      <!-- RIGHT SIDE – Register Form -->
      <div class="right-side">
        <div class="form-card">
          <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-title">Sign Up</div>

            <div class="role-select">
              <label><input type="radio" name="role" value="customer" checked> Customer</label>
              <label><input type="radio" name="role" value="admin"> Admin</label>
            </div>

            <div class="field">
              <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
            </div>
            @error('name')
              <div class="error-message">{{ $message }}</div>
            @enderror

            <div class="field">
              <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
            </div>
            @error('email')
              <div class="error-message">{{ $message }}</div>
            @enderror

            <div class="field">
              <input type="password" name="password" placeholder="Password" required>
              <span class="toggle-password">👁</span>
            </div>
            @error('password')
              <div class="error-message">{{ $message }}</div>
            @enderror

            <div class="field">
              <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
              <span class="toggle-password">👁</span>
            </div>
            @error('password_confirmation')
              <div class="error-message">{{ $message }}</div>
            @enderror

            <button type="submit">Create Account</button>

            <div class="divider">OR</div>

            <button type="button" class="social-btn">Continue with Google</button>
            <button type="button" class="social-btn">Continue with Facebook</button>

            <div class="link">
              Already have an account? <a href="{{ route('login') }}">Sign In</a>
            </div>
          </form>
        </div>
      </div>

    </div>
  </main>
@endsection

@section('extra-js')
  <script>
    // Password visibility toggle (same as login)
    document.querySelectorAll('.toggle-password').forEach(function(toggle) {
      toggle.addEventListener('click', function() {
        const input = this.previousElementSibling;
        if (input.type === 'password') {
          input.type = 'text';
          this.textContent = '🙈';
        } else {
          input.type = 'password';
          this.textContent = '👁';
        }
      });
    });
  </script>
@endsection