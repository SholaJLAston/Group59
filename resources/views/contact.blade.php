@extends('layouts.app')

@section('title', 'Contact Us')

@section('extra-css')
  <style>
    /* Hero */
    .hero {
      background: linear-gradient(rgba(7,7,7,0.65), rgba(7,7,7,0.65)),
                  url('{{ asset('images/hardware.avif') }}') center/cover; 
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

    .contact-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 80px 20px 0;
      display: grid;
      grid-template-columns: 1fr 1.8fr;
      gap: 60px;
      align-items: start;
    }

    /* Contact Info */
    .contact-info h2 {
      color: var(--black);
      margin-bottom: 40px;
      font-size: 1.4rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .contact-form h2 {
      color: var(--black);
      font-size: 1.4rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 25px;
    }

    .info-item {
      display: flex;
      gap: 15px;
      margin-bottom: 35px;
      align-items: flex-start;
    }

    .info-item i {
      background: var(--orange);
      color: white;
      font-size: 1.3rem;
      width: 50px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 6px;
      flex-shrink: 0;
      margin-top: 0;
    }

    .info-item div {
      flex: 1;
    }

    .info-item strong {
      display: block;
      font-size: 1.1rem;
      color: var(--black);
      margin-bottom: 6px;
      font-weight: 700;
    }

    .info-item p {
      color: #666;
      font-size: 0.95rem;
      line-height: 1.6;
      margin: 0;
    }

    .contact-form {
      padding: 40px;
      background: #f5f5f5;
      border-radius: 4px;
    }

    /* Form */
    .contact-form form {
      display: grid;
      gap: 20px;
      background: transparent;
      padding: 0;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .contact-form input,
    .contact-form textarea {
      width: 100%;
      padding: 16px 18px;
      border: none;
      border-radius: 4px;
      font-size: 1rem;
      background: white;
      color: #333;
      font-family: inherit;
    }

    .contact-form input::placeholder,
    .contact-form textarea::placeholder {
      color: #999;
    }

    .contact-form input:focus,
    .contact-form textarea:focus {
      outline: none;
      background: #fafafa;
      box-shadow: 0 0 0 2px rgba(212, 124, 23, 0.1);
    }

    .contact-form textarea {
      min-height: 140px;
      resize: vertical;
      grid-column: 1 / -1;
    }

    .contact-form button {
      background: var(--orange);
      color: white;
      padding: 16px 40px;
      border: none;
      border-radius: 4px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      margin-top: 10px;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      width: fit-content;
      transition: background 0.3s ease;
    }

    .contact-form button:hover {
      background: #b86b12; 
    }

    .contact-form button i {
      font-size: 1.1rem;
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

    /* Responsiveness */
    @media (max-width: 768px) {
      .contact-container {
        grid-template-columns: 1fr; 
        gap: 34px;
        padding: 50px 16px 0;
      }
      .contact-form {
        padding: 24px 18px;
      }
      .hero h1 { font-size: 2.3rem; }
      .hero p { font-size: 1rem; }
      .hero { padding: 86px 16px; }
      .map-section {
        margin-top: 70px;
        padding: 44px 14px;
      }
      .map-container { height: 400px; }
    }

    @media (max-width: 480px) {
      .hero h1 { font-size: 1.95rem; }
      .contact-info h2, .contact-form h2 { font-size: 1.2rem; }
      .form-row {
        grid-template-columns: 1fr;
        gap: 14px;
      }
      .map-container { height: 300px; }
    }

    @media (max-width: 390px) {
      .hero {
        padding: 72px 12px;
      }

      .hero h1 {
        font-size: 1.75rem;
      }

      .contact-container {
        padding: 38px 12px 0;
      }

      .contact-form {
        padding: 18px 12px;
      }

      .contact-form button {
        width: 100%;
        justify-content: center;
      }
    }

    @media (min-width: 768px) and (max-width: 1024px) {
      .contact-container {
        grid-template-columns: 1fr;
        gap: 34px;
        max-width: 860px;
      }
    }

    /* Success message styling */
    .success-message {
      position: fixed;
      top: 20px;
      right: 20px;
      background: #d1fae5;
      border-left: 4px solid #10b981;
      color: #065f46;
      padding: 1rem 1.5rem;
      border-radius: 0.5rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      z-index: 2100;
      animation: slideIn 0.3s ease-out;
      opacity: 1;
      transform: translateX(0);
      transition: opacity 0.35s ease, transform 0.35s ease;
    }

    .success-message.hiding {
      opacity: 0;
      transform: translateX(36px);
    }

    @keyframes slideIn {
      from {
        transform: translateX(400px);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }
  </style>
@endsection

@section('content')

  <!-- Success Message -->
  @if(session('success'))
    <div class="success-message">
      {{ session('success') }}
    </div>
  @endif

  <!-- Hero -->
  <div class="hero">
    <h1>Contact Us</h1>
    <p>We’re here to help – reach out any time</p>
  </div>

  <div class="contact-container">

    <!-- Contact Info -->
    <div class="contact-info">
      <h2>Get in Touch</h2>
      
      <div class="info-item">
        <i class="fas fa-map-marker-alt"></i>
        <div>
          <strong>Address</strong>
          Unit 12, Birmingham Trade Park, Aston, Birmingham B6 7EU
        </div>
      </div>

      <div class="info-item">
        <i class="fas fa-phone"></i>
        <div>
          <strong>Phone</strong>
          +1 (555) 123-4567<br>
          +1 (555) 987-6543
        </div>
      </div>

      <div class="info-item">
        <i class="fas fa-envelope"></i>
        <div>
          <strong>Email</strong>
          info@apexhardware.com<br>
          support@apexhardware.com
        </div>
      </div>

      <div class="info-item">
        <i class="fas fa-clock"></i>
        <div>
          <strong>Business Hours</strong>
          Monday - Friday: 7:00 AM - 6:00 PM<br>
          Saturday: 8:00 AM - 4:00 PM<br>
          Sunday: Closed
        </div>
      </div>
    </div>

    <!-- Contact Form -->
    <div class="contact-form">
      <form action="{{ route('contact.store') }}" method="POST">
        @csrf
        <h2>Send us a Message</h2>
        <div class="form-row">
          <input type="text" name="name" placeholder="Your Name" required>
          <input type="email" name="email" placeholder="Email Address" required>
        </div>
        <input type="text" name="subject" placeholder="Subject" required>
        <textarea name="message" placeholder="Tell us more about your inquiry..." required></textarea>
        <button type="submit"><i class="fas fa-paper-plane"></i> SEND MESSAGE</button>
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

@endsection

@section('extra-js')
<script>
  // Auto-hide success message after ~3 seconds (ecommerce-style toast)
  document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.querySelector('.success-message');
    if (successMessage) {
      setTimeout(function() {
        successMessage.classList.add('hiding');
        setTimeout(function() {
          successMessage.remove();
        }, 360);
      }, 2800);
    }
  });
</script>
@endsection