<!-- Heater -->
<?php
$pageTitle = "Pixel Laser Prints - Home"; // Define el título de la página
include 'includes/header.php';
?>

<!-- Hero -->
<?php
include 'includes/hero.php';
?>


<main class="container my-5">

  <!-- SECTION 1 -->

  <section class="section-wrapper mt-5 mb-5 bg-white" id="what-we-deliver">
    <div class="container text-center">
      <h2 class="display-3 custom mb-4 fw-bold text-black">Crafting Personalized Designs with Precision</h2>
      <p class="mb-5">At Pixel Laser Prints, we combine creativity, craftsmanship, and cutting-edge technology to
        transform everyday items into extraordinary keepsakes. Whether it’s a custom sign for your business, décor for
        your wedding, or a personalized gift, our mission is to deliver products that are as unique as you are.</p>

      <div class="row g-4">

        <!-- Card 1 -->
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card h-100 shadow-sm border-0 text-white card-bg"
            style="background-image: url('<?php echo BASE_URL; ?>/images/general/index/modernDesigns.jpg');">
            <div class="card-body d-flex flex-column justify-content-end text-start p-4">
              <h5 class="fw-bold">Modern Designs</h5>
              <p class="small">Sleek, stylish, and tailored to your vision.</p>

            </div>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card h-100 shadow-sm border-0 text-white card-bg"
            style="background-image: url('<?php echo BASE_URL; ?>/images/general/index/qr.JPG');">
            <div class="card-body d-flex flex-column justify-content-end text-start p-4">
              <h5 class="fw-bold">Premium Finish</h5>
              <p class="small">Attention to detail that makes every piece stand out.</p>

            </div>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card h-100 shadow-sm border-0 text-white card-bg"
            style="background-image: url('<?php echo BASE_URL; ?>/images/general/index/laserP.JPG');">
            <div class="card-body d-flex flex-column justify-content-end text-start p-4">
              <h5 class="fw-bold">Advanced Laser Technology</h5>
              <p class="small">Precision engraving on wood, acrylic, glass & metal.</p>

            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

</main>

<!-- Our Collections-->

<section class="section-wrapper bg-white">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="display-3 custom mb-4 fw-bold text-black">Explore Our Collections</h2>
      <p class="text-muted">Discover personalized products designed to celebrate moments, elevate brands, and make
        lasting impressions.</p>
    </div>
    <div class="row g-4">

      <!-- Card Template -->
      <div class="col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal"
          data-title="Corporate & Hospitality"
          data-description="Elegant engraved solutions for businesses, offices, and hotels."
          data-image="<?php echo BASE_URL; ?>/images/general/index/corporate.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/corporate.png" alt="Custom Signage">
          <div class="overlay">
            <h5 class="text-black">Corporate & Hospitality</h5>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal" data-title="Signage"
          data-description="Custom engraved signs for offices, restaurants, and events."
          data-image="<?php echo BASE_URL; ?>/images/general/index/singage.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/singage.png" alt="Corporate Gifts">
          <div class="overlay">
            <h5 class="text-black">Signage</h5>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal"
          data-title="Wedding Decor & Events" data-description="Add elegance and personalization to your special day."
          data-image="<?php echo BASE_URL; ?>/images/general/index/decoration.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/decoration.png" alt="Wedding Décor">
          <div class="overlay">
            <h5 class="text-black">Wedding Decor & Events</h5>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal" data-title="Sports"
          data-description="Celebrate achievements with modern engraved designs."
          data-image="<?php echo BASE_URL; ?>/images/general/index/sports.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/sports.png" alt="Trophies & Awards">
          <div class="overlay">
            <h5 class="text-black">Sports</h5>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal"
          data-title="Home Decor & Lifestyle" data-description="Personalized items that bring style into your home."
          data-image="<?php echo BASE_URL; ?>/images/general/index/decor.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/decor.png" alt="Trophies & Awards">
          <div class="overlay">
            <h5 class="text-black">Home Decor & Lifestyle</h5>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal" data-title="Restaurants"
          data-description="Personalized items for the food and hospitality industry."
          data-image="<?php echo BASE_URL; ?>/images/general/index/restaurants.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/restaurants.png" alt="Trophies & Awards">
          <div class="overlay">
            <h5 class="text-black">Restaurants</h5>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal" data-title="NFC"
          data-description="Smart, connected products for the modern world." 
          data-image="<?php echo BASE_URL; ?>/images/general/index/nfc.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/nfc.png" alt="NFC">
          <div class="overlay">
            <h5 class="text-black">NFC</h5>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal" data-title="Local Stores"
          data-description="Personalized products made locally for local businesses."
          data-image="<?php echo BASE_URL; ?>/images/general/index/localIndex.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/localIndex.png" alt="Trophies & Awards">
          <div class="overlay">
            <h5 class="text-black">Local Stores</h5>
          </div>
        </div>
      </div>



      <!-- ... puedes seguir con las demás cards igual cambiando título, descripción e imagen ... -->

      <div class="py-4 mt-5 text-center">
        <a href="<?php echo BASE_URL; ?>/views/catalog.php" class="btn btn-gold btn-lg rounded-pill">Explore Our
          Catalog</a>
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="cardModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="cardModalImage" src="" class="img-fluid rounded mb-3" alt="">
        <p id="cardModalDescription" class="text-muted"></p>
      </div>
    </div>
  </div>
</div>

<script>
  // Script para llenar el modal dinámicamente
  const cardModal = document.getElementById('cardModal');
  cardModal.addEventListener('show.bs.modal', event => {
    const card = event.relatedTarget;
    const title = card.getAttribute('data-title');
    const description = card.getAttribute('data-description');
    const image = card.getAttribute('data-image');

    document.getElementById('cardModalLabel').textContent = title;
    document.getElementById('cardModalDescription').textContent = description;
    document.getElementById('cardModalImage').src = image;
  });
</script>

<style>
  .category-card {
    position: relative;
    overflow: hidden;
    cursor: pointer;
    border-radius: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .category-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
  }

  .category-card:hover img {
    transform: scale(1.1);
  }

  .overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 20px;
    background: rgba(255, 255, 255, 0.7);
    text-align: center;
  }

  .category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
  }
</style>






<section class="section-wrapper bg-white">

  <div class="container">
    <!-- Título -->
    <div class="text-center mb-5">
      <h2 class="display-3 fw-bold text-black">Our Commitment to Every Project</h2>
      <p class="text-muted">Personalized creations crafted with precision and care.</p>
    </div>
    <div class="special-project mt-5 p-5 bg-light rounded-4 shadow-sm">
      <div class="row align-items-center g-4">
        <div class="col-md-6">
          <!-- <img src="/images/general/index/aztecaIndex.JPG" class="img-fluid rounded-3 mb-3" alt="Restaurant Process"> -->
          <img src="<?php echo BASE_URL; ?>/images/general/index/aztecaIndex.JPG" class="img-fluid rounded-3"
            alt="Restaurant Final">
          <p class="mt-3 text-center text-secondary fst-italic">Azteca restaurant in Charlottetown, PEI</p>
        </div>



        <div class="col-md-6">
          <h3 class="fw-bold py-4 text-black">We care about your product</h3>
          <p class="text-muted">
            At Pixel Laser Prints, every project is special.
            From the first idea to the final product, we put our full attention,
            creativity, and dedication into every step of the process.
          </p>
          <p class="text-muted">
            Whether it’s signage for a business, décor for a wedding,
            or a personalized gift, we collaborate closely with our
            clients to ensure their vision is brought to life with
            precision and care.
          </p>
          <p class="text-muted">
            Every detail matters,from material selection to
            engraving accuracy,because we believe the result should not only meet expectations but create a lasting
            impression.
          </p>
          <p class="fw-semibold text-black">
            For us, it’s not just about making products,
            it’s about turning ideas into meaningful designs that truly represent our clients.
          </p>
        </div>
      </div>
    </div>
</section>



<!-- SECTION 4-->

<section class="section-wrapper "
  style="background: url('<?php echo BASE_URL; ?>/images/general/index/clientsIndex.png') no-repeat center center/cover;">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold text-dark">What Our Clients Say</h2>
      <p class="text-muted">Real experiences from people who trusted Pixel Laser Prints to create something unique.</p>
    </div>

    <!-- Carrusel -->
    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">

        <!-- Testimonio 1 -->
        <div class="carousel-item active">
          <div class="card shadow-sm border-1 mx-auto" style="max-width: 700px;">
            <div class="card-body text-center p-4">
              <div class="stars mb-3">
                ★★★★★
              </div>
              <p class="text-muted fst-italic">“The custom signage we ordered was stunning and delivered quickly. Our
                office space feels so much more professional.”</p>
              <h6 class="fw-bold mt-3 text-dark">Sarah M.</h6>
              <small class="text-muted">Charlottetown, PEI</small>
            </div>
          </div>
        </div>

        <!-- Testimonio 2 -->
        <div class="carousel-item">
          <div class="card shadow-sm border-1 mx-auto" style="max-width: 700px;">
            <div class="card-body text-center p-4">
              <div class="stars mb-3">
                ★★★★★
              </div>
              <p class="text-muted fst-italic">“Pixel created beautiful wedding décor for us. Every detail was perfect —
                we couldn’t have asked for more.”</p>
              <h6 class="fw-bold mt-3 text-dark">James & Emily</h6>
              <small class="text-muted">Summerside, PEI</small>
            </div>
          </div>
        </div>

        <!-- Testimonio 3 -->
        <div class="carousel-item">
          <div class="card shadow-sm border-1 mx-auto" style="max-width: 700px;">
            <div class="card-body text-center p-4">
              <div class="stars mb-3">
                ★★★★★
              </div>
              <p class="text-muted fst-italic">“The engraved tumblers we gifted to our team were a huge hit. High
                quality and very professional.”</p>
              <h6 class="fw-bold mt-3 text-dark">Michael R.</h6>
              <small class="text-muted">Business Owner</small>
            </div>
          </div>
        </div>

      </div>

      <!-- Controles -->
      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </div>
</section>


<!--  -->

<section class="py-5 bg-white">
  <div class="container text-center">
    <h2 class="fw-bold mb-4">Brands We’ve Worked With</h2>
    <p class="text-secondary mb-5">We’re proud to have collaborated with businesses and organizations that trust our
      work.</p>

    <div class="row justify-content-center align-items-center g-4">
      <!-- Marca 1 -->
      <div class="col-6 col-md-3 col-lg-2">
        <div class="p-3 border rounded-4 shadow-sm brand-box">
          <img src="<?php echo BASE_URL; ?>/images/general/clients/rodd.png" class="img-fluid" alt="Brand 1">
        </div>
      </div>
      <!-- Marca 2 -->
      <div class="col-6 col-md-3 col-lg-2">
        <div class="p-3 border rounded-4 shadow-sm brand-box">
          <img src="<?php echo BASE_URL; ?>/images/general/clients/haviland.png" class="img-fluid" alt="Brand 2">
        </div>
      </div>
      <!-- Marca 3 -->
      <div class="col-6 col-md-3 col-lg-2">
        <div class="p-3 border rounded-4 shadow-sm brand-box">
          <img src="<?php echo BASE_URL; ?>/images/general/clients/connectors.png" class="img-fluid" alt="Brand 3">
        </div>
      </div>
      <!-- Marca 4 -->
      <div class="col-6 col-md-3 col-lg-2">
        <div class="p-3 border rounded-4 shadow-sm brand-box">
          <img src="<?php echo BASE_URL; ?>/images/general/clients/azteca.png" class="img-fluid" alt="Brand 4">
        </div>
      </div>

    </div>
  </div>
</section>



<!-- Section 5 -->

<section class="section-wrapper text-center">
  <div class="container section-wrapper">
    <h2 class="fw-bold mb-3 text-black">Bring Your Ideas to Life with Pixel Laser Prints</h2>
    <p class="mb-4 text-light text-black">Whether it’s a personalized gift, wedding décor, or custom signage, we’re here
      to create something truly unique for you.</p>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
      <a href="tel:<?php echo COMPANY_PHONE_TEL; ?>" class="btn btn-lg btn-gold px-4">
        <i class="bi bi-telephone-fill"></i> Call Us
      </a>
      <a href="<?php echo BASE_URL; ?>/views/contact.php" class="btn btn-lg btn-outline-dark px-4">Contact Us Today</a>
    </div>
  </div>
</section>






<!-- Cookie Banner -->
<div id="cookie-banner" class="cookie-banner">
  <div class="cookie-content">
    <p class="cookie-message">
      <strong>We care about your privacy</strong><br>
      This website uses cookies for functionality, analytics and marketing.
      By accepting, you agree to our
      <a href="<?php echo BASE_URL; ?>/views/privacy.php" target="_blank" class="cookie-link">Cookie Policy</a>.
    </p>
    <div class="cookie-buttons">
      <button id="accept-cookies" class="cookie-button accept">Accept</button>
      <button id="decline-cookies" class="cookie-button decline">Decline</button>
    </div>
  </div>
</div>





<!-- Footer -->
<?php
include 'includes/footer.php';
?>