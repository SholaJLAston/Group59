<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Apex Logo" class="logo-img">
        <div>
            APEX
            <span class="tagline">HARDWARE SUPPLY & TOOLS</span>
        </div>
    </div>

    <ul class="main-links">
        <li><a href="{{ route('home') }}" class="{{ Route::currentRouteName() === 'home' ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ route('about') }}">About Us</a></li>
        <li><a href="{{ route('shop') }}">Shop</a></li>
        <li><a href="{{ route('contact') }}">Contact</a></li>
    </ul>

   <div class="right-icons">
  <!-- Cart icon -->
  <div class="cart-wrapper relative">  <!-- added 'relative' class here for safety -->
    <a href="{{ route('cart') }}" title="Basket">
      <i class="fas fa-shopping-cart nav-icon"></i>
      <span class="cart-count">0</span>
    </a>
  </div>
  
        <!-- Account Dropdown -->
<div class="account-dropdown ml-6 relative">
  @auth
    <!-- Logged in user -->
    <button class="account-btn" onclick="this.parentElement.classList.toggle('active')">
      {{ Auth::user()->name }}
      <i class="fas fa-chevron-down text-sm"></i>
    </button>

    <div class="account-dropdown-content">
      <a href="{{ route('profile.edit') }}">Profile</a>
      <a href="{{ route('dashboard') }}">Dashboard</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
      </form>
    </div>
  @else
    <!-- Guest -->
    <button class="account-btn" onclick="this.parentElement.classList.toggle('active')">
      Account
      <i class="fas fa-chevron-down text-sm"></i>
    </button>

    <div class="account-dropdown-content">
      <a href="{{ route('login') }}">Login</a>
      <a href="{{ route('register') }}">Register</a>
    </div>
  @endauth
</div>

       

        <!-- Mobile menu toggle -->
        <i class="fas fa-bars menu-toggle md:hidden" id="menuToggle"></i>
    </div>
</nav>