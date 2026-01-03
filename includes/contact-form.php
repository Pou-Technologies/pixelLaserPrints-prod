<div class="contact-form-wrapper">
    <div class="card contact-form-card p-lg-5 p-4 rounded-4 shadow-lg border-0">
        <h2 class="text-center mb-4 text-black fw-bold">Tell us about your project or get a quote</h2>
        <p class="text-center text-secondary mb-5">
            Select the service you want and send us your question. We will contact you as soon as possible.
        </p>
        <form action="/includes/process_form.php" method="POST" id="contactForm" enctype="multipart/form-data"
            novalidate>
            <div class="row g-4">
                <div class="col-md-6">
                    <input type="text" class="form-control form-control-lg rounded-pill" id="firstName" name="firstName"
                        placeholder="Name" required>
                    <div class="invalid-feedback">
                        First Name is required.
                    </div>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control form-control-lg rounded-pill" id="lastName" name="lastName"
                        placeholder="Last Name" required>
                    <div class="invalid-feedback">
                        Last Name is required.
                    </div>
                </div>
                <div class="col-md-6">
                    <input type="email" class="form-control form-control-lg rounded-pill" id="email" name="email"
                        placeholder="Email" required>
                    <div class="invalid-feedback">
                        Email is required.
                    </div>
                </div>
                <div class="col-md-6">
                    <input type="tel" class="form-control form-control-lg rounded-pill" id="phone" name="phone"
                        placeholder="Phone" required>
                    <div class="invalid-feedback">
                        Phone is required.
                    </div>
                </div>
                <div class="col-12">
                    <select class="form-select form-select-lg rounded-pill" id="service" name="service" required>
                        <option value="" disabled selected>Select a service</option>
                        <option value="Corporate & Hospitality">Corporate & Hospitality</option>
                        <option value="Corporate Gifts">Corporate Gifts</option>
                        <option value="Wedding Decor & Events">Wedding Decor & Events</option>
                        <option value="Sports">Sports</option>
                        <option value="Home Decor & Lifestyle">Home Decor & Lifestyle</option>
                        <option value="Restaurants">Restaurants</option>
                        <option value="NFC">NFC</option>
                        <option value="Local Stores">Local Stores</option>
                        <option value="Quote">Quote</option>
                        <option value="Other">Other</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a service.
                    </div>
                </div>

                <div class="col-12" id="idSection" style="display: none;">
                    <input type="text" class="form-control form-control-lg rounded-pill" id="projectID" name="projectID"
                        placeholder="Reference ID (Optional)">
                </div>

                <div class="col-12">
                    <label for="attachment" class="form-label ms-3 text-secondary">Reference Image (Optional)</label>
                    <input class="form-control form-control-lg rounded-pill" type="file" id="attachment"
                        name="attachment" accept="image/*">
                </div>

                <div class="col-12">
                    <textarea class="form-control rounded-4" id="message" name="message" rows="5"
                        placeholder="How we can help you?" required></textarea>
                    <div class="invalid-feedback">
                        A message is required.
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div class="form-check text-center">
                        <input class="form-check-input" type="checkbox" id="acceptTerms" required>
                        <label class="form-check-label text-secondary" for="acceptTerms">
                            Accept the <a href="/privacy.php" class="text-decoration-underline" target="_blank">Terms
                                and Conditions</a>
                        </label>
                        <div class="invalid-feedback">
                            You must accept the terms and conditions.
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <button type="button" class="btn btn-gold btn-lg rounded-pill px-5" id="submitButton">
                        Send Message
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    // Tu Site Key real
    const siteKey = "6Lf2feQrAAAAAAQ_z9gZTzIpQ3ONb6C6CDs1aQMx";

    document.addEventListener('DOMContentLoaded', function () {
        const contactForm = document.getElementById('contactForm');
        const submitButton = document.getElementById('submitButton');
        const serviceSelect = document.getElementById('service');

        // Variables para el campo ID
        const idSection = document.getElementById('idSection');
        const projectIDInput = document.getElementById('projectID');

        // Lógica para mostrar/ocultar el campo ID
        serviceSelect.addEventListener('change', function () {
            if (this.value === 'Quote') {
                idSection.style.display = 'block';
            } else {
                idSection.style.display = 'none';
                projectIDInput.value = ''; // Limpia el valor al ocultar
            }
        });

        // Lógica de Validación de Bootstrap y Envío (reCAPTCHA)
        if (submitButton) {
            submitButton.addEventListener('click', function (e) {
                e.preventDefault();

                if (!contactForm.checkValidity()) {
                    contactForm.classList.add('was-validated');
                    return;
                }

                // Si es válido, ejecuta reCAPTCHA
                grecaptcha.ready(function () {
                    grecaptcha.execute(siteKey, { action: 'submit' }).then(function (token) {

                        let tokenInput = document.createElement('input');
                        tokenInput.type = 'hidden';
                        tokenInput.name = 'g-recaptcha-response';
                        tokenInput.value = token;

                        contactForm.appendChild(tokenInput);

                        // Envía el formulario
                        contactForm.submit();
                    });
                });
            });
        }
    });
</script>