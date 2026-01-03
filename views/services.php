<!-- Header -->
<?php
$pageTitle = "Pixel Laser Prints - Services"; // Define el título de la página
include '../includes/header.php';
?>


<!-- Hero -->
<section class="heroServices d-flex align-items-center" style="min-height: 100vh;">
  <div class="container text-white">
    <div class="row">
      <div class="col-md-10 col-lg-8 mx-auto text-center">
        <!-- Centramos el texto y el contenedor,mx-auto para centrar o no-->
        <!-- <h3 class="hero-subtitle text-black">Need it now?</h3> -->
        <h1 class="hero-title text-white">Services</h1>
        <p class="hero-subtitle text-white">Products Designed for Impact</p>
        <!-- Centramos los botones -->
        <!-- <div class="d-flex justify-content-center gap-3 flex-wrap"> 
                    <a href="/views/contact.php" class="btn btn-primary btn-lg text-white">Request a Delivery</a>

                </div> -->
      </div>
    </div>
  </div>
</section>



<!-- Section 1 -->

<section class="py-5 bg-light">
  <div class="container">

    <!-- Servicio 1 -->
    <div class="row align-items-center mb-5">
      <div class="col-md-6">
        <img src="<?php echo BASE_URL; ?>/images/general/index/corporate.png" alt="Custom Signage"
          class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6 text-start">
        <h2 class="fw-bold text-black display-5">Corporate & Hospitality</h2>
        <p class="lead text-muted">We create professional engraved pieces for offices, hotels, and corporate spaces.
          From signage and branding displays to recognition plaques, our designs elevate your brand’s image with
          precision and style.</p>
        <!-- Botón para abrir modal -->
        <!-- <button class="btn btn-gold mt-3" data-bs-toggle="modal" data-bs-target="#customSignageModal">
          Learn More
        </button> -->
      </div>
    </div>

    <!-- Corporate Gifts -->
    <div class="row align-items-center mb-5 flex-md-row-reverse">
      <div class="col-md-6">
        <img src="<?php echo BASE_URL; ?>/images/general/index/singage.png" alt="Corporate Gifts"
          class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6 text-start">
        <h2 class="fw-bold text-black display-5">Signage</h2>
        <p class="lead text-muted">Perfect for employee recognition, client appreciation, or corporate events, our
          engraved gifts combine
          functionality with a touch of elegance. Personalize each piece with names, logos, or special messages.</p>
        <!-- <button class="btn btn-gold mt-3" data-bs-toggle="modal" data-bs-target="#giftsModal">Learn More</button> -->
      </div>
    </div>

    <!-- Wedding Decor -->
    <div class="row align-items-center mb-5">
      <div class="col-md-6">
        <img src="<?php echo BASE_URL; ?>/images/general/index/decoration.png" alt="Wedding Decor"
          class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6 text-start">
        <h2 class="fw-bold text-black display-5">Wedding Decor & Events</h2>
        <p class="lead text-muted">From custom signage and table decor to engraved keepsakes, we design unique pieces
          that make weddings and events truly memorable. Every detail is crafted to match your style and theme.</p>
        <!-- <button class="btn btn-gold mt-3" data-bs-toggle="modal" data-bs-target="#weddingModal">Learn More</button> -->
      </div>
    </div>

    <!-- Trophies & Awards -->
    <div class="row align-items-center mb-5 flex-md-row-reverse">
      <div class="col-md-6">
        <img src="<?php echo BASE_URL; ?>/images/general/index/sports.png" alt="Trophies & Awards"
          class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6 text-start">
        <h2 class="fw-bold text-black display-5">Sports</h2>
        <p class="lead text-muted">We design personalized trophies, medals, and recognition plaques for teams,
          tournaments, and athletic events. Durable materials and fine engraving ensure every award stands out.</p>
        <!-- <button class="btn btn-gold mt-3" data-bs-toggle="modal" data-bs-target="#trophiesModal">Learn More</button> -->
      </div>
    </div>

    <!-- Home Decor & Lifestyle -->
    <div class="row align-items-center mb-5">
      <div class="col-md-6">
        <img src="<?php echo BASE_URL; ?>/images/general/index/decor.png" alt="Wedding Decor"
          class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6 text-start">
        <h2 class="fw-bold text-black display-5">Home Decor & Lifestyle</h2>
        <p class="lead text-muted">Discover decorative and functional items that enhance your home or workspace,
          from personalized signs and wall art to engraved accessories that reflect your lifestyle and personality.</p>
        <!-- <button class="btn btn-gold mt-3" data-bs-toggle="modal" data-bs-target="#weddingModal">Learn More</button> -->
      </div>
    </div>

    <!-- Restaurants -->
    <div class="row align-items-center mb-5 flex-md-row-reverse">
      <div class="col-md-6">
        <img src="<?php echo BASE_URL; ?>/images/general/index/restaurants.png" alt="Trophies & Awards"
          class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6 text-start">
        <h2 class="fw-bold text-black display-5">Restaurants</h2>
        <p class="lead text-muted">We craft custom menus, signage, coasters, and branded accessories for restaurants,
          cafés, and bars.
          Every detail enhances presentation and reinforces your identity with a professional touch.</p>
        <!-- <button class="btn btn-gold mt-3" data-bs-toggle="modal" data-bs-target="#trophiesModal">Learn More</button> -->
      </div>
    </div>



  </div>
</section>


<!-- Section 2 -->

<section class="section-wrapper bg-black text-white text-center position-relative">
  <div class="container">
    <h2 class="display-4 fw-bold">Every Detail, Perfected</h2>
    <p class="lead text-white mt-3">
      We use advanced CO₂ and diode laser technology to craft products that combine precision, durability, and beauty.
      It’s not just design, it’s an experience.
    </p>

    <!-- Imagen con overlay -->
    <div class="position-relative d-inline-block">
      <img src="<?php echo BASE_URL; ?>/images/general/index/laserP.JPG" alt="Laser Technology"
        class="img-fluid mt-4 rounded">

      <!-- Punto rojo láser -->
      <div class="laser-dot"></div>
    </div>
  </div>
</section>

<style>
  .laser-dot {
    position: absolute;
    bottom: 30%;
    /* ajusta la posición vertical */
    left: 50%;
    /* ajusta la posición horizontal */
    width: 14px;
    height: 14px;
    background-color: red;
    border-radius: 50%;
    box-shadow: 0 0 10px 4px rgba(255, 0, 0, 0.6);
    animation: pulse 1.2s infinite;
  }

  /* Animación del láser */
  @keyframes pulse {
    0% {
      transform: scale(1);
      opacity: 1;
    }

    50% {
      transform: scale(1.5);
      opacity: 0.6;
    }

    100% {
      transform: scale(1);
      opacity: 1;
    }
  }
</style>



<!-- Section -->

<section class="section-wrapper bg-white text-center">
  <div class="container">
    <h2 class="display-4 fw-bold mb-5">How It Works</h2>
    <div class="row g-4">

      <!-- Step 1 -->
      <div class="col-md-4">
        <div class="p-4 h-100 shadow-sm rounded">
          <div class="mb-3">
            <i class="bi bi-lightbulb-fill" style="font-size: 2.5rem; color: #daa520;"></i>
          </div>
          <h3 class="fw-bold">1. Share Your Idea</h3>
          <p class="text-muted">Tell us your vision, big or small.</p>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="col-md-4">
        <div class="p-4 h-100 shadow-sm rounded">
          <div class="mb-3">
            <i class="bi bi-pencil-square " style="font-size: 2.5rem; color: #daa520;"></i>
          </div>
          <h3 class="fw-bold">2. We Design</h3>
          <p class="text-muted">Our team crafts modern, premium concepts.</p>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="col-md-4">
        <div class="p-4 h-100 shadow-sm rounded">
          <div class="mb-3">
            <i class="bi bi-gear-fill " style="font-size: 2.5rem; color: #daa520;"></i>
          </div>
          <h3 class="fw-bold">3. We Create</h3>
          <p class="text-muted">Delivered with precision and care, ready to impress.</p>
        </div>
      </div>

    </div>
  </div>
</section>



<section class="section-wrapper bg-light text-center">
  <div class="container">
    <h2 class="display-5 fw-bold">Ready to Create Something Unique?</h2>
    <p class="lead text-muted mb-4">Let’s transform your ideas into extraordinary designs.</p>
    <a href="contact.html" class="btn btn-gold btn-lg rounded-pill">Get Started</a>
  </div>
</section>






<!-- Modal -->

<div class="modal fade" id="customSignageModal" tabindex="-1" aria-labelledby="customSignageModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="customSignageModalLabel">Custom Signage</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <!-- Imagen dentro del modal -->
        <img src="<?php echo BASE_URL; ?>/images/general/index/corporate.png" alt="Custom Signage Detail"
          class="img-fluid rounded mb-3">
        <p>Our custom signage is designed with precision and style, using modern laser technology. Perfect for
          businesses, weddings, or personalized gifts.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Corporate Gifts Modal -->
<div class="modal fade" id="giftsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Corporate Gifts</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Our premium corporate gifts are designed to leave a lasting impression. From personalized drinkware to unique
          engraved sets, every item blends professionalism with creativity.</p>
      </div>
    </div>
  </div>
</div>

<!-- Wedding Decor Modal -->
<div class="modal fade" id="weddingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Wedding Decor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>We bring elegance and personality to your special day with custom décor designed to capture your love story.
          From engraved signs to unique centerpieces, every detail is tailored for you.</p>
      </div>
    </div>
  </div>
</div>

<!-- Trophies Modal -->
<div class="modal fade" id="trophiesModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Trophies & Awards</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Celebrate milestones and achievements with personalized trophies and awards. Each design is crafted with
          precision and premium finishes to honor every success in style.</p>
      </div>
    </div>
  </div>
</div>









<!-- Footer -->
<?php
include '../includes/footer.php';
?>