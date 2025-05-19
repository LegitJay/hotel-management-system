  window.addEventListener('scroll', function() {
    const nav = document.querySelector('nav');
    if (window.scrollY > 50) {
      nav.classList.remove('transparent');
      nav.classList.add('scrolled');
    } else {
      nav.classList.remove('scrolled');
      nav.classList.add('transparent');
    }
  });

  // Ensure the right class is set on page load
  window.addEventListener('DOMContentLoaded', function() {
    const nav = document.querySelector('nav');
    if (window.scrollY <= 50) {
      nav.classList.add('transparent');
    }
  });
