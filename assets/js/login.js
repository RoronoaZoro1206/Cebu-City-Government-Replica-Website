     // Page transition animation
     document.getElementById('go-to-register').addEventListener('click', function(e) {
      e.preventDefault();
      const form = document.getElementById('login-form');
      form.classList.add('page-exit-active');
      
      setTimeout(function() {
        window.location.href = e.target.href;
      }, 500);
    });

    // Page enter animation on load
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('login-form');
      form.classList.add('page-enter-active');
    });

     