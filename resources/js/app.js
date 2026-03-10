
// Account dropdown toggle (new unified approach)
document.addEventListener('click', function(event) {
  const dropdowns = document.querySelectorAll('.account-dropdown');
  dropdowns.forEach(dropdown => {
    const button = dropdown.querySelector('.account-btn');
    const is_menu = event.target === button || button.contains(event.target);
    
    if (is_menu) {
      dropdown.classList.toggle('active');
    } else {
      dropdown.classList.remove('active');
    }
  });
});

// Mobile menu toggle (used on all pages)
document.getElementById('menuToggle')?.addEventListener('click', (e) => {
  e.stopPropagation();
  const mainLinks = document.querySelector('.main-links');
  if (mainLinks) {
    mainLinks.classList.toggle('active');
  }
});

// Close mobile menu when clicking on a link
document.querySelectorAll('.main-links a').forEach(link => {
  link.addEventListener('click', () => {
    const mainLinks = document.querySelector('.main-links');
    if (mainLinks) {
      mainLinks.classList.remove('active');
    }
  });
});

// Close menu when clicking outside
document.addEventListener('click', function(e) {
  const mainLinks = document.querySelector('.main-links');
  const menuToggle = document.getElementById('menuToggle');
  const navbar = document.querySelector('.navbar');
  
  if (mainLinks && mainLinks.classList.contains('active')) {
    if (!navbar.contains(e.target)) {
      mainLinks.classList.remove('active');
    }
  }
});