<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us | Apex Hardware Supply & Tools</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    :root {
      --orange: #D47C17;
      --black: #070707;
      --dark-grey: #1a1a1a;
      --grey: #707070;
      --white: #FFFFFF;
      --light: #f8f8f8;
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--white);
      color: #333;
      line-height: 1.8;
    }

    /* HERO – Dark grey + black mix */
    .hero {
      background: linear-gradient(rgba(26,26,26,0.96), rgba(7,7,7,0.98)),
                  url('https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?ixlib=rb-4.0.3&auto=format&fit=crop&q=80') center/cover;
      color: white;
      text-align: center;
      padding: 140px 20px 100px;
    }
    .hero h1 {
      font-size: 4.2rem;
      font-weight: 900;
      color: var(--orange);
      margin-bottom: 16px;
    }
    .hero p {
      font-size: 1.5rem;
      max-width: 800px;
      margin: 0 auto;
      opacity: 0.92;
    }

    .container { max-width: 1300px; margin: 0 auto; padding: 0 20px; }

    .section-title {
      font-size: 2.8rem;
      color: var(--orange);
      text-align: center;
      margin: 80px 0 50px;
      font-weight: 700;
    }

    /* Our Story */
    .story-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 70px;
      align-items: center;
      margin: 60px 0;
    }
    .story-row img {
      width: 100%;
      border-radius: 18px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.18);
    }
    .story-text h2 {
      color: var(--orange);
      font-size: 2.5rem;
      margin-bottom: 20px;
    }

    /* Vision Quote */
    .vision {
      background: var(--light);
      padding: 70px 40px;
      border-radius: 20px;
      text-align: center;
      font-size: 2.3rem;
      font-weight: 600;
      font-style: italic;
      color: var(--orange);
      border-left: 12px solid var(--orange);
      margin: 100px auto;
      max-width: 1000px;
      box-shadow: 0 12px 35px rgba(0,0,0,0.09);
    }

    /* Vision & Scope + We Serve – Side by Side (unchanged) */
    .vision-scope-section {
      background: var(--light);
      padding: 90px 40px;
      border-radius: 20px;
      margin: 100px auto;
      max-width: 1300px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    }
    .vision-box, .audience-box {
      padding: 20px;
    }
    .vision-box h3, .audience-box h3 {
      color: var(--orange);
      font-size: 2.2rem;
      margin-bottom: 25px;
      text-align: center;
    }
    .vision-box p {
      font-size: 1.2rem;
      text-align: center;
      line-height: 1.9;
    }
    .audience-box ul {
      list-style: none;
      font-size: 1.2rem;
    }
    .audience-box li {
      padding: 12px 0;
      border-bottom: 1px solid #ddd;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .audience-box li i {
      color: var(--orange);
      font-size: 1.4rem;
    }

    /* Why Choose Apex – NOW PERFECTLY RESPONSIVE (2×2 on laptop, 1 column on mobile) */
    .cards {
      display: grid;
      grid-template-columns: repeat(4, 1fr);   /* 4 cards in one row on large screens */
      gap: 35px;
      margin: 100px 0;
      padding: 0 20px;
    }
    .card {
      background: white;
      padding: 45px 30px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 12px 35px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
    }
    .card:hover {
      transform: translateY(-15px);
      box-shadow: 0 25px 60px rgba(212,124,23,0.2);
    }
    .card i {
      font-size: 4rem;
      color: var(--orange);
      margin-bottom: 25px;
    }
    .card h3 {
      font-size: 1.6rem;
      margin-bottom: 16px;
      color: var(--black);
    }

    footer {
      background: var(--black);
      color: #aaa;
      text-align: center;
      padding: 60px 20px;
      margin-top: 120px;
      font-size: 1rem;
    }

    /* RESPONSIVE FIXES */
    @media (max-width: 1200px) {
      .cards { grid-template-columns: repeat(2, 1fr); }  /* 2×2 on laptops */
    }
    @media (max-width: 768px) {
      .story-row, .vision-scope-section { grid-template-columns: 1fr; gap: 50px; }
      .cards { grid-template-columns: 1fr; }  /* 1 column on tablets/phones */
      .hero h1 { font-size: 3rem; }
      .section-title { font-size: 2.4rem; }
    }
    @media (max-width: 480px) {
      .hero { padding: 100px 15px; }
      .hero h1 { font-size: 2.6rem; }
      .vision-scope-section { padding: 60px 20px; }
    }
  </style>
</head>
<body>

  <!-- Hero -->
  <header class="hero">
    <h1>About Apex Hardware</h1>
    
  </header>

  <div class="container">

    <!-- Our Story -->
    <h2 class="section-title">Our Story</h2>
    <div class="story-row">
      <div class="story-text">
        <h2>Welcome to Apex Hardware Supply & Tools</h2>
        <p>Apex was created to make life easier for anyone who loves to build, fix, or create. We know how frustrating it is to waste time driving between stores or waiting weeks for the right tool.</p>
        <p>That’s why we bring professional-quality tools, materials and hardware straight to your door — fast, affordable, and reliable.</p>
        <p>From weekend DIY projects to full-scale professional jobs, we’ve got everything you need in one place.</p>
      </div>
      <img src="C:\Users\Mohammed Hozaifa\OneDrive\Desktop\CS2\Team Project\web pages\hardware.jpeg" alt="Apex Workshop">
    </div>

    <!-- Vision Quote -->
    <div class="vision">
      “Everything you need to turn ideas into reality.”
    </div>

    <div class="vision-scope-section">
      <div class="vision-box">
        <h3>Vision & Scope</h3>
        <p><strong>Vision:</strong> To become the UK’s most trusted online supplier for builders, makers and creators.</p>
        <p style="margin-top:20px;"><strong>Scope:</strong> Supplying high-quality general tools, power tools, gardening equipment, building materials and electronic components to home DIY enthusiasts, professional tradespeople and small businesses.</p>
      </div>
      <div class="audience-box">
        <h3>We Serve</h3>
        <ul>
          <li><i class="fas fa-check-circle"></i> Home DIY Enthusiasts & Weekend Warriors</li>
          <li><i class="fas fa-check-circle"></i> Professional Tradespeople</li>
          <li><i class="fas fa-check-circle"></i> Small Construction & Landscaping Businesses</li>
          <li><i class="fas fa-check-circle"></i> Makers, Hobbyists & Electronics Enthusiasts</li>
          <li><i class="fas fa-check-circle"></i> Schools, Colleges & Workshop Clubs</li>
        </ul>
      </div>
    </div>

    <!-- Why Choose Apex – Now perfectly in one row on laptop -->
    <h2 class="section-title">Why Choose Apex?</h2>
    <div class="cards">
      <div class="card">
        <i class="fas fa-tools"></i>
        <h3>Professional Quality</h3>
        <p>Tools trusted by real tradespeople every day</p>
      </div>
      <div class="card">
        <i class="fas fa-truck-fast"></i>
        <h3>Fast Delivery</h3>
        <p>Next-day delivery on most items</p>
      </div>
      <div class="card">
        <i class="fas fa-shield-alt"></i>
        <h3>Best Price Guarantee</h3>
        <p>Find it cheaper elsewhere? We’ll match it</p>
      </div>
      <div class="card">
        <i class="fas fa-headset"></i>
        <h3>Expert Support</h3>
        <p>Talk to real humans who understand tools</p>
      </div>
    </div>

  </div>

  
</body>
</html>
