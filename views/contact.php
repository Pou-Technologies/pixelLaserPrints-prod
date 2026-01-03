<?php
$pageTitle = "Contact"; // Define el título de la página
include '../includes/header.php';
?>
<!-- Recaptcha -->

<script src="https://www.google.com/recaptcha/api.js?render=6Lf2feQrAAAAAAQ_z9gZTzIpQ3ONb6C6CDs1aQMx"></script>



<section class="py-5 contact-hero-section"
    style="background-image: url('<?php echo BASE_URL; ?>/images/general/contactBG.svg');">
    <div class="container h-100 d-flex flex-column justify-content-center py-5">
        <section class="contact-hero text-center">
            <div class="container">
                <h1 class="mb-4 text-white fw-bold">Contact Us</h1>
                <p class="lead text-white">We'd love to hear from you! Get in touch with any questions, comments, or
                    inquiries.</p>
            </div>
        </section>
        <section class="contact-section text-center">
            <div class="container">
                <main class="py-5 w-100 d-flex justify-content-center">
                    <div class="col-lg-8 col-md-10 col-sm-12">
                        <div class="contact-form-placeholder">
                            <?php require_once dirname(__DIR__) . '/includes/contact-form.php'; ?>
                        </div>
                    </div>
                </main>
            </div>
        </section>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 p-4 shadow-sm rounded-4 text-center">
                    <i class="fas fa-phone-alt fa-2x color-font mb-3"></i>
                    <h5 class="fw-bold">Phone and Email</h5>
                    <p class="mb-1"><?php echo COMPANY_PHONE; ?></p>
                    <p><?php echo COMPANY_EMAIL; ?></p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 p-4 shadow-sm rounded-4 text-center">
                    <i class="fas fa-clock fa-2x color-font mb-3"></i>
                    <h5 class="fw-bold">Hours</h5>
                    <p class="mb-1">Monday - Friday: 7am - 6pm</p>
                    <p class="mb-1">Saturday: 7am -2pm</p>
                    <p class="">Sunday: Closed</p>
                    <p> We are also flexible and can accommodate custom pickup or delivery times upon request</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 p-4 shadow-sm rounded-4 text-center">
                    <i class="fas fa-share-alt fa-2x color-font mb-3"></i>
                    <h5 class="fw-bold">Follow Us</h5>
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <a href="<?php echo SOCIAL_FACEBOOK; ?>" class="btn btn-gold rounded-circle"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="<?php echo SOCIAL_TIKTOK; ?>" class="btn btn-gold rounded-circle"><i
                                class="fab fa-tiktok"></i></a>
                        <a href="<?php echo SOCIAL_INSTAGRAM; ?>" class="btn btn-gold rounded-circle"><i
                                class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- FAQS -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Frequently Asked Questions</h2>
            <p class="text-secondary">Find answers to the most common questions.</p>
        </div>
        <div class="accordion" id="faqAccordion">
            <!-- Question 1 -->
            <div class="accordion-item rounded-3 mb-3 border-0 shadow-sm">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button rounded-3 collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        What products do you customize?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        We offer custom engraving and cutting on tumblers, signs, wedding décor, trophies, corporate
                        gifts, and home décor.
                    </div>
                </div>
            </div>
            <!-- Question 2 -->
            <div class="accordion-item rounded-3 mb-3 border-0 shadow-sm">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button rounded-3 collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        What materials can you engrave?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        We work with wood, acrylic, glass, leather, and metals (depending on the type of laser used).
                    </div>
                </div>
            </div>
            <!-- Question 3 -->
            <div class="accordion-item rounded-3 mb-3 border-0 shadow-sm">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button rounded-3 collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        How long does it take to complete an order?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Small items (like tumblers or keychains) are usually ready within 24–48 hours. Larger or custom
                        projects may take 5–10 business days.
                    </div>
                </div>
            </div>
            <!-- Question 4 -->
            <div class="accordion-item rounded-3 mb-3 border-0 shadow-sm">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button rounded-3 collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Do you offer delivery or shipping?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes, we offer local pickup in Charlottetown, local delivery upon request, and shipping across
                        Canada.
                    </div>
                </div>
            </div>
            <!-- Question 5 -->
            <div class="accordion-item rounded-3 mb-3 border-0 shadow-sm">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button rounded-3 collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        Do you accept custom designs from customers?
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Absolutely. Clients can send us their own design, or we can create one together.
                    </div>
                </div>
            </div>
            <!--Question 6  -->
            <div class="accordion-item rounded-3 mb-3 border-0 shadow-sm">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button rounded-3 collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        What payment methods do you accept?
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Cash, e-transfer, and credit card (online payments coming soon).
                    </div>
                </div>
            </div>
            <!-- Question 7 -->
            <div class="accordion-item rounded-3 mb-3 border-0 shadow-sm">
                <h2 class="accordion-header" id="headingSeven">
                    <button class="accordion-button rounded-3 collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                        Can I get a quote before placing an order?
                    </button>
                </h2>
                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes, you can request a free quote through our contact form, email, or social media.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Our Location</h2>
            <p class="text-secondary">Come visit us. We're here for you.</p>
        </div>
        <div class="card p-3 shadow-sm rounded-4">
            <div class="map-container rounded-3 overflow-hidden">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2758.68520240983!2d-63.12811328699752!3d46.25648558010647!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4b5e52b9f96af999%3A0xc2b098e321249023!2s180%20Belvedere%20Ave%2C%20Charlottetown%2C%20PE%20C1A%202Z1!5e0!3m2!1sen!2sca!4v1758665617273!5m2!1sen!2sca"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</section>













<?php include '../includes/footer.php'; ?>