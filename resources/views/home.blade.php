@extends('layouts.app')

@section('title', 'Apex Hardware Supply & Tools')

@section('extra-css')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-slideshow">
      <div class="slide active" style="background-image: url('{{ asset('images/Professional.avif') }}');"></div>
      <div class="slide" style="background-image: url('{{ asset('images/Store.avif') }}');"></div>
      <div class="slide" style="background-image: url('{{ asset('images/Tools.avif') }}');"></div>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1>Everything You Need to Turn Ideas into Reality</h1>
      <p class="hero-subtitle">Professional-grade tools, materials, power equipment & hardware — delivered fast for DIYers, tradespeople & small businesses.</p>
      <a href="{{ route('products') }}" class="btn-shop-now">
        <i class="fas fa-shopping-bag"></i> SHOP NOW
      </a>
    </div>
  </section>

  <!-- Categories -->
  <section id="categories" class="categories-section">
    <div class="container">
      <h2 class="section-title">Browse Our Categories</h2>
      <div class="categories-grid">
        <a href="{{ route('products') }}?category=general-tools" class="category-card">
          <img src="{{ asset('images/General Tools.avif') }}" alt="General Tools">
          <h3>General Tools</h3>
          <p>Screwdrivers, hammers, pliers & more</p>
        </a>
        <a href="{{ route('products') }}?category=electronic-hardware" class="category-card">
          <img src="{{ asset('images/Electronic Hardware.avif') }}" alt="Electronic Hardware">
          <h3>Electronic Hardware</h3>
          <p>Resistors, circuits, LEDs & components</p>
        </a>
        <a href="{{ route('products') }}?category=electronic-tools" class="category-card">
          <img src="{{ asset('images/Electronic tools.avif') }}" alt="Electronic Tools">
          <h3>Electronic Tools</h3>
          <p>Drills, wire strippers, soldering irons</p>
        </a>

        <a href="{{ route('products') }}?category=gardening-tools" class="category-card">
          <img src="{{ asset('images/Gardening Tools.avif') }}" alt="Gardening Tools">
          <h3>Gardening Tools</h3>
          <p>Shovels, rakes, shears & lawnmowers</p>
        </a>
        <a href="{{ route('products') }}?category=materials" class="category-card">
          <img src="{{ asset('images/Materials.avif') }}" alt="Materials">
          <h3>Materials</h3>
          <p>Wood, concrete, soil, metal & more</p>
        </a>
      </div>
    </div>
  </section>

  <!-- About Us Section -->
  <section class="about-section">
    <div class="container">
      <div class="about-grid">
        <div class="about-image">
          <img src="{{ asset('images/Tools in action.avif') }}" alt="Apex Hardware Team">
        </div>

        <div class="about-text">
          <div class="about-label">
            <div class="label-line"></div>
            <span>About Us</span>
          </div>

          <h3>Tools, Materials & Hardware Delivered Fast.</h3>

          <p>At Apex Hardware Supply & Tools we provide dependable, professional-grade products for every project. From general hand tools and power equipment to gardening supplies, building materials and electronic components — we serve DIY enthusiasts, tradespeople and small businesses with quality you can trust, fair prices and fast delivery.</p>

          <p>Our goal is simple: make sure you have everything you need to turn ideas into reality — without delays or hassle.</p>

          <a href="{{ route('about') }}" class="btn-secondary">More about <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </section>

  <!-- Why Choose Apex -->
  <section class="features-section">
    <div class="container">
      <div class="features-label">
        <div class="label-line"></div>
        <span>Key Features</span>
      </div>

      <h2 class="section-title">Why Choose Apex?</h2>

      <p class="features-intro">
        At Apex Hardware Supply & Tools, we pride ourselves on being the premier choice for all your hardware needs. Here are just a few reasons why you should choose us.
      </p>

      <div class="feature-cards">
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fas fa-tools"></i>
          </div>
          <h4>Professional Quality</h4>
          <p>Tools trusted by real tradespeople every day, carefully selected for reliability and performance.</p>
        </div>

        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fas fa-truck-fast"></i>
          </div>
          <h4>Fast Delivery</h4>
          <p>Next-day dispatch on most orders — get your tools and materials when you need them.</p>
        </div>

        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fas fa-headset"></i>
          </div>
          <h4>Expert Support</h4>
          <p>Real human support from people who understand tools and your project needs.</p>
        </div>

        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fas fa-shield-alt"></i>
          </div>
          <h4>Price Promise</h4>
          <p>Find it cheaper elsewhere? We’ll match it — transparent and competitive pricing.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA + FAQ Section -->
  <section class="cta-faq-section">
    <div class="container">
      <div class="cta-faq-grid">
        <div class="cta-box" style="background-image: url('{{ asset('images/light.avif') }}');">
          <div class="cta-overlay"></div>
          <div class="cta-content">
            <h2 class="cta-heading">Need Help Choosing the Right Tools?</h2>
            <p class="cta-text">Our team is ready to guide you — whether you're a beginner or a pro. Get in touch or start shopping now.</p>

            <div class="cta-buttons">
              <a href="{{ route('contact') }}" class="btn-outline">Contact Us</a>
              <a href="{{ route('products') }}" class="btn-primary">
                <i class="fas fa-shopping-bag"></i> Shop Now
              </a>
            </div>
          </div>
        </div>

        <div class="faq-content">
          <div class="faq-label">
            <div class="label-line"></div>
            <span>FAQ</span>
          </div>

          <h2 class="faq-heading">Have Questions?<br>We’re Here to Help!</h2>

          <div class="accordion">
            <div class="accordion-item">
              <button class="accordion-header">What products does Apex sell?</button>
              <div class="accordion-content">
                <p>Apex supplies a wide range of tools, materials, gardening equipment, and electronic hardware for both DIY users and professionals.</p>
              </div>
            </div>

            <div class="accordion-item">
              <button class="accordion-header">Do I need an account to place an order?</button>
              <div class="accordion-content">
                <p>Yes, customers must create an account to place orders, track purchases, and manage their basket securely.</p>
              </div>
            </div>

            <div class="accordion-item">
              <button class="accordion-header">Can I return products after purchase?</button>
              <div class="accordion-content">
                <p>Yes, customers can request returns for previously purchased products through their account dashboard.</p>
              </div>
            </div>

            <div class="accordion-item">
              <button class="accordion-header">How can I contact Apex Hardware?</button>
              <div class="accordion-content">
                <p>You can contact us using the Contact Us form, email, or phone details provided on the website.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

@section('extra-js')
  <script>
    // Slideshow
    const slides = document.querySelectorAll('.slide');
    let current = 0;
    setInterval(() => {
      slides[current].classList.remove('active');
      current = (current + 1) % slides.length;
      slides[current].classList.add('active');
    }, 12000);

    // FAQ accordion
    document.querySelectorAll('.accordion-header').forEach(btn => {
      btn.addEventListener('click', () => {
        const content = btn.nextElementSibling;
        const isOpen = content.style.maxHeight;
        document.querySelectorAll('.accordion-content').forEach(c => c.style.maxHeight = null);
        if (!isOpen) content.style.maxHeight = content.scrollHeight + "px";
      });
    });
  </script>
@endsection