window.addEventListener('scroll', function() {
    var navbar = document.querySelector('nav');
    if (window.scrollY > 50) {
      navbar.style.backgroundColor = '#24262b';
    } else {
      navbar.style.backgroundColor = 'transparent';
    }
  });