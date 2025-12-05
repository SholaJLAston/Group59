<header>
    <div class="defaultLogo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/main_logo.png') }}" width="299" height="251" style="opacity: 0.85;" alt="Logo">
        </a>
    </div>
        
    <div class="flexLinks">
        <a href="{{ route('about') }}" class="indexLink">
            <p>About Us</p>
        </a>
        <a href="{{ route('contact.create') }}" class="indexLink">
            <p>Contact Us</p>
        </a>
        <a href="{{ route('products.index') }}" class="indexLink">
            <p>Shop Now</p>
        </a>
        
        @guest
            <a href="{{ route('register') }}" class="indexLink">
                <p>Sign Up</p>
            </a>
            <a href="{{ route('login') }}" class="indexLink">
                <p>Account Log In</p>
            </a>
        @else
            <a href="{{ route('basket.index') }}" class="indexLink">
                <p>Basket</p>
            </a>
            <a href="{{ route('logout') }}" class="indexLink" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <p>Logout</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endguest
    </div>
</header>