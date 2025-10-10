(function() {
  const cookieBanner = document.getElementById('cookie-banner');
  const acceptBtn = document.getElementById('accept-cookies');
  const declineBtn = document.getElementById('decline-cookies');

  // Verifica si ya hay decisión
  function hasConsent() {
    return localStorage.getItem('cookiesAccepted') !== null;
  }

  // Mostrar el banner si no hay decisión
  function showBanner() {
    if (!hasConsent()) {
      cookieBanner.style.display = 'flex';
    }
  }

  // Guardar preferencia
  function setConsent(value) {
    localStorage.setItem('cookiesAccepted', value);
    cookieBanner.style.display = 'none';
  }

  // Eventos
  acceptBtn.addEventListener('click', () => setConsent(true));
  declineBtn.addEventListener('click', () => setConsent(false));

  // Inicializar
  document.addEventListener('DOMContentLoaded', showBanner);
})();
