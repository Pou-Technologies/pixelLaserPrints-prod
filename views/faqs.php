
    <!-- Header -->
    <?php
    $pageTitle = "Faqs"; // Define el título de la página
    include '../includes/header.php';
    ?>


<section class="hero" 
    style="
        background-image: url('/images/general/bg.png'); 
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat; 
        min-height: 100vh; 
        padding-top: 150px; /* Separación superior */
    ">
    <div class="container h-100 d-flex flex-column justify-content-center align-items-center text-center py-5">
        <!-- Hero Section -->
        <section class="text-center">
            <div class="container">
            <!-- FAQ Header -->
                <header class="faq-header">
                    <h1>FAQs</h1>
                    <p>Find answers to our most commonly asked questions below.</p>
                </header>

                <!-- FAQ Section -->
                <div class="container my-5">
                    <div class="row g-4">
                        <!-- FAQ Card 1 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="faq-card p-4">
                                <h5 class="faq-card-title text-secondary">What services do you offer?</h5>
                                <p class="faq-card-text">We offer a variety of services, including web design, digital marketing, and IT support. Contact us to learn more!</p>
                            </div>
                        </div>
                        <!-- FAQ Card 2 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="faq-card p-4">
                                <h5 class="faq-card-title text-secondary">How can I contact support?</h5>
                                <p class="faq-card-text">You can reach us 24/7 via email or phone. Our team is always ready to assist you with any issues or inquiries.</p>
                            </div>
                        </div>
                        <!-- FAQ Card 3 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="faq-card p-4">
                                <h5 class="faq-card-title text-secondary">Do you provide refunds?</h5>
                                <p class="faq-card-text">Refunds are provided on a case-by-case basis. Please review our refund policy or contact us for more information.</p>
                            </div>
                        </div>
                        <!-- FAQ Card 4 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="faq-card p-4">
                                <h5 class="faq-card-title text-secondary">How do I track my project?</h5>
                                <p class="faq-card-text">We provide a project dashboard for you to track progress in real-time. Updates are shared weekly.</p>
                            </div>
                        </div>
                        <!-- FAQ Card 5 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="faq-card p-4">
                                <h5 class="faq-card-title text-secondary">What payment methods do you accept?</h5>
                                <p class="faq-card-text">We accept all major credit cards, PayPal, and bank transfers for your convenience.</p>
                            </div>
                        </div>
                        <!-- FAQ Card 6 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="faq-card p-4">
                                <h5 class="faq-card-title text-secondary">Can I request a custom service?</h5>
                                <p class="faq-card-text">Absolutely! Contact us with your requirements, and we’ll work with you to create a tailored solution.</p>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </section>

    </div>    


</section>       


    <!-- Footer -->
    <?php
    include '../includes/footer.php';
    ?>