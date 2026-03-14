<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Apex Logo" class="logo-img">
        <div class="logo-text">
            <div class="logo-brand">APEX</div>
            <div class="logo-tagline">HARDWARE SUPPLY & TOOLS</div>
        </div>
    </div>

    <ul class="main-links">
        <li><a href="{{ route('home') }}" class="{{ Route::currentRouteName() === 'home' ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ route('about') }}">About Us</a></li>
        <li><a href="{{ route('products') }}">Shop</a></li>
        <li><a href="{{ route('contact') }}">Contact</a></li>
    </ul>

   <div class="right-icons">
  <!-- Cart icon -->
  <div class="cart-wrapper relative">
    <a href="{{ route('basket') }}" title="Basket">
      <i class="fas fa-shopping-cart nav-icon"></i>
      @if(($basketCount ?? 0) > 0)
        <span class="cart-count">{{ $basketCount > 99 ? '99+' : $basketCount }}</span>
      @endif
    </a>
  </div>
  
        <!-- Account Dropdown -->
<div class="account-dropdown ml-6 relative">
  @auth
    <!-- Logged in user -->
    <button class="account-btn flex items-center gap-3" onclick="event.stopPropagation(); this.parentElement.classList.toggle('active')">
      <div class="profile-avatar">{{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}</div>
      <span class="account-name">{{ Auth::user()->first_name ?? Auth::user()->name }}</span>
      <i class="fas fa-chevron-down text-sm"></i>
    </button>

    <div class="account-dropdown-content">
      <div class="account-header">
        <div class="account-header-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
        <div class="account-header-email">{{ Auth::user()->email }}</div>
      </div>
      <hr style="margin: 0; border: none; border-top: 1px solid #eee;">
      @if (Auth::user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-gauge"></i> Dashboard</a>
        <a href="{{ route('admin.orders') }}"><i class="fas fa-shopping-bag"></i> My Orders</a>
        <a href="{{ route('admin.settings') }}"><i class="fas fa-cog"></i> Settings</a>
      @else
        <a href="{{ route('order.index') }}"><i class="fas fa-shopping-bag"></i> My Orders</a>
        <a href="#" onclick="return false;"><i class="fas fa-cog"></i> Settings</a>
      @endif
      <hr style="margin: 0; border: none; border-top: 1px solid #eee;">
      <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
        @csrf
        <button type="submit" style="color: #dc2626;"><i class="fas fa-sign-out-alt"></i> Logout</button>
      </form>
    </div>
  @else
    <!-- Guest -->
    <button class="account-btn" onclick="event.stopPropagation(); this.parentElement.classList.toggle('active')">
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