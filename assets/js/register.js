document.addEventListener("DOMContentLoaded", function () {
  // Set timezone
  const tzInput = document.getElementById('timezone');
  if (tzInput) {
    tzInput.value = Intl.DateTimeFormat().resolvedOptions().timeZone;
  }

  // Page animation
  const form = document.getElementById('register-form');
  if (form) form.classList.add('page-enter-active');

  const loginBtn = document.getElementById('go-to-login');
  if (loginBtn && form) {
    loginBtn.addEventListener('click', function (e) {
      e.preventDefault();
      form.classList.add('page-exit-active');
      setTimeout(() => window.location.href = e.target.href, 500);
    });
  }
});
