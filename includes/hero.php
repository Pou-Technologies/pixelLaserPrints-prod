<?php
require_once __DIR__ . '/PortalApiClient.php';

// Fallback default values
$heroTitle = "Laser Precision Meets Artistry";
$heroSubtitle = "Transform your ideas into reality with our cutting-edge laser engraving.";
$heroImage = "";
$heroPromotionalText = "";

$heroResponse = PortalApiClient::getHeroContent();

if (!empty($heroResponse['success']) && !empty($heroResponse['data'])) {
    $data = $heroResponse['data'];
    // Handle possible nested data key from Laravel API responses (e.g. ['data' => [...]])
    $content = isset($data['data']) && is_array($data['data']) ? $data['data'] : $data;

    if (!empty($content['hero_title'])) {
        $heroTitle = $content['hero_title'];
    }
    if (!empty($content['hero_subtitle'])) {
        $heroSubtitle = $content['hero_subtitle'];
    }
    if (!empty($content['hero_image'])) {
        $heroImage = $content['hero_image'];
    }
    if (!empty($content['promotional_text'])) {
        $heroPromotionalText = $content['promotional_text'];
    } elseif (!empty($content['promo_text'])) {
        $heroPromotionalText = $content['promo_text'];
    }
}

$heroStyle = 'min-height: 100vh;';
if (!empty($heroImage)) {
    $heroStyle .= ' background: url(\'' . htmlspecialchars($heroImage) . '\') no-repeat center center/cover;';
}
?>
<section class="hero d-flex align-items-center justify-content-center position-relative" style="<?php echo $heroStyle; ?>">
    <div class="hero-overlay"></div>
    <div class="container text-white position-relative z-1">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9 text-center">
                <?php if (!empty($heroPromotionalText)): ?>
                <div class="d-inline-flex align-items-center rounded-pill px-4 py-2 mb-4 hero-promo-badge">
                    <i class="bi bi-stars me-2"></i>
                    <span class="small fw-semibold"><?php echo htmlspecialchars($heroPromotionalText); ?></span>
                </div>
                <?php else: ?>
                <div class="d-inline-flex align-items-center rounded-pill px-4 py-2 mb-4 hero-promo-badge">
                    <i class="bi bi-gem me-2"></i>
                    <span class="small fw-semibold text-uppercase tracking-wide">Custom Engraving &amp; Design Studio in PEI</span>
                </div>
                <?php endif; ?>
                <h1 class="py-2 hero-title text-white mx-auto"><?php echo htmlspecialchars($heroTitle); ?></h1>
                <p class="hero-description text-white-50 mx-auto mb-5"><?php echo htmlspecialchars($heroSubtitle); ?></p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="<?php echo BASE_URL; ?>/views/contact.php" class="btn btn-gold btn-lg rounded-pill px-5 py-3 fw-semibold shadow">
                        <i class="bi bi-bag-check me-2"></i>Get a Quote
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/services.php"
                        class="btn text-white btn-lg btn-custom-light rounded-pill px-5 py-3 fw-semibold">
                        Explore Our Work <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>