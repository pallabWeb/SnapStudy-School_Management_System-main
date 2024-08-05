(function ($) {
  "use strict";

  // Preloader
  $(window).on("load", function () {
    $("#preloader").delay(600).fadeOut();
  });

  // Mobile Toggle Btn
  $(".navbar-toggle").on("click", function () {
    $("#header").toggleClass("nav-collapse");
  });
})(jQuery);


////////////////////////////////////////
// Change navbar background on scroll //
////////////////////////////////////////


// window.addEventListener('scroll', function() {
//   var navbar = document.querySelector('nav');
//   if (window.scrollY > 50) {
//     navbar.style.backgroundColor = '#24262b';
//   } else {
//     navbar.style.backgroundColor = 'transparent';
//   }
// });