
// Account dropdown toggle
document.addEventListener('click', function(event) {
    const guestButton = document.getElementById('guestMenuButton');
    const guestDropdown = document.getElementById('guestDropdown');
    const userButton = document.getElementById('userMenuButton');
    const userDropdown = document.getElementById('userDropdown');

    if (guestButton && guestDropdown) {
        if (event.target === guestButton || guestButton.contains(event.target)) {
            guestDropdown.classList.toggle('hidden');
        } else {
            guestDropdown.classList.add('hidden');
        }
    }

    if (userButton && userDropdown) {
        if (event.target === userButton || userButton.contains(event.target)) {
            userDropdown.classList.toggle('hidden');
        } else {
            userDropdown.classList.add('hidden');
        }
    }
});


// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
  const dropdowns = document.querySelectorAll('.account-dropdown');
  dropdowns.forEach(dropdown => {
    if (!dropdown.contains(e.target)) {
      dropdown.classList.remove('active');
    }
  });
});

// Mobile menu toggle (used on all pages)
document.getElementById('menuToggle')?.addEventListener('click', () => {
  document.querySelector('.main-links').classList.toggle('active');
});