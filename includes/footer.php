<footer class="bg-black text-light pt-5 pb-3">
  <div class="container">
    <div class="row">
      
      <!-- Columna 1 -->
      <div class="col-md-3 mb-4">
        <h5 class="fw-bold"></h5>
        <img src="/images/logo/logo.png" alt="Company Logo" class="mb-3" style="max-width: 150px;">
        <p class="small">
          Creative engraving and design studio in Prince Edward Island, Canada. 
          We create unique personalized products with premium finishes.
        </p>
      </div>

      <!-- Columna 2 -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-bold">Company</h6>
        <ul class="list-unstyled">
          <li><a href="/index.php" class="text-light text-decoration-none">Home</a></li>
          <li><a href="#" class="text-light text-decoration-none">Products</a></li>
          <li><a href="/views/about.php" class="text-light text-decoration-none">About Us</a></li>
          <li><a href="/views/contact.php" class="text-light text-decoration-none">Contact</a></li>
          <li><a href="/views/catalog.php" class="text-light text-decoration-none">Catalog</a></li>
          <li><a href="#" class="text-light text-decoration-none">FAQ</a></li>
        </ul>
      </div>

      <!-- Columna 3 -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-bold">Products</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="text-light text-decoration-none">Signage</a></li>
          <li><a href="#" class="text-light text-decoration-none">Corporate Gifts</a></li>
          <li><a href="#" class="text-light text-decoration-none">Wedding Décor</a></li>
          <li><a href="#" class="text-light text-decoration-none">Trophies & Awards</a></li>
          <li><a href="#" class="text-light text-decoration-none">Home Décor</a></li>
          <li><a href="#" class="text-light text-decoration-none">Restaurants</a></li>
          <li><a href="#" class="text-light text-decoration-none">NFC</a></li>
          <li><a href="#" class="text-light text-decoration-none">Local Stores</a></li>
        </ul>
      </div>

      <!-- Columna 4 -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-bold">Contact</h6>
        <p class="small mb-1">📍 180 Belvedere Ave , Charlottetown, PEI,C1A 2Z1, Canada.</p>
        <p class="small mb-1">📞 (902) 330-1525</p>
        <p class="small mb-1">✉️ sales@pixellaserprints.ca</p>
        <p class="small mb-1">⏰ Monday - Friday: 7am - 6pm</p> 
        <p class="small ">Saturday: 7am -2pm , Sunday: Closed.</p>
        <div>
          <a href="https://www.facebook.com/people/Pixel-Laser-Prints/61571892844993/?mibextid=wwXIfr" class="text-light me-2"><i class="bi bi-facebook"></i></a>
          <a href="https://www.instagram.com/pixelcharlottetown/" class="text-light me-2"><i class="bi bi-instagram"></i></a>
          <a href="https://www.tiktok.com/@pixellaserpei" class="text-light"><i class="bi bi-tiktok"></i></a>
        </div>
      </div>

    </div>

    <!-- Barra inferior -->
    <div class="text-center mt-4 border-top pt-3">
      <p class="small mb-0">
        © 2025 Pixel Laser Prints | All rights reserved
      </p>
      <a href="/views/privacy.php" class="text-light text-decoration-none small me-2">Privacy Policy</a> |
      <a href="#" class="text-light text-decoration-none small ms-2">Terms and Conditions</a>
    </div>
    <!--POU TECH LOGO -->
    <div class="text-end">
      <p class="mb-0 py-0" style="font-size: 0.75rem; color: #6c757d;">
        Made with
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
        </svg>
        by <a class="text-secondary fw-bold" href="https://poutechnologies.com" target="_blank">Pou Technologies</a>.
        Version test
      </p>
    </div>
  </div>
</footer>



<!-- Bundle JS (Bootstrap y Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<!-- Otras librerías (como three.js) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<!-- Cookies -->
<script src="../style/js/cookies.js"> </script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);

    // Verifica el estado del formulario
    const formStatus = urlParams.get('form_status');

    switch (formStatus) {
      case 'success':
        Swal.fire({
          title: "Message Sent!",
          text: "Thank you for reaching out. We will get back to you soon.",
          icon: "success"
        });
        break;

      case 'error':
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!",
          footer: '<a href="pages/faqs.html">Why do I have this issue?</a>'
        });
        break;

      case 'missing':
        Swal.fire({
          title: "Are there any fields left unfilled?",
          text: "Please fill in all required fields before submitting.",
          icon: "warning",
          confirmButtonText: "OK"
        });
        break;

      case 'captcha_error':
        Swal.fire({
          title: "Captcha Not Verified",
          text: "Please complete the captcha verification before submitting.",
          icon: "warning",
          confirmButtonText: "OK"
        });
        break;

      default:
        // Maneja estados desconocidos o faltantes (opcional)
        console.warn("No valid form_status provided.");
        break;
    }
  });





// Verifica si el usuario ya cerró el aviso
function checkTestBanner() {
    return localStorage.getItem('testBannerClosed') === 'true';
}

// Muestra el banner si no se ha cerrado
function showTestBanner() {
    const banner = document.getElementById('test-banner');
    if (!checkTestBanner()) {
        banner.style.display = 'block';
    }
}

// Cierra el banner y guarda la preferencia
document.getElementById('close-test-banner').addEventListener('click', function() {
    const banner = document.getElementById('test-banner');
    banner.style.display = 'none';
    localStorage.setItem('testBannerClosed', 'true');
});

// Mostrar al cargar la página
document.addEventListener('DOMContentLoaded', showTestBanner);


</script>


</body>

</html>