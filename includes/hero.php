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
<section class="hero d-flex align-items-center" style="<?php echo $heroStyle; ?>">
    <div class="container text-white">
        <div class="row">
            <div class="col-md-8 col-lg-6 text-left">
                <?php if (!empty($heroPromotionalText)): ?>
                <div class="d-inline-flex align-items-center rounded-pill px-4 py-2 mb-3" style="border: 2px solid #D4AF37; color: #D4AF37; background: rgba(0,0,0,0.5);">
                    <i class="bi bi-stars me-2"></i>
                    <span class="text-sm font-weight-medium"><?php echo htmlspecialchars($heroPromotionalText); ?></span>
                </div>
                <?php endif; ?>
                <h1 class="py-3 hero-title text-white"><?php echo htmlspecialchars($heroTitle); ?></h1>
                <p class="hero-description text-white"><?php echo htmlspecialchars($heroSubtitle); ?></p>
                <div class="d-flex justify-content-start gap-3 flex-wrap">
                    <a href="<?php echo BASE_URL; ?>/views/contact.php" class="btn btn-gold btn-lg">
                        <i class="bi bi-bag me-2"></i>Get a quote
                    </a>
                    <a href="<?php echo BASE_URL; ?>/views/services.php"
                        class="btn text-white btn-lg btn-custom-light px-4">Explore Our Work</a>
                </div>
            </div>
        </div>
    </div>
</section>