<?php
    include("header.html");
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us | Apex Hardware Supply & Tools</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    :root {
      --orange: #D47C17;
      --black: #070707;
      --grey: #707070;
      --white: #FFFFFF;
      --light: #f9f9f9;
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background: var(--white);
      color: #333;
      line-height: 1.7;
    }

    /* Hero - EXACTLY like your original */
    .hero {
      background: var(--black);
      color: white;
      text-align: center;
      padding: 120px 20px;
    }
    .hero h1 {
      font-size: 3.8rem;
      color: var(--orange);
      margin-bottom: 15px;
    }
    .hero p { 
      font-size: 1.3rem; 
      opacity: 0.9; 
    }

    .container {
      max-width: 1100px;
      margin: 0 auto;
      padding: 80px 20px 0;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
    }

    /* Contact Info */
    .contact-info h2, .contact-form h2 {
      color: var(--orange);
      margin-bottom: 30px;
      font-size: 2.2rem;
    }
    .info-item {
      display: flex;
      gap: 15px;
      margin-bottom: 25px;
      align-items: flex-start;
    }
    .info-item i {
      color: var(--orange);
      font-size: 1.4rem;
      margin-top: 4px;
    }

    /* Form - YOUR REQUESTED FIELDS ONLY */
    form {
      display: grid;
      gap: 20px;
    }
    input, textarea {
      width: 100%;
      padding: 14px 16px;
      border: 2px solid #ddd;
      border-radius: 8px;
      font-size: 1rem;
    }
    input:focus, textarea:focus {
      outline: none;
      border-color: var(--orange);
    }
    textarea { 
      min-height: 140px;
      resize: vertical;
    }
    button {
      background: var(--orange);
      color: white;
      padding: 16px;
      border: none;
      border-radius: 8px;
      font-size: 1.1rem;
      font-weight: bold;
      cursor: pointer;
      margin-top: 10px;
    }
    button:hover { 
      background: #b86b12; 
    }

    /* Map Section */
    .map-section {
      margin-top: 100px;
      text-align: center;
      padding: 60px 20px;
      background: var(--light);
    }
    .map-section h2 {
      color: var(--orange);
      margin-bottom: 30px;
      font-size: 2.4rem;
    }
    .map-container {
      width: 100%;
      height: 500px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    footer {
      background: var(--black);
      color: var(--grey);
      text-align: center;
      padding: 50px 20px;
      margin-top: 0;
    }

    /* Perfect Responsiveness */
    @media (max-width: 768px) {
      .container { 
        grid-template-columns: 1fr; 
        gap: 60px; 
        padding: 60px 20px 0;
      }
      .hero h1 { font-size: 2.8rem; }
      .hero { padding: 100px 20px; }
      .map-container { height: 400px; }
    }
    @media (max-width: 480px) {
      .hero h1 { font-size: 2.5rem; }
      .contact-info h2, .contact-form h2 { font-size: 2rem; }
    }
  </style>
</head>
<body>

  <!-- Hero -->
  <div class="hero">
    <h1>Contact Us</h1>
    <p>We’re here to help – reach out any time</p>
  </div>

  <div class="container">

    <!-- Contact Info -->
    <div class="contact-info">
      <h2>Get in Touch</h2>
      <div class="info-item">
        <i class="fas fa-envelope"></i>
        <div>
          <strong>Email</strong><br>
          support@apexhardware.co.uk
        </div>
      </div>
      <div class="info-item">
        <i class="fas fa-phone"></i>
        <div>
          <strong>Phone</strong><br>
          0121 204 5555<br>
          Mon–Fri 8am–6pm | Sat 9am–2pm
        </div>
      </div>
      <div class="info-item">
        <i class="fas fa-map-marker-alt"></i>
        <div>
          <strong>Showroom & Warehouse</strong><br>
          Unit 12, Birmingham Trade Park<br>
          Aston, Birmingham B6 7EU<br>
          United Kingdom
        </div>
      </div>
    </div>

    <!-- Contact Form - EXACTLY WHAT YOU ASKED FOR -->
    <div class="contact-form">
      <h2>Send us a Message</h2>
      <form action="https://formspree.io/f/your-form-id" method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="text" name="subject" placeholder="Subject" required>
        <textarea name="message" placeholder="Message" required></textarea>
        <button type="submit">Send Message</button>
      </form>
    </div>

  </div>

  <!-- Map -->
  <div class="map-section">
    <h2>Visit Our Showroom</h2>
    <div class="map-container">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2429.4!2d-1.8828!3d52.5030!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4870bc8f0d8e6acd%3A0x4e3e4e4e4e4e4e4e!2sAston%2C%20Birmingham!5e0!3m2!1sen!2suk!4v1734028800000"
        width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy">
      </iframe>
    </div>
  </div>

  

</body>
</html>
