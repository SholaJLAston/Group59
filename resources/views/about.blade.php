@extends('layouts.app')

@section('title', 'About Us – Apex Hardware Supply & Tools')

@section('extra-css')
  <style>

    /* ── Global ───────────────────────────────── */
    .container {
      max-width: 1300px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .section-heading {
      font-size: 2.6rem;
      font-weight: 700;
      color: #000;
      margin-bottom: 1.6rem;
      line-height: 1.2;
    }

    /* ── Hero ─────────────────────────────────── */
    .hero {
      background: linear-gradient(rgba(7,7,7,0.65), rgba(7,7,7,0.65)),
                  url('{{ asset('images/hardware.avif') }}') center/cover;
      color: white;
      text-align: center;
      padding: 140px 20px 100px;
    }

    .hero h1 {
      font-size: 3.8rem;
      font-weight: 700;
      color: var(--orange);
      margin-bottom: 16px;
    }

    /* ── Our Story ────────────────────────────── */
    .our-story {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 70px;
      align-items: center;
      padding: 90px 0 70px;
    }

    .our-story-image {
      height: 100%;
    }

    .our-story-image img {
      width: 100%;
      height: 100%;
      min-height: 480px;
      object-fit: cover;
      border-radius: 10px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }

    .our-story-text p {
      font-size: 1.1rem;
      line-height: 1.8;
      color: #444;
      margin-bottom: 1.4rem;
    }

    .features-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
      margin-top: 1.8rem;
    }

    .feature-item {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      font-size: 1rem;
      color: #333;
    }

    .feature-item i {
      color: var(--orange);
      font-size: 1.3rem;
      margin-top: 3px;
    }

    /* ── Vision Quote ─────────────────────────── */
    .vision-quote-wrap {
      padding: 55px 0;
    }

    .vision-quote {
      text-align: center;
      font-size: 2.4rem;
      font-weight: 600;
      font-style: italic;
      color: var(--orange);
      max-width: 1000px;
      margin: 0 auto;
    }

    /* ── Vision & Scope ───────────────────────── */
    .vision-scope {
      padding: 60px 0 55px;
      text-align: center;
    }

    .vision-scope .section-label {
      justify-content: center;
      display: inline-flex;
    }

    .vision-scope .section-heading {
      max-width: 620px;
      margin-left: auto;
      margin-right: auto;
      margin-bottom: 44px;
    }

    .vision-boxes {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 28px;
      text-align: left;
    }

    .vision-box {
      background: #fff;
      border: 1px solid #ebebeb;
      border-radius: 20px;
      padding: 40px 36px;
      box-shadow: 0 6px 28px rgba(0,0,0,0.05);
      position: relative;
      overflow: hidden;
    }

    .vision-box::before {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 5px; height: 100%;
      background: var(--orange);
      border-radius: 20px 0 0 20px;
    }

    .vision-box-icon {
      width: 52px; height: 52px;
      background: rgba(212,124,23,0.1);
      border-radius: 13px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 18px;
    }

    .vision-box-icon i { font-size: 1.5rem; color: var(--orange); }

    .vision-box h3 {
      font-size: 1.4rem;
      font-weight: 700;
      color: #000;
      margin-bottom: 12px;
    }

    .vision-box p {
      font-size: 1.05rem;
      line-height: 1.8;
      color: #555;
      margin: 0;
    }

    .vision-box p strong { color: #000; }

    /* ── We Serve ─────────────────────────────── */
    .we-serve {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 70px;
      align-items: center;
      padding: 60px 0 70px;
    }

    .serve-list ul {
      list-style: none;
      padding: 0;
      font-size: 1.1rem;
    }

    .serve-list li {
      padding: 10px 5px;
      border-bottom: 1px solid #eee;
      display: flex;
      align-items: center;
      gap: 13px;
    }

    .serve-list i { color: var(--orange); font-size: 1.4rem; }

    .serve-image {
      height: 100%;
    }

    .serve-image img {
      width: 100%;
      height: 100%;
      min-height: 420px;
      object-fit: cover;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }

    /* ══════════════════════════════════════════════
       WHY CHOOSE US  –  full-width #f5f5f3 bg
       LEFT  = staggered 2×2 card grid
       RIGHT = heading + text + Shop Now button
       ══════════════════════════════════════════════ */
    .why-choose {
      background: #f5f5f3;
      padding: 90px 0;
    }

    .why-choose-inner {
      max-width: 1300px;
      margin: 0 auto;
      padding: 0 40px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 70px;
      align-items: center;
    }

    /* 2×2 grid with right column shifted down */
    .why-cards-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
      align-items: start;
    }

    /* shift every card in the RIGHT column (2nd & 4th child) downward */
    .why-cards-grid .why-card-new:nth-child(2),
    .why-cards-grid .why-card-new:nth-child(4) {
      margin-top: 18px;
    }

    .why-card-new {
      border-radius: 18px;
      padding: 30px 26px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .why-card-new:hover { transform: translateY(-6px); }

    /* dark variant – orange */
    .why-card-new.dark { background: var(--orange); }
    .why-card-new.dark h3 { color: #fff; }
    .why-card-new.dark p  { color: rgba(255,255,255,0.85); }
    .why-card-new.dark:hover { box-shadow: 0 18px 40px rgba(212,124,23,0.45); }
    .why-card-new.dark .why-card-icon { background: rgba(255,255,255,0.2); }

    /* light variant */
    .why-card-new.light { background: #fff; border: 1px solid #e5e5e5; }
    .why-card-new.light h3 { color: #111; }
    .why-card-new.light p  { color: #666; }
    .why-card-new.light:hover { box-shadow: 0 14px 36px rgba(0,0,0,0.09); }

    .why-card-icon {
      width: 44px; height: 44px;
      border-radius: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 18px;
    }

    .why-card-new.light .why-card-icon { background: rgba(212,124,23,0.1); }
    .why-card-icon i { font-size: 1.25rem; color: var(--orange); }

    .why-card-new h3 {
      font-size: 1.15rem;
      font-weight: 700;
      margin-bottom: 8px;
    }

    .why-card-new p { font-size: 0.97rem; line-height: 1.65; margin: 0; }

    /* right text column */
    .why-right .section-heading {
      font-size: 2.9rem;
      line-height: 1.15;
      margin-bottom: 1.2rem;
    }

    .why-right .section-heading span { color: var(--orange); }

    .why-subtext {
      font-size: 1.08rem;
      line-height: 1.8;
      color: #555;
      margin-bottom: 2rem;
      max-width: 460px;
    }

    /* Shop Now button */
    .btn-shop-now {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: var(--orange);
      color: #fff;
      font-size: 1rem;
      font-weight: 700;
      padding: 14px 26px;
      border-radius: 50px;
      text-decoration: none;
      transition: background 0.25s, transform 0.25s, box-shadow 0.25s;
    }

    .btn-shop-now:hover {
      background: #c96b0a;
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(212,124,23,0.4);
      color: #fff;
      text-decoration: none;
    }

    .btn-arrow {
      width: 32px; height: 32px;
      background: rgba(255,255,255,0.22);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.85rem;
      transition: background 0.25s;
    }

    .btn-shop-now:hover .btn-arrow { background: rgba(255,255,255,0.36); }

    /* ══════════════════════════════════════════════
       MEET OUR TEAM  –  same full-width #f5f5f3 bg
       Thin divider separates it from Why Choose Us
       ══════════════════════════════════════════════ */
    .meet-team {
      background: #f5f5f3;
      padding: 0 0 100px;
    }

    .meet-team-inner {
      max-width: 1300px;
      margin: 0 auto;
      padding: 0 40px;
    }

    .meet-team-divider {
      max-width: 1300px;
      margin: 0 auto;
      padding: 0 40px;
    }

    .meet-team-divider hr {
      border: none;
      border-top: 1px solid rgba(0,0,0,0.08);
      margin: 0 0 80px;
    }

    .meet-team-inner .section-label {
      justify-content: center;
      display: inline-flex;
      width: 100%;
    }

    .meet-team-inner .section-heading {
      text-align: center;
    }

    .team-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 22px;
      margin-top: 50px;
    }

    .team-member {
      flex: 0 0 calc(20% - 18px); /* 5 per row */
      text-align: center;
      padding: 30px 16px 26px;
      border-radius: 16px;
      background: #fff;
      border: 1px solid rgba(0,0,0,0.07);
      transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
    }

    .team-member:hover {
      border-color: var(--orange);
      transform: translateY(-8px);
      box-shadow: 0 14px 32px rgba(212,124,23,0.12);
    }

    .team-avatar {
      width: 60px; height: 60px;
      border-radius: 50%;
      background: rgba(212,124,23,0.12);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 14px;
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--orange);
    }

    .team-member h4 {
      font-size: 1.05rem;
      font-weight: 700;
      color: #111;
      margin: 0;
    }

    /* ── Scroll-reveal animation states ──────── */
    .js-reveal {
      opacity: 0;
      transform: translateY(44px);
      transition: opacity 0.85s ease-out, transform 0.85s ease-out;
    }

    .js-reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }

    /* instant (no-transition) reset so re-entry re-animates */
    .js-reveal.reset {
      transition: none;
      opacity: 0;
      transform: translateY(44px);
    }

    /* ── Responsive ───────────────────────────── */
    @media (max-width: 1024px) {
      .why-choose-inner { gap: 48px; padding: 0 28px; }
      .why-right .section-heading { font-size: 2.4rem; }
      .meet-team-inner, .meet-team-divider { padding: 0 28px; }
      .team-member { flex: 0 0 calc(25% - 17px); } /* 4 per row */
    }

    @media (max-width: 900px) {
      .our-story, .we-serve { grid-template-columns: 1fr; gap: 48px; }
      .vision-boxes { grid-template-columns: 1fr; }
      .why-choose-inner { grid-template-columns: 1fr; }
      .why-right { order: -1; }
      .why-cards-grid .why-card-new:nth-child(2),
      .why-cards-grid .why-card-new:nth-child(4) { margin-top: 0; }
    }

    @media (max-width: 640px) {
      .hero h1 { font-size: 2.8rem; }
      .section-heading { font-size: 2rem; }
      .vision-quote { font-size: 1.8rem; }
      .why-cards-grid { grid-template-columns: 1fr; }
      .features-grid { grid-template-columns: 1fr; }
      .why-choose-inner, .meet-team-inner, .meet-team-divider { padding: 0 20px; }
      .team-member { flex: 0 0 calc(50% - 11px); } /* 2 per row on mobile */
    }

  </style>
@endsection

@section('content')

  <!-- Hero -->
  <header class="hero">
    <h1>About Apex</h1>
  </header>

  <div class="container">

    <!-- Our Story -->
    <section class="our-story">
      <div class="our-story-image">
        <img src="{{ asset('images/Professional.avif') }}" alt="Our Team at Work">
      </div>
      <div class="our-story-text">
        <span class="section-label">OUR STORY</span>
        <h2 class="section-heading">Welcome to Apex Hardware Supply & Tools</h2>
        <p>At Apex Hardware Supply & Tools, we're passionate about empowering builders, creators, and problem-solvers with the right tools — delivered fast, priced fairly, and backed by real knowledge.</p>
        <p>Founded with the belief that quality shouldn't come with delays or inflated prices, we've built a one-stop online destination for professional-grade tools, hardware, gardening supplies, and building materials.</p>
        <div class="features-grid">
          <div class="feature-item"><i class="fas fa-check-circle"></i><span>Professional-grade tools & materials</span></div>
          <div class="feature-item"><i class="fas fa-check-circle"></i><span>Next-day delivery across the UK</span></div>
          <div class="feature-item"><i class="fas fa-check-circle"></i><span>Best prices with no hidden fees</span></div>
          <div class="feature-item"><i class="fas fa-check-circle"></i><span>Real support from people who use the tools</span></div>
        </div>
      </div>
    </section>

    <!-- Vision Quote -->
    <div class="vision-quote-wrap">
      <div class="vision-quote js-reveal">
        "Everything you need to turn ideas into reality."
      </div>
    </div>

    <!-- Vision & Scope -->
    <section class="vision-scope">
      <span class="section-label">VISION &amp; SCOPE</span>
      <h2 class="section-heading">Our Vision & What We Cover</h2>

      <div class="vision-boxes">
        <div class="vision-box js-reveal">
          <div class="vision-box-icon"><i class="fas fa-bullseye"></i></div>
          <h3>Our Vision</h3>
          <p>To become the UK's most trusted and convenient online supplier for tradespeople, DIYers, and small businesses — delivering <strong>quality tools and materials</strong> without delay or compromise.</p>
        </div>
        <div class="vision-box js-reveal" style="transition-delay:0.16s">
          <div class="vision-box-icon"><i class="fas fa-layer-group"></i></div>
          <h3>What We Cover</h3>
          <p>We supply everything from hand tools, power tools, and accessories to gardening equipment, building materials, hardware, fasteners, and electronic components — serving both <strong>professionals and passionate home creators</strong>.</p>
        </div>
      </div>
    </section>

    <!-- We Serve -->
    <section class="we-serve">
      <div class="serve-list">
        <span class="section-label">WE SERVE</span>
        <h2 class="section-heading">Who We Serve</h2>
        <ul>
          <li><i class="fas fa-hard-hat"></i> Professional Tradespeople & Contractors</li>
          <li><i class="fas fa-tools"></i> Home DIY Enthusiasts & Weekend Warriors</li>
          <li><i class="fas fa-building"></i> Small Construction & Renovation Businesses</li>
          <li><i class="fas fa-seedling"></i> Gardeners & Landscaping Professionals</li>
          <li><i class="fas fa-plug"></i> Electronics & Maker Hobbyists</li>
          <li><i class="fas fa-school"></i> Schools, Colleges & Training Workshops</li>
        </ul>
      </div>
      <div class="serve-image">
        <img src="{{ asset('images/Story.avif') }}" alt="Our Customers">
      </div>
    </section>

  </div><!-- /.container -->


  <!-- WHY CHOOSE US – full-width -->
  <section class="why-choose">
    <div class="why-choose-inner">

      <!-- LEFT: staggered 2×2 card grid -->
      <div class="why-cards-grid">
        <div class="why-card-new dark">
          <div class="why-card-icon"><i class="fas fa-truck-fast"></i></div>
          <h3>Lightning-Fast Delivery</h3>
          <p>Next-day on most items — no long waits, no project delays.</p>
        </div>
        <div class="why-card-new light">
          <div class="why-card-icon"><i class="fas fa-tools"></i></div>
          <h3>Pro-Grade Quality</h3>
          <p>Tools trusted by real tradespeople every single day.</p>
        </div>
        <div class="why-card-new light">
          <div class="why-card-icon"><i class="fas fa-pound-sign"></i></div>
          <h3>Best Prices Guaranteed</h3>
          <p>Find it cheaper elsewhere? We'll match it — no questions asked.</p>
        </div>
        <div class="why-card-new dark">
          <div class="why-card-icon"><i class="fas fa-headset"></i></div>
          <h3>Real Human Support</h3>
          <p>Talk to people who actually use the tools — not just scripts.</p>
        </div>
      </div>

      <!-- RIGHT: text + CTA -->
      <div class="why-right">
        <span class="section-label">WHY CHOOSE US</span>
        <h2 class="section-heading">
          Tools that go<br>
          <span>beyond</span> expectations.
        </h2>
        <p class="why-subtext">
          We combine quality, speed, and genuine expertise to deliver the right hardware every time.
          Our team is dedicated to making every project easier — on time and within budget.
        </p>
        <a href="{{ route('products') }}" class="btn-shop-now">
          Shop Now
          <span class="btn-arrow"><i class="fas fa-arrow-right"></i></span>
        </a>
      </div>

    </div>
  </section>


  <!-- MEET OUR TEAM – same full-width bg, continues seamlessly -->
  <section class="meet-team">
    <div class="meet-team-divider">
      <hr>
    </div>
    <div class="meet-team-inner">
      <span class="section-label">MEET OUR TEAM</span>
      <h2 class="section-heading">The People Behind Apex</h2>

      <div class="team-grid">
        @php
          $team = [
            ['Adam Abla',        'AA'],
            ['Oswald Angadi',    'OA'],
            ['Omar Elshora',     'OE'],
            ['Mohammed Hozaifa','MH'],
            ['Sholademi Lateef', 'SL'],
            ['Bashir Osman',     'BO'],
            ['Sukhbir Singh',    'SS'],
            ['Fritz Lucina',     'FL'],
          ];
        @endphp

        @foreach($team as [$name, $initials])
          <div class="team-member">
            <div class="team-avatar">{{ $initials }}</div>
            <h4>{{ $name }}</h4>
          </div>
        @endforeach
      </div>
    </div>
  </section>

@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', () => {

  /**
   * Repeatable scroll-reveal for ALL .js-reveal elements
   * - Animates IN  when element reaches 30 % visibility
   * - Resets silently when element leaves viewport entirely
   * - Re-animates every time user scrolls back to it
   */
  const els = document.querySelectorAll('.js-reveal');

  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      const el = entry.target;

      if (entry.isIntersecting) {
        // Remove instant-reset, then animate in (double-rAF ensures repaint)
        el.classList.remove('reset');
        requestAnimationFrame(() => requestAnimationFrame(() => {
          el.classList.add('visible');
        }));
      } else if (entry.intersectionRatio === 0) {
        // Fully off-screen → snap back without transition so next entry re-animates
        el.classList.remove('visible');
        el.classList.add('reset');
      }
    });
  }, { threshold: [0, 0.3] });

  els.forEach(el => io.observe(el));

});
</script>
@endsection