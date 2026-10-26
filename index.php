<!-- Header -->
<?php
$pageTitle = "Pixel Laser Prints - Home"; // Define el título de la página
include 'includes/header.php';
?>

<!-- Hero -->
<?php
include 'includes/hero.php';
?>

<!-- SECTION 1: What We Deliver -->
<section class="modern-section bg-white" id="what-we-deliver">
  <div class="container">
    <div class="text-center mx-auto mb-5" style="max-width: 780px;">
      <span class="section-badge mb-2">Why Choose Us</span>
      <h2 class="section-heading fw-bold text-black mb-3">Crafting Personalized Designs with Precision</h2>
      <p class="text-secondary fs-6 mb-0">
        At Pixel Laser Prints, we combine creativity, craftsmanship, and cutting-edge technology to
        transform everyday items into extraordinary keepsakes. Whether it’s a custom sign for your business, décor for
        your wedding, or a personalized gift, our mission is to deliver products that are as unique as you are.
      </p>
    </div>

    <div class="row g-4">
      <!-- Card 1 -->
      <div class="col-12 col-md-4">
        <div class="card h-100 border-0 text-white feature-card-bg shadow-sm"
          style="background-image: url('<?php echo BASE_URL; ?>/images/general/index/modernDesigns.jpg');">
          <div class="card-body d-flex flex-column justify-content-end text-start p-4 p-lg-5">
            <div class="feature-icon-badge mb-3">
              <i class="bi bi-palette2"></i>
            </div>
            <h4 class="fw-bold mb-2">Modern Designs</h4>
            <p class="small text-white-50 mb-0">Sleek, stylish, and tailored to your vision.</p>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-12 col-md-4">
        <div class="card h-100 border-0 text-white feature-card-bg shadow-sm"
          style="background-image: url('<?php echo BASE_URL; ?>/images/general/index/qr.JPG');">
          <div class="card-body d-flex flex-column justify-content-end text-start p-4 p-lg-5">
            <div class="feature-icon-badge mb-3">
              <i class="bi bi-award"></i>
            </div>
            <h4 class="fw-bold mb-2">Premium Finish</h4>
            <p class="small text-white-50 mb-0">Attention to detail that makes every piece stand out.</p>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-12 col-md-4">
        <div class="card h-100 border-0 text-white feature-card-bg shadow-sm"
          style="background-image: url('<?php echo BASE_URL; ?>/images/general/index/laserP.JPG');">
          <div class="card-body d-flex flex-column justify-content-end text-start p-4 p-lg-5">
            <div class="feature-icon-badge mb-3">
              <i class="bi bi-cpu"></i>
            </div>
            <h4 class="fw-bold mb-2">Advanced Laser Technology</h4>
            <p class="small text-white-50 mb-0">Precision engraving on wood, acrylic, glass &amp; metal.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 2: Our Collections -->
<section class="modern-section bg-light-subtle">
  <div class="container">
    <div class="text-center mx-auto mb-5" style="max-width: 720px;">
      <span class="section-badge mb-2">Our Portfolio</span>
      <h2 class="section-heading fw-bold text-black mb-3">Explore Our Collections</h2>
      <p class="text-secondary fs-6 mb-0">
        Discover personalized products designed to celebrate moments, elevate brands, and make
        lasting impressions.
      </p>
    </div>

    <div class="row g-4">
      <!-- Card 1 -->
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal"
          data-title="Corporate & Hospitality"
          data-description="Elegant engraved solutions for businesses, offices, and hotels."
          data-image="<?php echo BASE_URL; ?>/images/general/index/corporate.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/corporate.png" alt="Corporate & Hospitality">
          <div class="overlay">
            <span class="collection-tag">Collection</span>
            <h5 class="text-white mb-1">Corporate &amp; Hospitality</h5>
            <span class="collection-cta">View Details <i class="bi bi-arrow-up-right"></i></span>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal" data-title="Signage"
          data-description="Custom engraved signs for offices, restaurants, and events."
          data-image="<?php echo BASE_URL; ?>/images/general/index/singage.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/singage.png" alt="Signage">
          <div class="overlay">
            <span class="collection-tag">Collection</span>
            <h5 class="text-white mb-1">Signage</h5>
            <span class="collection-cta">View Details <i class="bi bi-arrow-up-right"></i></span>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal"
          data-title="Wedding Decor & Events" data-description="Add elegance and personalization to your special day."
          data-image="<?php echo BASE_URL; ?>/images/general/index/decoration.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/decoration.png" alt="Wedding Décor & Events">
          <div class="overlay">
            <span class="collection-tag">Collection</span>
            <h5 class="text-white mb-1">Wedding Decor &amp; Events</h5>
            <span class="collection-cta">View Details <i class="bi bi-arrow-up-right"></i></span>
          </div>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal" data-title="Sports"
          data-description="Celebrate achievements with modern engraved designs."
          data-image="<?php echo BASE_URL; ?>/images/general/index/sports.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/sports.png" alt="Sports">
          <div class="overlay">
            <span class="collection-tag">Collection</span>
            <h5 class="text-white mb-1">Sports</h5>
            <span class="collection-cta">View Details <i class="bi bi-arrow-up-right"></i></span>
          </div>
        </div>
      </div>

      <!-- Card 5 -->
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal"
          data-title="Home Decor & Lifestyle" data-description="Personalized items that bring style into your home."
          data-image="<?php echo BASE_URL; ?>/images/general/index/decor.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/decor.png" alt="Home Decor & Lifestyle">
          <div class="overlay">
            <span class="collection-tag">Collection</span>
            <h5 class="text-white mb-1">Home Decor &amp; Lifestyle</h5>
            <span class="collection-cta">View Details <i class="bi bi-arrow-up-right"></i></span>
          </div>
        </div>
      </div>

      <!-- Card 6 -->
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal" data-title="Restaurants"
          data-description="Personalized items for the food and hospitality industry."
          data-image="<?php echo BASE_URL; ?>/images/general/index/restaurants.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/restaurants.png" alt="Restaurants">
          <div class="overlay">
            <span class="collection-tag">Collection</span>
            <h5 class="text-white mb-1">Restaurants</h5>
            <span class="collection-cta">View Details <i class="bi bi-arrow-up-right"></i></span>
          </div>
        </div>
      </div>

      <!-- Card 7 -->
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal" data-title="NFC"
          data-description="Smart, connected products for the modern world."
          data-image="<?php echo BASE_URL; ?>/images/general/index/nfc.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/nfc.png" alt="NFC">
          <div class="overlay">
            <span class="collection-tag">Collection</span>
            <h5 class="text-white mb-1">NFC</h5>
            <span class="collection-cta">View Details <i class="bi bi-arrow-up-right"></i></span>
          </div>
        </div>
      </div>

      <!-- Card 8 -->
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="category-card" data-bs-toggle="modal" data-bs-target="#cardModal" data-title="Local Stores"
          data-description="Personalized products made locally for local businesses."
          data-image="<?php echo BASE_URL; ?>/images/general/index/localIndex.png">
          <img src="<?php echo BASE_URL; ?>/images/general/index/localIndex.png" alt="Local Stores">
          <div class="overlay">
            <span class="collection-tag">Collection</span>
            <h5 class="text-white mb-1">Local Stores</h5>
            <span class="collection-cta">View Details <i class="bi bi-arrow-up-right"></i></span>
          </div>
        </div>
      </div>
    </div>

    <div class="pt-5 text-center">
      <a href="<?php echo BASE_URL; ?>/views/catalog.php" class="btn btn-gold btn-lg rounded-pill px-5 py-3 fw-semibold shadow-sm">
        Explore Our Catalog <i class="bi bi-arrow-right ms-2"></i>
      </a>
    </div>
  </div>
</section>

<!-- Collection Modal -->
<div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header border-0 px-4 pt-4 pb-2">
        <h4 class="modal-title fw-bold text-black" id="cardModalLabel"></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center px-4 pb-4">
        <img id="cardModalImage" src="" class="img-fluid rounded-3 mb-3 shadow-sm" style="max-height: 450px; object-fit: cover; width: 100%;" alt="">
        <p id="cardModalDescription" class="text-secondary fs-6 mb-3"></p>
        <a href="<?php echo BASE_URL; ?>/views/catalog.php" class="btn btn-gold rounded-pill px-4">Browse Full Catalog</a>
      </div>
    </div>
  </div>
</div>

<script>
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

<!-- SECTION 3: Our Commitment to Every Project (Full Width Black & Gold Gradient) -->
<section class="modern-section commitment-fullwidth-section text-white position-relative overflow-hidden">
  <div class="container-fluid px-4 px-lg-5 py-lg-3 position-relative z-1" style="max-width: 1500px;">
    <div class="text-center mx-auto mb-5" style="max-width: 740px;">
      <span class="section-badge section-badge-dark mb-2">Craftsmanship</span>
      <h2 class="section-heading fw-bold text-white mb-3">Our Commitment to Every Project</h2>
      <p class="text-white-50 fs-5 mb-0">Personalized creations crafted with precision and care.</p>
    </div>

    <div class="commitment-showcase-dark p-4 p-lg-5 rounded-4">
      <div class="row align-items-center g-4 g-lg-5">
        <div class="col-lg-6">
          <div class="position-relative commitment-img-wrapper">
            <img src="<?php echo BASE_URL; ?>/images/general/index/aztecaIndex.JPG" class="img-fluid rounded-4 shadow-lg"
              alt="Azteca restaurant in Charlottetown, PEI">
            <div class="commitment-caption-badge">
              <i class="bi bi-geo-alt-fill text-warning me-1"></i>
              <span>Azteca Restaurant — Charlottetown, PEI</span>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <span class="d-inline-flex align-items-center rounded-pill px-3 py-2 mb-3 hero-promo-badge small fw-semibold">
            <i class="bi bi-heart-fill text-warning me-2"></i>Dedicated Attention
          </span>
          <h3 class="fw-bold mb-3 text-white display-6">We Care About Your Product</h3>
          <p class="text-white-50 mb-3">
            At Pixel Laser Prints, every project is special.
            From the first idea to the final product, we put our full attention,
            creativity, and dedication into every step of the process.
          </p>
          <p class="text-white-50 mb-3">
            Whether it’s signage for a business, décor for a wedding,
            or a personalized gift, we collaborate closely with our
            clients to ensure their vision is brought to life with
            precision and care.
          </p>
          <p class="text-white-50 mb-4">
            Every detail matters—from material selection to
            engraving accuracy—because we believe the result should not only meet expectations but create a lasting
            impression.
          </p>
          <div class="p-4 rounded-3 commitment-quote-box">
            <p class="fw-semibold text-white mb-0">
              “For us, it’s not just about making products—it’s about turning ideas into meaningful designs that truly represent our clients.”
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 4: Testimonials -->
<section class="modern-section testimonials-modern-section position-relative">
  <div class="container position-relative z-1">
    <div class="text-center mx-auto mb-5" style="max-width: 680px;">
      <span class="section-badge mb-2">Testimonials</span>
      <h2 class="section-heading fw-bold text-black mb-3">What Our Clients Say</h2>
      <p class="text-secondary fs-6 mb-0">Real experiences from people who trusted Pixel Laser Prints to create something unique.</p>
    </div>

    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner py-2">

        <!-- Testimonial 1 -->
        <div class="carousel-item active">
          <div class="card testimonial-card border-0 mx-auto" style="max-width: 720px;">
            <div class="card-body text-center p-4 p-md-5">
              <div class="testimonial-quote-icon mb-3">
                <i class="bi bi-quote"></i>
              </div>
              <div class="stars mb-3">
                ★★★★★
              </div>
              <p class="text-dark fs-5 fst-italic mb-4">“The custom signage we ordered was stunning and delivered quickly. Our
                office space feels so much more professional.”</p>
              <h6 class="fw-bold mb-1 text-black">Sarah M.</h6>
              <small class="text-secondary"><i class="bi bi-geo-alt me-1"></i>Charlottetown, PEI</small>
            </div>
          </div>
        </div>

        <!-- Testimonial 2 -->
        <div class="carousel-item">
          <div class="card testimonial-card border-0 mx-auto" style="max-width: 720px;">
            <div class="card-body text-center p-4 p-md-5">
              <div class="testimonial-quote-icon mb-3">
                <i class="bi bi-quote"></i>
              </div>
              <div class="stars mb-3">
                ★★★★★
              </div>
              <p class="text-dark fs-5 fst-italic mb-4">“Pixel created beautiful wedding décor for us. Every detail was perfect —
                we couldn’t have asked for more.”</p>
              <h6 class="fw-bold mb-1 text-black">James &amp; Emily</h6>
              <small class="text-secondary"><i class="bi bi-geo-alt me-1"></i>Summerside, PEI</small>
            </div>
          </div>
        </div>

        <!-- Testimonial 3 -->
        <div class="carousel-item">
          <div class="card testimonial-card border-0 mx-auto" style="max-width: 720px;">
            <div class="card-body text-center p-4 p-md-5">
              <div class="testimonial-quote-icon mb-3">
                <i class="bi bi-quote"></i>
              </div>
              <div class="stars mb-3">
                ★★★★★
              </div>
              <p class="text-dark fs-5 fst-italic mb-4">“The engraved tumblers we gifted to our team were a huge hit. High
                quality and very professional.”</p>
              <h6 class="fw-bold mb-1 text-black">Michael R.</h6>
              <small class="text-secondary"><i class="bi bi-briefcase me-1"></i>Business Owner</small>
            </div>
          </div>
        </div>

      </div>

      <!-- Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev" aria-label="Previous testimonial">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next" aria-label="Next testimonial">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </div>
</section>

<!-- SECTION 5: Brands We've Worked With -->
<section class="modern-section bg-white border-top">
  <div class="container text-center">
    <span class="section-badge mb-2">Trusted Partners</span>
    <h2 class="section-heading fw-bold text-black mb-3">Brands We’ve Worked With</h2>
    <p class="text-secondary mb-5 mx-auto" style="max-width: 640px;">
      We’re proud to have collaborated with businesses and organizations that trust our work.
    </p>

    <div class="row justify-content-center align-items-center g-4">
      <!-- Brand 1 -->
      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <div class="p-4 border rounded-4 shadow-sm brand-box d-flex align-items-center justify-content-center">
          <img src="<?php echo BASE_URL; ?>/images/general/clients/rodd.png" class="img-fluid" alt="Rodd Hotels & Resorts">
        </div>
      </div>
      <!-- Brand 2 -->
      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <div class="p-4 border rounded-4 shadow-sm brand-box d-flex align-items-center justify-content-center">
          <img src="<?php echo BASE_URL; ?>/images/general/clients/haviland.png" class="img-fluid" alt="The Haviland">
        </div>
      </div>
      <!-- Brand 3 -->
      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <div class="p-4 border rounded-4 shadow-sm brand-box d-flex align-items-center justify-content-center">
          <img src="<?php echo BASE_URL; ?>/images/general/clients/connectors.png" class="img-fluid" alt="Connectors">
        </div>
      </div>
      <!-- Brand 4 -->
      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <div class="p-4 border rounded-4 shadow-sm brand-box d-flex align-items-center justify-content-center">
          <img src="<?php echo BASE_URL; ?>/images/general/clients/azteca.png" class="img-fluid" alt="Azteca">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 6: Call to Action (Full Width Black & Gold Gradient) -->
<section class="cta-fullwidth-section text-center text-white position-relative overflow-hidden">
  <div class="container py-5 position-relative z-1">
    <div class="mx-auto py-3" style="max-width: 780px;">
      <span class="section-badge section-badge-dark mb-3">Ready to Start?</span>
      <h2 class="fw-bold mb-3 display-5 text-white">Bring Your Ideas to Life with Pixel Laser Prints</h2>
      <p class="mb-4 text-white-50 fs-5">
        Whether it’s a personalized gift, wedding décor, or custom signage, we’re here
        to create something truly unique for you.
      </p>
      <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
        <a href="tel:<?php echo COMPANY_PHONE_TEL; ?>" class="btn btn-lg btn-gold rounded-pill px-5 py-3 fw-semibold shadow">
          <i class="bi bi-telephone-fill me-2"></i>Call Us
        </a>
        <a href="<?php echo BASE_URL; ?>/views/contact.php" class="btn btn-lg btn-custom-light rounded-pill px-5 py-3 fw-semibold">
          Contact Us Today <i class="bi bi-arrow-right ms-2"></i>
        </a>
      </div>
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
