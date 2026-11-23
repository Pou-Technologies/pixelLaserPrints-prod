<?php
$pageTitle = "3D Custom Architectural Plaque & Signage Configurator - Pixel Laser Prints";
$pageDescription = "Design your custom 3D laser-cut architectural house number plaque or business signage in real time. Crafted in Charlottetown, PEI, Canada.";
include '../includes/header.php';
?>

<!-- Official HelcimPay.js Script -->
<script type="text/javascript" src="https://secure.helcim.app/helcim-pay/services/start.js"></script>

<!-- Three.js ES Module Import Map -->
<script type="importmap">
{
  "imports": {
    "three": "https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js",
    "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.160.0/examples/jsm/"
  }
}
</script>

<style>
  .plaque-config-page {
    background: radial-gradient(circle at 15% 15%, #1e293b 0%, #0b0f19 60%, #060911 100%);
    min-height: 100vh;
    padding-top: 120px;
    padding-bottom: 80px;
    color: #f8fafc;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  .plaque-badge-pei {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.07);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #e2e8f0;
    padding: 6px 16px;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.4px;
    backdrop-filter: blur(8px);
  }

  .viewer-sticky-wrap {
    position: sticky;
    top: 100px;
  }

  .viewer-card {
    background: linear-gradient(145deg, rgba(15, 23, 42, 0.92), rgba(9, 13, 24, 0.96));
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.65);
  }

  #plaque-canvas-container {
    position: relative;
    width: 100%;
    height: 480px;
    background: radial-gradient(circle at 50% 42%, #263248 0%, #111827 65%, #090d16 100%);
    cursor: grab;
    overflow: hidden;
  }

  #plaque-canvas-container:active {
    cursor: grabbing;
  }

  .viewer-overlay-top {
    position: absolute;
    top: 16px;
    left: 16px;
    right: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    pointer-events: none;
    z-index: 5;
    flex-wrap: wrap;
    gap: 8px;
  }

  .viewer-overlay-top > * {
    pointer-events: auto;
  }

  .viewer-overlay-bottom {
    position: absolute;
    bottom: 16px;
    left: 16px;
    right: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    pointer-events: none;
    z-index: 5;
    flex-wrap: wrap;
    gap: 10px;
  }

  .viewer-overlay-bottom > * {
    pointer-events: auto;
  }

  .cam-btn-group {
    display: inline-flex;
    background: rgba(15, 23, 42, 0.82);
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 999px;
    padding: 4px;
    backdrop-filter: blur(10px);
    gap: 4px;
  }

  .cam-btn {
    background: transparent;
    border: none;
    color: #cbd5e1;
    font-size: 0.76rem;
    font-weight: 600;
    padding: 6px 13px;
    border-radius: 999px;
    transition: all 0.2s ease;
  }

  .cam-btn:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.08);
  }

  .cam-btn.active {
    background: #3b82f6;
    color: #ffffff;
    box-shadow: 0 2px 10px rgba(59, 130, 246, 0.45);
  }

  .assembly-switch-pill {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(15, 23, 42, 0.85);
    border: 1px solid rgba(255, 255, 255, 0.15);
    padding: 7px 15px;
    border-radius: 999px;
    backdrop-filter: blur(10px);
    font-size: 0.78rem;
    font-weight: 600;
    color: #e2e8f0;
    cursor: pointer;
    user-select: none;
  }

  .assembly-switch-pill input {
    cursor: pointer;
  }

  .price-breakdown-bar {
    background: rgba(15, 23, 42, 0.96);
    border-top: 1px solid rgba(255, 255, 255, 0.09);
    padding: 20px 24px;
  }

  .design-panel-card {
    background: rgba(15, 23, 42, 0.85);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    padding: 28px;
    backdrop-filter: blur(14px);
    box-shadow: 0 20px 45px -15px rgba(0, 0, 0, 0.6);
  }

  .config-section-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1.1px;
    color: #94a3b8;
    font-weight: 700;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .type-toggle-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  .choice-tile {
    background: rgba(30, 41, 59, 0.65);
    border: 1.5px solid rgba(255, 255, 255, 0.1);
    border-radius: 14px;
    padding: 14px 16px;
    color: #e2e8f0;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: left;
    position: relative;
  }

  .choice-tile:hover {
    border-color: rgba(96, 165, 250, 0.5);
    background: rgba(30, 41, 59, 0.9);
  }

  .choice-tile.active {
    border-color: #3b82f6;
    background: rgba(37, 99, 235, 0.16);
    box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.4);
  }

  .finish-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  .acm-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
  }

  .acrylic-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }

  .swatch-single {
    display: inline-block;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.28);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.45);
    margin-bottom: 8px;
  }

  .assembly-legend-pill {
    position: absolute;
    top: 56px;
    right: 16px;
    background: rgba(15, 23, 42, 0.88);
    border: 1px solid rgba(56, 189, 248, 0.35);
    color: #e2e8f0;
    padding: 6px 12px;
    border-radius: 10px;
    font-size: 0.72rem;
    font-weight: 500;
    backdrop-filter: blur(10px);
    z-index: 5;
    pointer-events: none;
    max-width: calc(100% - 32px);
  }

  @media (max-width: 575.98px) {
    .acm-grid {
      gap: 8px;
    }
    .acm-grid .choice-tile {
      padding: 12px 10px;
    }
  }

  .swatch-duo {
    display: inline-flex;
    align-items: center;
    margin-bottom: 8px;
  }

  .swatch-circle {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.25);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
  }

  .swatch-circle.secondary {
    margin-left: -9px;
  }

  .size-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
  }

  @media (max-width: 575.98px) {
    .size-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  .config-input {
    background: rgba(15, 23, 42, 0.9) !important;
    border: 1.5px solid rgba(255, 255, 255, 0.14) !important;
    color: #ffffff !important;
    border-radius: 12px !important;
    padding: 11px 14px !important;
    font-size: 0.95rem !important;
  }

  .config-input:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
  }

  .config-input::placeholder {
    color: #64748b !important;
  }

  .btn-helcim-pay {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: #ffffff;
    border: none;
    border-radius: 14px;
    padding: 14px 20px;
    font-weight: 700;
    font-size: 0.98rem;
    transition: all 0.2s ease;
    box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.5);
  }

  .btn-helcim-pay:hover:not(:disabled) {
    transform: translateY(-1px);
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #ffffff;
  }

  .btn-interac-pay {
    background: rgba(30, 41, 59, 0.9);
    color: #f8fafc;
    border: 1.5px solid rgba(255, 255, 255, 0.2);
    border-radius: 14px;
    padding: 13px 20px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.2s ease;
  }

  .btn-interac-pay:hover:not(:disabled) {
    background: rgba(51, 65, 85, 0.95);
    border-color: #f59e0b;
    color: #ffffff;
  }

  .confirmation-box {
    border-radius: 16px;
    padding: 20px;
    margin-top: 18px;
  }

  @media (max-width: 991.98px) {
    .viewer-sticky-wrap {
      position: static;
    }
    #plaque-canvas-container {
      height: 380px;
    }
  }
</style>

<div class="plaque-config-page">
  <div class="container">
    <!-- Header Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
      <div>
        <div class="plaque-badge-pei mb-2">
          <i class="bi bi-geo-alt-fill text-danger"></i>
          <span>Crafted in Charlottetown, PEI &bull; Canada</span>
        </div>
        <h1 class="fw-bold mb-1" style="font-size: clamp(1.6rem, 2.8vw, 2.35rem);">
          3D Architectural Plaque &amp; Signage Studio
        </h1>
        <p class="text-secondary mb-0 small">
          Real 3-layer architectural signage: CNC-cut ACM front plate, Black Sintra PVC backer &amp; 3D laser-cut acrylic lettering with floating standoffs.
        </p>
      </div>
      <div class="text-md-end">
        <span class="badge bg-primary bg-opacity-25 text-info border border-info border-opacity-25 rounded-pill px-3 py-2">
          <i class="bi bi-box-seam me-1"></i> Weatherproof Exterior Grade &bull; CAD Pricing
        </span>
      </div>
    </div>

    <!-- Main 2-Column Layout -->
    <div class="row g-4 align-items-start">
      <!-- LEFT COLUMN: 3D Interactive Viewer -->
      <div class="col-lg-7">
        <div class="viewer-sticky-wrap">
          <div class="viewer-card">
            <!-- 3D WebGL Canvas Wrapper -->
            <div id="plaque-canvas-container">
              <!-- Top Overlay: Live Specs & Assembly View Switch -->
              <div class="viewer-overlay-top">
                <span class="badge bg-dark bg-opacity-75 border border-secondary border-opacity-50 rounded-pill px-3 py-2" id="viewer-spec-pill">
                  <i class="bi bi-layers me-1 text-info"></i>
                  <span id="viewer-spec-text">House Plaque &bull; Medium (10" &times; 15")</span>
                </span>

                <label class="assembly-switch-pill" for="assemblyToggle">
                  <div class="form-check form-switch m-0 d-flex align-items-center">
                    <input class="form-check-input me-2" type="checkbox" role="switch" id="assemblyToggle">
                    <span>Assembly View (Exploded)</span>
                  </div>
                </label>
              </div>

              <!-- Exploded Layer Order Legend (shown in Assembly View) -->
              <div id="assemblyLegendPill" class="assembly-legend-pill d-none">
                <i class="bi bi-layers-half text-info me-1"></i>
                Back &rarr; Front: <strong>1. Rear Standoffs</strong> &rarr; <strong>2. Black Sintra</strong> &rarr; <strong>3. Acrylic Digits</strong> &rarr; <strong>4. CNC ACM Plate</strong>
              </div>

              <!-- Bottom Overlay: Quick Camera Angle Presets -->
              <div class="viewer-overlay-bottom">
                <div class="cam-btn-group" role="group" aria-label="Camera Angles">
                  <button type="button" class="cam-btn active" data-cam="front">Front</button>
                  <button type="button" class="cam-btn" data-cam="angle">3D Angle</button>
                  <button type="button" class="cam-btn" data-cam="profile">Profile</button>
                  <button type="button" class="cam-btn" data-cam="mounts">Mounts</button>
                </div>

                <span class="small text-light opacity-75 d-none d-sm-inline" style="font-size: 0.75rem;">
                  <i class="bi bi-arrows-move me-1"></i> Drag to orbit &bull; Scroll to zoom
                </span>
              </div>
            </div>

            <!-- Bottom Price Breakdown Bar (CAD + 15% PEI HST) -->
            <div class="price-breakdown-bar">
              <div class="row align-items-center g-3">
                <div class="col-sm-6">
                  <div class="text-secondary small text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">
                    Selected Configuration
                  </div>
                  <div class="fw-bold text-white" id="summary-finish-name">ACM: Matte Black &bull; Digits: Mirror Gold</div>
                  <div class="small text-secondary" id="summary-size-dims">Medium (10" &times; 15" / 25 &times; 38 cm) &bull; Black Sintra Base &amp; 4 Standoffs</div>
                </div>
                <div class="col-sm-6">
                  <div class="d-flex flex-column align-items-sm-end">
                    <div class="d-flex justify-content-between justify-content-sm-end gap-4 small text-secondary w-100" style="max-width: 260px;">
                      <span>Subtotal (CAD):</span>
                      <span class="text-light fw-semibold" id="price-subtotal">$60.00</span>
                    </div>
                    <div class="d-flex justify-content-between justify-content-sm-end gap-4 small text-secondary w-100" style="max-width: 260px;">
                      <span>PEI HST (15%):</span>
                      <span class="text-light fw-semibold" id="price-hst">$9.00</span>
                    </div>
                    <div class="d-flex justify-content-between justify-content-sm-end gap-4 mt-1 pt-1 border-top border-secondary border-opacity-25 w-100" style="max-width: 260px;">
                      <span class="fw-bold text-white">Total (CAD):</span>
                      <span class="fw-bold text-info fs-5" id="price-total">$69.00 CAD</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT COLUMN: Design & Checkout Panel -->
      <div class="col-lg-5">
        <div class="design-panel-card">
          <form id="plaqueConfigForm" onsubmit="return false;">
            <!-- 1. Plaque Type -->
            <div class="mb-4">
              <div class="config-section-label">
                <span>1. Plaque Style</span>
                <span class="text-info">Laser-Cut Multi-Layer</span>
              </div>
              <div class="type-toggle-grid">
                <div class="choice-tile active" data-type="house" id="tile-type-house">
                  <div class="d-flex align-items-center justify-content-between mb-1">
                    <i class="bi bi-house-door-fill text-info fs-5"></i>
                    <span class="badge bg-info bg-opacity-10 text-info small">Residential</span>
                  </div>
                  <div class="fw-bold small">House Number</div>
                  <div class="text-secondary" style="font-size: 0.73rem;">Civic number + street name</div>
                </div>

                <div class="choice-tile" data-type="business" id="tile-type-business">
                  <div class="d-flex align-items-center justify-content-between mb-1">
                    <i class="bi bi-building-fill text-info fs-5"></i>
                    <span class="badge bg-primary bg-opacity-25 text-light small">Commercial</span>
                  </div>
                  <div class="fw-bold small">Business / Office</div>
                  <div class="text-secondary" style="font-size: 0.73rem;">Company title + suite / city</div>
                </div>
              </div>
            </div>

            <!-- 2. Custom Text -->
            <div class="mb-4">
              <div class="config-section-label">
                <span>2. 3D Raised Lettering</span>
                <span id="char-counter" class="text-secondary">3 / 24</span>
              </div>
              <div class="mb-3">
                <label for="primaryTextInput" class="form-label small text-light mb-1">Primary 3D Text <span class="text-danger">*</span></label>
                <input type="text" id="primaryTextInput" class="form-control config-input fw-bold"
                       value="428" maxlength="24" placeholder="e.g. 428 or POU TECH" required>
              </div>
              <div>
                <label for="subtitleTextInput" class="form-label small text-light mb-1">Subtitle / Street / Suite (Optional)</label>
                <input type="text" id="subtitleTextInput" class="form-control config-input"
                       value="QUEEN ST" maxlength="32" placeholder="e.g. QUEEN ST or CHARLOTTETOWN">
              </div>
            </div>

            <!-- 3. Front Plate Finish — ACM (Aluminum Composite) -->
            <div class="mb-4">
              <div class="config-section-label">
                <span>3. Front Plate Finish &mdash; ACM</span>
                <span class="text-secondary">CNC Cutout Panel</span>
              </div>
              <div class="acm-grid">
                <div class="choice-tile active" data-acm-finish="matte_black">
                  <span class="swatch-single" style="background: #18181b;"></span>
                  <div class="fw-bold small">Matte Black</div>
                  <div class="text-secondary" style="font-size: 0.72rem;">Deep matte ACM</div>
                </div>

                <div class="choice-tile" data-acm-finish="brushed_silver">
                  <span class="swatch-single" style="background: linear-gradient(135deg, #e4e4e7 0%, #a1a1aa 50%, #e4e4e7 100%);"></span>
                  <div class="fw-bold small">Brushed Silver</div>
                  <div class="text-secondary" style="font-size: 0.72rem;">Brushed aluminum</div>
                </div>

                <div class="choice-tile" data-acm-finish="white">
                  <span class="swatch-single" style="background: #f8fafc;"></span>
                  <div class="fw-bold small">White</div>
                  <div class="text-secondary" style="font-size: 0.72rem;">Satin architectural</div>
                </div>
              </div>
            </div>

            <!-- 4. 3D Digits & Text Finish — Laser Acrylic -->
            <div class="mb-4">
              <div class="config-section-label">
                <span>4. 3D Digits &amp; Text &mdash; Acrylic</span>
                <span class="text-secondary">3mm/6mm Raised Inlay</span>
              </div>
              <div class="acrylic-grid">
                <div class="choice-tile active" data-acrylic-finish="mirror_gold">
                  <span class="swatch-single" style="background: linear-gradient(135deg, #fef08a 0%, #eab308 45%, #a16207 75%, #fde047 100%);"></span>
                  <div class="fw-bold small">Mirror Gold</div>
                  <div class="text-secondary" style="font-size: 0.72rem;">High-gloss gold mirror</div>
                </div>

                <div class="choice-tile" data-acrylic-finish="mirror_silver">
                  <span class="swatch-single" style="background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 45%, #64748b 70%, #f8fafc 100%);"></span>
                  <div class="fw-bold small">Mirror Silver</div>
                  <div class="text-secondary" style="font-size: 0.72rem;">Chrome mirror acrylic</div>
                </div>

                <div class="choice-tile" data-acrylic-finish="matte_white">
                  <span class="swatch-single" style="background: #ffffff;"></span>
                  <div class="fw-bold small">Matte White</div>
                  <div class="text-secondary" style="font-size: 0.72rem;">Crisp matte white</div>
                </div>

                <div class="choice-tile" data-acrylic-finish="matte_black">
                  <span class="swatch-single" style="background: #111111;"></span>
                  <div class="fw-bold small">Matte Black</div>
                  <div class="text-secondary" style="font-size: 0.72rem;">Deep matte black</div>
                </div>
              </div>
            </div>

            <!-- 5. Size Selector -->
            <div class="mb-4">
              <div class="config-section-label">
                <span>5. Plaque Size (CAD)</span>
                <span class="text-secondary">+15% PEI HST at checkout</span>
              </div>
              <div class="size-grid">
                <div class="choice-tile text-center" data-size="small" data-price="55">
                  <div class="fw-bold small">Small</div>
                  <div class="text-secondary" style="font-size: 0.7rem;">10" &times; 13"</div>
                  <div class="fw-bold text-info mt-1">$55 CAD</div>
                </div>

                <div class="choice-tile text-center active" data-size="medium" data-price="60">
                  <div class="fw-bold small">Medium</div>
                  <div class="text-secondary" style="font-size: 0.7rem;">10" &times; 15"</div>
                  <div class="fw-bold text-info mt-1">$60 CAD</div>
                </div>

                <div class="choice-tile text-center" data-size="large" data-price="70">
                  <div class="fw-bold small">Large</div>
                  <div class="text-secondary" style="font-size: 0.7rem;">10" &times; 17"</div>
                  <div class="fw-bold text-info mt-1">$70 CAD</div>
                </div>

                <div class="choice-tile text-center" data-size="extra_large" data-price="80">
                  <div class="fw-bold small">Extra Large</div>
                  <div class="text-secondary" style="font-size: 0.7rem;">10" &times; 23.5"</div>
                  <div class="fw-bold text-info mt-1">$80 CAD</div>
                </div>

                <div class="choice-tile text-center" data-size="vertical" data-price="55">
                  <div class="d-flex align-items-center justify-content-center gap-1">
                    <span class="fw-bold small">Vertical</span>
                    <i class="bi bi-arrows-vertical text-info" style="font-size: 0.75rem;"></i>
                  </div>
                  <div class="text-secondary" style="font-size: 0.7rem;">5" &times; 17"</div>
                  <div class="fw-bold text-info mt-1">$55 CAD</div>
                </div>
              </div>
            </div>

            <hr class="border-secondary border-opacity-25 my-4">

            <!-- 6. Customer Information -->
            <div class="mb-4">
              <div class="config-section-label">
                <span>6. Customer &amp; Order Details</span>
              </div>
              <div class="mb-3">
                <label for="customerName" class="form-label small text-light mb-1">Full Name <span class="text-danger">*</span></label>
                <input type="text" id="customerName" class="form-control config-input" placeholder="Jane Doe" required>
              </div>
              <div class="row g-2">
                <div class="col-sm-7">
                  <label for="customerEmail" class="form-label small text-light mb-1">Email Address <span class="text-danger">*</span></label>
                  <input type="email" id="customerEmail" class="form-control config-input" placeholder="jane@example.com" required>
                </div>
                <div class="col-sm-5">
                  <label for="customerPhone" class="form-label small text-light mb-1">Phone</label>
                  <input type="tel" id="customerPhone" class="form-control config-input" placeholder="902-555-0199">
                </div>
              </div>
            </div>

            <!-- Alert / Error Feedback -->
            <div id="checkoutAlertBox" class="alert d-none py-2 small rounded-3 mb-3"></div>

            <!-- 6. Payment Action Buttons -->
            <div class="d-grid gap-2">
              <button type="button" id="btnPayHelcim" class="btn btn-helcim-pay d-flex align-items-center justify-content-center gap-2">
                <span class="spinner-border spinner-border-sm d-none" id="spinnerHelcim"></span>
                <i class="bi bi-credit-card-2-front-fill"></i>
                <span>Pay with Card (Helcim) &mdash; <span id="btn-helcim-total">$69.00 CAD</span></span>
              </button>

              <button type="button" id="btnOrderInterac" class="btn btn-interac-pay d-flex align-items-center justify-content-center gap-2">
                <span class="spinner-border spinner-border-sm d-none" id="spinnerInterac"></span>
                <i class="bi bi-bank2 text-warning"></i>
                <span>Order via Interac e-Transfer</span>
              </button>
            </div>
          </form>

          <!-- Order Confirmation / Interac Instructions Panel -->
          <div id="orderConfirmationPanel" class="confirmation-box d-none"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="module">
  import * as THREE from 'three';
  import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
  import { FontLoader } from 'three/addons/loaders/FontLoader.js';
  import { RoomEnvironment } from 'three/addons/environments/RoomEnvironment.js';

  // ─── Reactive Configurator State ───────────────────────────────────────
  const state = {
    plaque_type: 'house',
    primary_text: '428',
    subtitle_text: 'QUEEN ST',
    acm_finish: 'matte_black',
    acrylic_finish: 'mirror_gold',
    size: 'medium',
    exploded: false,
    subtotal_cad: 60.00,
    hst_cad: 9.00,
    total_cad: 69.00
  };

  const CATALOG = {
    sizes: {
      small:       { price: 55.00, label: 'Small (10" × 13" / 25 × 33 cm)',         shortLabel: 'Small (10" × 13")',    w: 4.20, h: 3.20, camScale: 0.96 },
      medium:      { price: 60.00, label: 'Medium (10" × 15" / 25 × 38 cm)',        shortLabel: 'Medium (10" × 15")',   w: 4.80, h: 3.20, camScale: 1.00 },
      large:       { price: 70.00, label: 'Large (10" × 17" / 25 × 43 cm)',         shortLabel: 'Large (10" × 17")',    w: 5.44, h: 3.20, camScale: 1.08 },
      extra_large: { price: 80.00, label: 'Extra Large (10" × 23.5" / 25 × 60 cm)', shortLabel: 'XL (10" × 23.5")',     w: 7.52, h: 3.20, camScale: 1.28 },
      vertical:    { price: 55.00, label: 'Vertical (5" × 17" / 13 × 43 cm)',      shortLabel: 'Vertical (5" × 17")',  w: 2.10, h: 6.40, isVertical: true, camScale: 1.40 }
    },
    acm_finishes: {
      matte_black: {
        name: 'Matte Black ACM',
        shortName: 'Matte Black',
        color: 0x18181b,
        metalness: 0.15,
        roughness: 0.78,
        edgeColor: 0x0f0f12,
        envMapIntensity: 0.85,
        isBrushed: false
      },
      brushed_silver: {
        name: 'Brushed Silver ACM',
        shortName: 'Brushed Silver',
        color: 0xd4d4d8,
        metalness: 0.85,
        roughness: 0.32,
        edgeColor: 0x27272a,
        envMapIntensity: 1.15,
        isBrushed: true
      },
      white: {
        name: 'White ACM',
        shortName: 'White',
        color: 0xf8fafc,
        metalness: 0.05,
        roughness: 0.65,
        edgeColor: 0x3f3f46,
        envMapIntensity: 0.80,
        isBrushed: false
      }
    },
    acrylic_finishes: {
      mirror_gold: {
        name: 'Mirror Gold Acrylic',
        shortName: 'Mirror Gold',
        color: 0xeab308,
        metalness: 0.96,
        roughness: 0.06,
        envMapIntensity: 1.55
      },
      mirror_silver: {
        name: 'Mirror Silver Acrylic',
        shortName: 'Mirror Silver',
        color: 0xf1f5f9,
        metalness: 0.98,
        roughness: 0.05,
        envMapIntensity: 1.55
      },
      matte_white: {
        name: 'Matte White Acrylic',
        shortName: 'Matte White',
        color: 0xffffff,
        metalness: 0.02,
        roughness: 0.75,
        envMapIntensity: 0.75
      },
      matte_black: {
        name: 'Matte Black Acrylic',
        shortName: 'Matte Black',
        color: 0x111111,
        metalness: 0.05,
        roughness: 0.80,
        envMapIntensity: 0.80
      }
    }
  };

  // ─── Procedural Brushed Aluminum Maps (Color & Directional Bump) ───────
  function createBrushedAluminumMaps() {
    const size = 512;

    const colorCanvas = document.createElement('canvas');
    colorCanvas.width = size;
    colorCanvas.height = size;
    const cCtx = colorCanvas.getContext('2d');
    cCtx.fillStyle = '#f2f2f5';
    cCtx.fillRect(0, 0, size, size);

    const bumpCanvas = document.createElement('canvas');
    bumpCanvas.width = size;
    bumpCanvas.height = size;
    const bCtx = bumpCanvas.getContext('2d');
    bCtx.fillStyle = '#808080';
    bCtx.fillRect(0, 0, size, size);

    // Subtle directional horizontal grain
    for (let i = 0; i < 1100; i++) {
      const y = (i * 73) % size;
      const x = (i * 137) % size;
      const w = 120 + (i % 260);
      const isHighlight = i % 2 === 0;
      const tone = isHighlight ? 255 : 210;
      cCtx.fillStyle = `rgba(${tone}, ${tone}, ${Math.min(255, tone + 2)}, 0.16)`;
      cCtx.fillRect(0, y, size, 1);
      cCtx.fillRect(x, y, w, 1);

      const bumpTone = isHighlight ? 180 : 95;
      bCtx.fillStyle = `rgba(${bumpTone}, ${bumpTone}, ${bumpTone}, 0.28)`;
      bCtx.fillRect(0, y, size, 1);
      bCtx.fillRect(x, y, w, 1);
    }

    const colorMap = new THREE.CanvasTexture(colorCanvas);
    colorMap.wrapS = THREE.RepeatWrapping;
    colorMap.wrapT = THREE.RepeatWrapping;
    colorMap.repeat.set(0.28, 0.28);
    colorMap.colorSpace = THREE.SRGBColorSpace;

    const bumpMap = new THREE.CanvasTexture(bumpCanvas);
    bumpMap.wrapS = THREE.RepeatWrapping;
    bumpMap.wrapT = THREE.RepeatWrapping;
    bumpMap.repeat.set(0.28, 0.28);

    return { colorMap, bumpMap };
  }

  const brushedMaps = createBrushedAluminumMaps();

  // ─── Three.js Scene & Studio Reflection Environment Setup ──────────────
  const container = document.getElementById('plaque-canvas-container');
  const scene = new THREE.Scene();

  const camera = new THREE.PerspectiveCamera(36, container.clientWidth / container.clientHeight, 0.1, 100);
  camera.position.set(0, 0.05, 8.6);

  const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
  renderer.setSize(container.clientWidth, container.clientHeight);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.shadowMap.enabled = true;
  renderer.shadowMap.type = THREE.PCFSoftShadowMap;
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  renderer.toneMappingExposure = 1.05;
  container.appendChild(renderer.domElement);

  // PMREM + RoomEnvironment for realistic metallic & mirror acrylic reflections
  const pmremGenerator = new THREE.PMREMGenerator(renderer);
  pmremGenerator.compileEquirectangularShader();
  const roomEnv = new RoomEnvironment(renderer);
  scene.environment = pmremGenerator.fromScene(roomEnv, 0.04).texture;
  roomEnv.dispose();
  pmremGenerator.dispose();

  const controls = new OrbitControls(camera, renderer.domElement);
  controls.enableDamping = true;
  controls.dampingFactor = 0.06;
  controls.minDistance = 3.8;
  controls.maxDistance = 19.0;
  controls.maxPolarAngle = Math.PI * 0.85;

  // Balanced Studio Lighting complementing RoomEnvironment IBL
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.35);
  scene.add(ambientLight);

  const keyLight = new THREE.DirectionalLight(0xfffbeb, 1.8);
  keyLight.position.set(5, 7, 6);
  keyLight.castShadow = true;
  keyLight.shadow.mapSize.width = 2048;
  keyLight.shadow.mapSize.height = 2048;
  keyLight.shadow.bias = -0.0005;
  keyLight.shadow.camera.near = 0.5;
  keyLight.shadow.camera.far = 25;
  keyLight.shadow.camera.left = -6;
  keyLight.shadow.camera.right = 6;
  keyLight.shadow.camera.top = 5;
  keyLight.shadow.camera.bottom = -5;
  scene.add(keyLight);

  const fillLight = new THREE.DirectionalLight(0x93c5fd, 0.75);
  fillLight.position.set(-6, 3, 4);
  scene.add(fillLight);

  const rimLight = new THREE.DirectionalLight(0xfde047, 0.55);
  rimLight.position.set(0, -5, -4);
  scene.add(rimLight);

  // Subtle architectural wall shadow plane behind the plaque
  const wallGeo = new THREE.PlaneGeometry(26, 18);
  const wallMat = new THREE.ShadowMaterial({ opacity: 0.30 });
  const wallMesh = new THREE.Mesh(wallGeo, wallMat);
  wallMesh.position.z = -0.56;
  wallMesh.receiveShadow = true;
  scene.add(wallMesh);

  // ─── Multi-Layer Plaque Hierarchy (Back → Front) ───────────────────────
  const rootGroup = new THREE.Group();
  scene.add(rootGroup);

  const standoffsRearLayer = new THREE.Group();  // 1. Rear Standoff Barrels
  const sintraBackLayer    = new THREE.Group();  // 2. Black Sintra PVC Backing
  const acrylicDigitsLayer = new THREE.Group();  // 3. Individual 3D Acrylic Digits & Subtitle
  const acmFrontLayer      = new THREE.Group();  // 4. CNC-Cut ACM Front Plate + Counter Islands
  const standoffsCapLayer  = new THREE.Group();  // 5. Front Metallic Standoff Caps

  rootGroup.add(standoffsRearLayer);
  rootGroup.add(sintraBackLayer);
  rootGroup.add(acrylicDigitsLayer);
  rootGroup.add(acmFrontLayer);
  rootGroup.add(standoffsCapLayer);

  let loadedFont = null;

  // Canonical counter-clockwise rounded rectangle Shape (outer boundary)
  function createRoundedRectShape(width, height, radius) {
    const shape = new THREE.Shape();
    const x = -width / 2;
    const y = -height / 2;
    shape.moveTo(x + radius, y);
    shape.lineTo(x + width - radius, y);
    shape.quadraticCurveTo(x + width, y, x + width, y + radius);
    shape.lineTo(x + width, y + height - radius);
    shape.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
    shape.lineTo(x + radius, y + height);
    shape.quadraticCurveTo(x, y + height, x, y + height - radius);
    shape.lineTo(x, y + radius);
    shape.quadraticCurveTo(x, y, x + radius, y);
    return shape;
  }

  function ensureWinding(pts, wantClockwise) {
    const cloned = pts.map(p => new THREE.Vector2(p.x, p.y));
    if (THREE.ShapeUtils.isClockWise(cloned) !== wantClockwise) {
      cloned.reverse();
    }
    return cloned;
  }

  // Canonical clockwise circular Path (for mounting standoff cutouts)
  function createCirclePath(cx, cy, radius, segments = 24) {
    const pts = [];
    for (let i = 0; i < segments; i++) {
      const theta = (i / segments) * Math.PI * 2;
      pts.push(new THREE.Vector2(
        cx + Math.cos(theta) * radius,
        cy - Math.sin(theta) * radius
      ));
    }
    const cwPts = ensureWinding(pts, true);
    const path = new THREE.Path(cwPts);
    path.closePath();
    return path;
  }

  function sampleCleanPoints(curvePath, divisions = 8) {
    const raw = curvePath.getPoints(divisions);
    const cleaned = [];
    for (let i = 0; i < raw.length; i++) {
      const pt = raw[i];
      if (!Number.isFinite(pt.x) || !Number.isFinite(pt.y)) continue;
      const prev = cleaned[cleaned.length - 1];
      if (prev && Math.hypot(pt.x - prev.x, pt.y - prev.y) < 1e-4) continue;
      cleaned.push(new THREE.Vector2(pt.x, pt.y));
    }
    if (cleaned.length > 2) {
      const first = cleaned[0];
      const last = cleaned[cleaned.length - 1];
      if (Math.hypot(first.x - last.x, first.y - last.y) < 1e-4) {
        cleaned.pop();
      }
    }
    if (cleaned.length < 3) return null;
    if (Math.abs(THREE.ShapeUtils.area(cleaned)) <= 1e-5) return null;
    return cleaned;
  }

  // Builds centered & auto-fitted per-character 2D contours in plaque XY coordinates
  function buildCharGlyphLayouts(text, fontSize, maxWidth, maxHeight, targetY, curveDivisions = 8) {
    if (!loadedFont || !text) {
      return { characters: [], effectiveFontSize: fontSize };
    }

    const chars = Array.from(text);
    const extraSpacing = fontSize * 0.045;
    const resolution = loadedFont.data?.resolution || 1000;
    const glyphs = loadedFont.data?.glyphs || {};

    let cursorX = 0;
    let minX = Infinity, maxX = -Infinity, minY = Infinity, maxY = -Infinity;
    const rawChars = [];

    for (const ch of chars) {
      if (ch === ' ') {
        const sp = glyphs[' '];
        const spAdv = sp && typeof sp.ha === 'number' ? (sp.ha / resolution) * fontSize : fontSize * 0.35;
        cursorX += spAdv + extraSpacing;
        continue;
      }

      const glyphShapes = loadedFont.generateShapes(ch, fontSize) || [];
      const glyphMeta = glyphs[ch] || glyphs['?'];
      const advance = glyphMeta && typeof glyphMeta.ha === 'number'
        ? (glyphMeta.ha / resolution) * fontSize
        : fontSize * 0.65;

      const contours = [];
      for (const shape of glyphShapes) {
        const outerRaw = sampleCleanPoints(shape, curveDivisions);
        if (!outerRaw) continue;

        const outerShifted = outerRaw.map(p => {
          const sx = p.x + cursorX;
          const sy = p.y;
          if (sx < minX) minX = sx;
          if (sx > maxX) maxX = sx;
          if (sy < minY) minY = sy;
          if (sy > maxY) maxY = sy;
          return new THREE.Vector2(sx, sy);
        });

        const holePtsList = [];
        for (const hole of (shape.holes || [])) {
          const holeRaw = sampleCleanPoints(hole, curveDivisions);
          if (!holeRaw) continue;
          holePtsList.push(holeRaw.map(p => new THREE.Vector2(p.x + cursorX, p.y)));
        }

        contours.push({ outerPts: outerShifted, holePtsList });
      }

      if (contours.length > 0) {
        rawChars.push({ char: ch, contours });
      }
      cursorX += advance + extraSpacing;
    }

    if (rawChars.length === 0 || !Number.isFinite(minX)) {
      return { characters: [], effectiveFontSize: fontSize };
    }

    const rawW = Math.max(maxX - minX, 1e-4);
    const rawH = Math.max(maxY - minY, 1e-4);
    const centerX = (minX + maxX) / 2;
    const centerY = (minY + maxY) / 2;
    const fitScale = Math.min(1, maxWidth / rawW, maxHeight / rawH);

    const characters = rawChars.map(entry => ({
      char: entry.char,
      contours: entry.contours.map(c => ({
        outerPts: ensureWinding(
          c.outerPts.map(p => new THREE.Vector2((p.x - centerX) * fitScale, (p.y - centerY) * fitScale + targetY)),
          false
        ),
        holePtsList: c.holePtsList.map(h => ensureWinding(
          h.map(p => new THREE.Vector2((p.x - centerX) * fitScale, (p.y - centerY) * fitScale + targetY)),
          true
        ))
      }))
    }));

    return { characters, effectiveFontSize: fontSize * fitScale };
  }

  function clearGroup(group) {
    while (group.children.length > 0) {
      const child = group.children[0];
      if (child.geometry) child.geometry.dispose();
      if (child.material) {
        if (Array.isArray(child.material)) {
          child.material.forEach(m => m && m.dispose());
        } else {
          child.material.dispose();
        }
      }
      group.remove(child);
    }
  }

  function addLayoutToAcrylicAndAcm(layout, extrusionDepth, bevelThickness, bevelSizeMax, acrylicMaterial, acmFaceMat, acmEdgeMat, safeHalfW, safeHalfH, acmHolesList, acmIslandsQueue) {
    const acmDepth = 0.075;

    for (const chEntry of layout.characters) {
      for (const contour of chEntry.contours) {
        // 1. Independent 3D Acrylic Digit/Character Mesh
        const charShape = new THREE.Shape(contour.outerPts);
        charShape.closePath();
        for (const holePts of contour.holePtsList) {
          const hPath = new THREE.Path(holePts);
          hPath.closePath();
          charShape.holes.push(hPath);
        }

        const bevelSize = Math.min(bevelSizeMax, layout.effectiveFontSize * 0.014);
        let charGeo;
        try {
          charGeo = new THREE.ExtrudeGeometry(charShape, {
            depth: extrusionDepth,
            bevelEnabled: true,
            bevelThickness: bevelThickness,
            bevelSize: bevelSize,
            bevelOffset: -bevelSize,
            bevelSegments: 2,
            curveSegments: 8
          });
        } catch (err) {
          charGeo = new THREE.ExtrudeGeometry(charShape, {
            depth: extrusionDepth,
            bevelEnabled: false,
            curveSegments: 8
          });
        }

        charGeo.computeBoundingBox();
        const backOffsetZ = charGeo.boundingBox ? -charGeo.boundingBox.min.z : 0;

        const charMesh = new THREE.Mesh(charGeo, acrylicMaterial);
        charMesh.position.z = backOffsetZ; // Back sits flush on Sintra at z = 0.000
        charMesh.castShadow = true;
        charMesh.receiveShadow = true;
        acrylicDigitsLayer.add(charMesh);

        // 2. Register Matching CNC Cutout Hole + Inner Island in ACM Plate
        const fitsSafely = contour.outerPts.every(
          p => Math.abs(p.x) < safeHalfW && Math.abs(p.y) < safeHalfH
        );
        if (fitsSafely) {
          const cutoutPts = ensureWinding(contour.outerPts, true);
          const cutoutPath = new THREE.Path(cutoutPts);
          cutoutPath.closePath();
          acmHolesList.push(cutoutPath);

          for (const holePts of contour.holePtsList) {
            const islandFits = holePts.every(
              p => Math.abs(p.x) < safeHalfW && Math.abs(p.y) < safeHalfH
            );
            if (islandFits) {
              const islandPts = ensureWinding(holePts, false);
              acmIslandsQueue.push({ islandPts, acmDepth, acmFaceMat, acmEdgeMat });
            }
          }
        }
      }
    }
  }

  function buildPlaqueModel() {
    clearGroup(standoffsRearLayer);
    clearGroup(sintraBackLayer);
    clearGroup(acrylicDigitsLayer);
    clearGroup(acmFrontLayer);
    clearGroup(standoffsCapLayer);

    const sizeSpec = CATALOG.sizes[state.size] || CATALOG.sizes.medium;
    const acmSpec = CATALOG.acm_finishes[state.acm_finish] || CATALOG.acm_finishes.matte_black;
    const acrylicSpec = CATALOG.acrylic_finishes[state.acrylic_finish] || CATALOG.acrylic_finishes.mirror_gold;
    const isVertical = Boolean(sizeSpec.isVertical || state.size === 'vertical');

    const width = isVertical ? sizeSpec.w : (state.plaque_type === 'business' ? sizeSpec.w * 1.08 : sizeSpec.w);
    const height = isVertical ? sizeSpec.h : (state.plaque_type === 'business' ? sizeSpec.h * 0.95 : sizeSpec.h);
    const cornerRadius = 0.28;

    // ─── Materials ───────────────────────────────────────────────────────
    const sintraMat = new THREE.MeshStandardMaterial({
      color: 0x121215,
      roughness: 0.88,
      metalness: 0.04,
      envMapIntensity: 0.50
    });

    const acmFaceMat = new THREE.MeshStandardMaterial({
      color: acmSpec.color,
      metalness: acmSpec.metalness,
      roughness: acmSpec.roughness,
      envMapIntensity: acmSpec.envMapIntensity ?? 1.0,
      map: acmSpec.isBrushed ? brushedMaps.colorMap : null,
      bumpMap: acmSpec.isBrushed ? brushedMaps.bumpMap : null,
      bumpScale: acmSpec.isBrushed ? 0.008 : 0
    });

    const acmEdgeMat = new THREE.MeshStandardMaterial({
      color: acmSpec.edgeColor,
      roughness: 0.65,
      metalness: 0.20,
      envMapIntensity: 0.70
    });

    const acrylicMat = new THREE.MeshStandardMaterial({
      color: acrylicSpec.color,
      metalness: acrylicSpec.metalness,
      roughness: acrylicSpec.roughness,
      envMapIntensity: acrylicSpec.envMapIntensity ?? 1.0
    });

    const standoffMat = new THREE.MeshStandardMaterial({
      color: 0xd4d4d8,
      metalness: 0.92,
      roughness: 0.22,
      envMapIntensity: 1.20
    });

    // ─── 1. Four Corner Metallic Standoffs ───────────────────────────────
    const insetX = width / 2 - (isVertical ? 0.35 : 0.45);
    const insetY = height / 2 - 0.45;
    const corners = [
      [-insetX,  insetY],
      [ insetX,  insetY],
      [-insetX, -insetY],
      [ insetX, -insetY]
    ];

    const barrelGeo = new THREE.CylinderGeometry(0.11, 0.11, 0.42, 28);
    barrelGeo.rotateX(Math.PI / 2);

    const capGeo = new THREE.CylinderGeometry(0.135, 0.135, 0.08, 28);
    capGeo.rotateX(Math.PI / 2);

    corners.forEach(([cx, cy]) => {
      const barrel = new THREE.Mesh(barrelGeo.clone(), standoffMat.clone());
      barrel.position.set(cx, cy, -0.31); // Spans -0.52 to -0.10 (meets rear of Sintra)
      barrel.castShadow = true;
      standoffsRearLayer.add(barrel);

      const cap = new THREE.Mesh(capGeo.clone(), standoffMat.clone());
      cap.position.set(cx, cy, 0.118); // Spans 0.078 to 0.158 (caps front of ACM)
      cap.castShadow = true;
      standoffsCapLayer.add(cap);
    });

    barrelGeo.dispose();
    capGeo.dispose();
    standoffMat.dispose();

    // ─── 2. Black Sintra PVC Backing Layer (Back Layer) ──────────────────
    const sintraShape = createRoundedRectShape(width, height, cornerRadius);
    corners.forEach(([cx, cy]) => {
      sintraShape.holes.push(createCirclePath(cx, cy, 0.095, 20));
    });

    const sintraGeo = new THREE.ExtrudeGeometry(sintraShape, {
      depth: 0.10,
      bevelEnabled: false,
      curveSegments: 10
    });
    const sintraMesh = new THREE.Mesh(sintraGeo, sintraMat);
    sintraMesh.position.z = -0.10; // Flush front surface at z = 0.00
    sintraMesh.castShadow = true;
    sintraMesh.receiveShadow = true;
    sintraBackLayer.add(sintraMesh);

    // ─── 3. Individual 3D Acrylic Digits & Subtitle + ACM Cutouts ─────────
    const acmDepth = 0.075;
    const acmShape = createRoundedRectShape(width, height, cornerRadius);
    const acmHolesList = [];
    const acmIslandsQueue = [];

    corners.forEach(([cx, cy]) => {
      acmHolesList.push(createCirclePath(cx, cy, 0.095, 20));
    });

    const primaryStr = (state.primary_text || '428').trim().toUpperCase();
    const subtitleStr = (state.subtitle_text || '').trim().toUpperCase();

    const safeHalfW = width / 2 - 0.18;
    const safeHalfH = height / 2 - 0.18;

    if (loadedFont) {
      // Primary 3D Raised Text
      const maxTextWidth = isVertical ? (width - 0.48) : (width - 1.35);
      const primaryMaxH = isVertical ? 1.25 : (subtitleStr ? 1.15 : 1.65);
      const primaryTargetY = isVertical ? (subtitleStr ? 0.95 : 0.0) : (subtitleStr ? 0.32 : 0.0);
      const basePrimarySize = state.plaque_type === 'house' ? (isVertical ? 0.85 : 1.05) : 0.72;

      const primaryLayout = buildCharGlyphLayouts(
        primaryStr,
        basePrimarySize,
        maxTextWidth,
        primaryMaxH,
        primaryTargetY,
        8
      );

      addLayoutToAcrylicAndAcm(
        primaryLayout,
        0.116, // extrude depth (total with 2 * 0.012 bevel = 0.140; protrudes past 0.077 ACM)
        0.012,
        0.009,
        acrylicMat,
        acmFaceMat,
        acmEdgeMat,
        safeHalfW,
        safeHalfH,
        acmHolesList,
        acmIslandsQueue
      );

      // Optional Subtitle & Divider Bar
      if (subtitleStr) {
        const subTargetY = isVertical ? -1.15 : -0.68;
        const subMaxH = 0.42;
        const baseSubSize = state.plaque_type === 'house' ? (isVertical ? 0.24 : 0.32) : 0.28;

        const subLayout = buildCharGlyphLayouts(
          subtitleStr,
          baseSubSize,
          maxTextWidth,
          subMaxH,
          subTargetY,
          6
        );

        addLayoutToAcrylicAndAcm(
          subLayout,
          0.106, // total with 2 * 0.007 bevel = 0.120; protrudes cleanly past 0.077 ACM
          0.007,
          0.004,
          acrylicMat,
          acmFaceMat,
          acmEdgeMat,
          safeHalfW,
          safeHalfH,
          acmHolesList,
          acmIslandsQueue
        );

        // Acrylic Architectural Divider Bar + Matching ACM Cutout Slot
        const dividerW = isVertical ? Math.min(width * 0.58, 1.05) : Math.min(width * 0.42, 2.2);
        const dividerH = 0.055;
        const dividerY = isVertical ? -0.10 : -0.24;

        const divShape = createRoundedRectShape(dividerW, dividerH, 0.02);
        const divPtsRaw = sampleCleanPoints(divShape, 4);
        if (divPtsRaw) {
          const divPtsAcrylic = ensureWinding(
            divPtsRaw.map(p => new THREE.Vector2(p.x, p.y + dividerY)),
            false
          );
          const divAcrylicShape = new THREE.Shape(divPtsAcrylic);
          divAcrylicShape.closePath();

          const divGeo = new THREE.ExtrudeGeometry(divAcrylicShape, {
            depth: 0.104,
            bevelEnabled: true,
            bevelThickness: 0.006,
            bevelSize: 0.003,
            bevelOffset: -0.003,
            bevelSegments: 2
          });
          divGeo.computeBoundingBox();
          const divBackZ = divGeo.boundingBox ? -divGeo.boundingBox.min.z : 0;
          const divMesh = new THREE.Mesh(divGeo, acrylicMat);
          divMesh.position.z = divBackZ;
          divMesh.castShadow = true;
          divMesh.receiveShadow = true;
          acrylicDigitsLayer.add(divMesh);

          const divFits = divPtsAcrylic.every(
            p => Math.abs(p.x) < safeHalfW && Math.abs(p.y) < safeHalfH
          );
          if (divFits) {
            const divCutoutPts = ensureWinding(divPtsAcrylic, true);
            const divCutoutPath = new THREE.Path(divCutoutPts);
            divCutoutPath.closePath();
            acmHolesList.push(divCutoutPath);
          }
        }
      }
    }

    // ─── 4. Front ACM Plate with CNC Cutouts + Counter Islands ───────────
    acmHolesList.forEach(h => acmShape.holes.push(h));

    let acmGeo;
    try {
      acmGeo = new THREE.ExtrudeGeometry(acmShape, {
        depth: acmDepth,
        bevelEnabled: false,
        curveSegments: 8
      });
    } catch (err) {
      // Safe fallback to plain ACM with mounting holes if an unusual glyph trips Earcut
      const fallbackAcm = createRoundedRectShape(width, height, cornerRadius);
      corners.forEach(([cx, cy]) => {
        fallbackAcm.holes.push(createCirclePath(cx, cy, 0.095, 20));
      });
      acmGeo = new THREE.ExtrudeGeometry(fallbackAcm, {
        depth: acmDepth,
        bevelEnabled: false,
        curveSegments: 8
      });
    }

    const acmMesh = new THREE.Mesh(acmGeo, [acmFaceMat, acmEdgeMat]);
    acmMesh.position.z = 0.002; // 0.002 clearance above Sintra (z = 0.00) to avoid Z-fighting
    acmMesh.castShadow = true;
    acmMesh.receiveShadow = true;
    acmFrontLayer.add(acmMesh);

    // Floating Inner Counter Islands of the ACM Plate (inside 0, 4, 6, 8, 9, A, B, D, O, P, Q, R, etc.)
    for (const isl of acmIslandsQueue) {
      try {
        const islandShape = new THREE.Shape(isl.islandPts);
        islandShape.closePath();
        const islandGeo = new THREE.ExtrudeGeometry(islandShape, {
          depth: isl.acmDepth,
          bevelEnabled: false,
          curveSegments: 8
        });
        const islandMesh = new THREE.Mesh(islandGeo, [isl.acmFaceMat, isl.acmEdgeMat]);
        islandMesh.position.z = 0.002;
        islandMesh.castShadow = true;
        islandMesh.receiveShadow = true;
        acmFrontLayer.add(islandMesh);
      } catch (_) {
        // Ignore degenerate micro-islands
      }
    }
  }

  // Load 3D Typeface and build initial model
  const fontLoader = new FontLoader();
  fontLoader.load(
    'https://cdn.jsdelivr.net/npm/three@0.160.0/examples/fonts/helvetiker_bold.typeface.json',
    function (font) {
      loadedFont = font;
      buildPlaqueModel();
    },
    undefined,
    function () {
      buildPlaqueModel();
    }
  );
  buildPlaqueModel();

  // ─── Camera Preset & Exploded Assembly Animation Loop ──────────────────
  const targetCameraPos = new THREE.Vector3(0, 0.05, 8.6);
  const targetControlsLook = new THREE.Vector3(0, 0, 0);
  let cameraAnimating = false;
  let currentCamKey = 'front';

  const CAM_PRESETS = {
    front:   { pos: [0, 0.05, 8.6],   look: [0, 0, 0] },
    angle:   { pos: [4.3, 2.1, 7.5],  look: [0, 0, 0] },
    profile: { pos: [7.8, 0.35, 2.2], look: [0, 0, 0] },
    mounts:  { pos: [2.6, 1.65, 3.6], look: [1.8, 1.0, 0] }
  };

  function applyCameraPreset(camKey) {
    currentCamKey = camKey || 'front';
    const sizeSpec = CATALOG.sizes[state.size] || CATALOG.sizes.medium;
    const camScale = sizeSpec.camScale || 1.0;
    const isVertical = Boolean(sizeSpec.isVertical || state.size === 'vertical');

    if (currentCamKey === 'mounts') {
      const width = isVertical ? sizeSpec.w : (state.plaque_type === 'business' ? sizeSpec.w * 1.08 : sizeSpec.w);
      const height = isVertical ? sizeSpec.h : (state.plaque_type === 'business' ? sizeSpec.h * 0.95 : sizeSpec.h);
      const cx = width / 2 - (isVertical ? 0.35 : 0.45);
      const cy = height / 2 - 0.45;
      targetControlsLook.set(cx, cy, 0);
      targetCameraPos.set(cx + 1.15, cy + 0.65, 3.35);
    } else {
      const preset = CAM_PRESETS[currentCamKey] || CAM_PRESETS.front;
      targetCameraPos.set(
        preset.pos[0] * camScale,
        preset.pos[1] * camScale,
        preset.pos[2] * camScale
      );
      targetControlsLook.set(...preset.look);
    }
    cameraAnimating = true;
  }

  document.querySelectorAll('.cam-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.cam-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      applyCameraPreset(btn.dataset.cam);
    });
  });

  controls.addEventListener('start', () => {
    cameraAnimating = false;
  });

  let explodeProgress = 0;

  function animate() {
    requestAnimationFrame(animate);

    // Smooth camera preset transitions
    if (cameraAnimating) {
      camera.position.lerp(targetCameraPos, 0.08);
      controls.target.lerp(targetControlsLook, 0.08);
      if (camera.position.distanceTo(targetCameraPos) < 0.03) {
        cameraAnimating = false;
      }
    }

    // Smooth Exploded Assembly View (Back → Front: Rear Standoffs → Black Sintra → Acrylic Digits → CNC ACM Plate → Caps)
    const targetExplode = state.exploded ? 1.0 : 0.0;
    explodeProgress += (targetExplode - explodeProgress) * 0.09;

    standoffsRearLayer.position.z = -explodeProgress * 1.60;
    sintraBackLayer.position.z    = -explodeProgress * 0.80;
    acrylicDigitsLayer.position.z =  explodeProgress * 0.05;
    acmFrontLayer.position.z      =  explodeProgress * 1.05;
    standoffsCapLayer.position.z  =  explodeProgress * 1.55;
    wallMesh.position.z           = -0.56 - explodeProgress * 1.65;

    controls.update();
    renderer.render(scene, camera);
  }
  animate();

  window.addEventListener('resize', () => {
    if (!container) return;
    camera.aspect = container.clientWidth / container.clientHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(container.clientWidth, container.clientHeight);
  });

  // ─── UI Reactivity & Pricing Updates ───────────────────────────────────
  function updatePricingAndSummaryUI() {
    const sizeSpec = CATALOG.sizes[state.size] || CATALOG.sizes.medium;
    const acmSpec = CATALOG.acm_finishes[state.acm_finish] || CATALOG.acm_finishes.matte_black;
    const acrylicSpec = CATALOG.acrylic_finishes[state.acrylic_finish] || CATALOG.acrylic_finishes.mirror_gold;

    state.subtotal_cad = sizeSpec.price;
    state.hst_cad = Math.round(state.subtotal_cad * 0.15 * 100) / 100;
    state.total_cad = Math.round((state.subtotal_cad + state.hst_cad) * 100) / 100;

    const fmtSub = '$' + state.subtotal_cad.toFixed(2);
    const fmtHst = '$' + state.hst_cad.toFixed(2);
    const fmtTot = '$' + state.total_cad.toFixed(2) + ' CAD';

    document.getElementById('price-subtotal').textContent = fmtSub;
    document.getElementById('price-hst').textContent = fmtHst;
    document.getElementById('price-total').textContent = fmtTot;
    document.getElementById('btn-helcim-total').textContent = fmtTot;

    document.getElementById('summary-finish-name').textContent = `ACM: ${acmSpec.shortName} • Digits: ${acrylicSpec.shortName}`;
    document.getElementById('summary-size-dims').textContent = `${sizeSpec.label} • Black Sintra Base & 4 Standoffs`;

    const typeLabel = state.plaque_type === 'business' ? 'Business Signage' : 'House Plaque';
    document.getElementById('viewer-spec-text').textContent = `${typeLabel} • ${sizeSpec.shortLabel}`;
  }

  // Plaque Type Switch
  document.querySelectorAll('[data-type]').forEach(tile => {
    tile.addEventListener('click', () => {
      document.querySelectorAll('[data-type]').forEach(t => t.classList.remove('active'));
      tile.classList.add('active');
      state.plaque_type = tile.dataset.type;

      const pInput = document.getElementById('primaryTextInput');
      const sInput = document.getElementById('subtitleTextInput');
      if (state.plaque_type === 'business' && pInput.value === '428') {
        pInput.value = 'POU TECH';
        sInput.value = 'CHARLOTTETOWN';
        state.primary_text = pInput.value;
        state.subtitle_text = sInput.value;
      } else if (state.plaque_type === 'house' && pInput.value === 'POU TECH') {
        pInput.value = '428';
        sInput.value = 'QUEEN ST';
        state.primary_text = pInput.value;
        state.subtitle_text = sInput.value;
      }

      document.getElementById('char-counter').textContent = `${pInput.value.length} / 24`;
      updatePricingAndSummaryUI();
      buildPlaqueModel();
    });
  });

  // Live Text Inputs
  const primaryInput = document.getElementById('primaryTextInput');
  const subtitleInput = document.getElementById('subtitleTextInput');

  primaryInput.addEventListener('input', (e) => {
    state.primary_text = e.target.value || ' ';
    document.getElementById('char-counter').textContent = `${e.target.value.length} / 24`;
    buildPlaqueModel();
  });

  subtitleInput.addEventListener('input', (e) => {
    state.subtitle_text = e.target.value;
    buildPlaqueModel();
  });

  // ACM Front Plate Finish Selection
  document.querySelectorAll('[data-acm-finish]').forEach(tile => {
    tile.addEventListener('click', () => {
      document.querySelectorAll('[data-acm-finish]').forEach(t => t.classList.remove('active'));
      tile.classList.add('active');
      state.acm_finish = tile.dataset.acmFinish;
      updatePricingAndSummaryUI();
      buildPlaqueModel();
    });
  });

  // Acrylic Digits Finish Selection
  document.querySelectorAll('[data-acrylic-finish]').forEach(tile => {
    tile.addEventListener('click', () => {
      document.querySelectorAll('[data-acrylic-finish]').forEach(t => t.classList.remove('active'));
      tile.classList.add('active');
      state.acrylic_finish = tile.dataset.acrylicFinish;
      updatePricingAndSummaryUI();
      buildPlaqueModel();
    });
  });

  // Size Selection
  document.querySelectorAll('[data-size]').forEach(tile => {
    tile.addEventListener('click', () => {
      document.querySelectorAll('[data-size]').forEach(t => t.classList.remove('active'));
      tile.classList.add('active');
      state.size = tile.dataset.size;
      updatePricingAndSummaryUI();
      buildPlaqueModel();
      applyCameraPreset(currentCamKey);
    });
  });

  // Assembly Exploded View Toggle
  document.getElementById('assemblyToggle').addEventListener('change', (e) => {
    state.exploded = e.target.checked;
    const legendPill = document.getElementById('assemblyLegendPill');
    if (legendPill) {
      legendPill.classList.toggle('d-none', !state.exploded);
    }
    if (state.exploded) {
      // Switch camera to 3D Angle so the exploded layers are clearly visible
      const angleBtn = document.querySelector('[data-cam="angle"]');
      if (angleBtn) angleBtn.click();
    }
  });

  // ─── Checkout & HelcimPay.js / Interac e-Transfer Integration ──────────
  const apiEndpoint = "<?php echo BASE_URL; ?>/includes/plaque_api.php";
  const alertBox = document.getElementById('checkoutAlertBox');
  const confirmPanel = document.getElementById('orderConfirmationPanel');
  const btnHelcim = document.getElementById('btnPayHelcim');
  const btnInterac = document.getElementById('btnOrderInterac');
  const spinnerHelcim = document.getElementById('spinnerHelcim');
  const spinnerInterac = document.getElementById('spinnerInterac');

  let activeHelcimOrder = null;

  function showAlert(type, message) {
    alertBox.className = `alert alert-${type} py-2 small rounded-3 mb-3`;
    alertBox.innerHTML = message;
    alertBox.classList.remove('d-none');
  }

  function hideAlert() {
    alertBox.classList.add('d-none');
  }

  function getCustomerPayload(paymentMethod) {
    const name = document.getElementById('customerName').value.trim();
    const email = document.getElementById('customerEmail').value.trim();
    const phone = document.getElementById('customerPhone').value.trim();
    const primary = document.getElementById('primaryTextInput').value.trim();
    const subtitle = document.getElementById('subtitleTextInput').value.trim();

    if (!primary) {
      showAlert('warning', '<i class="bi bi-exclamation-triangle-fill me-1"></i> Please enter the primary 3D text for your plaque.');
      document.getElementById('primaryTextInput').focus();
      return null;
    }
    if (!name || !email) {
      showAlert('warning', '<i class="bi bi-exclamation-triangle-fill me-1"></i> Please enter your Full Name and Email Address.');
      if (!name) document.getElementById('customerName').focus();
      else document.getElementById('customerEmail').focus();
      return null;
    }

    return {
      action: 'create_order',
      customer_name: name,
      customer_email: email,
      customer_phone: phone,
      plaque_type: state.plaque_type,
      primary_text: primary,
      subtitle_text: subtitle,
      acm_finish: state.acm_finish,
      acrylic_finish: state.acrylic_finish,
      size: state.size,
      payment_method: paymentMethod
    };
  }

  // 1. Pay with Card (HelcimPay.js Modal)
  btnHelcim.addEventListener('click', async () => {
    hideAlert();
    const payload = getCustomerPayload('helcim');
    if (!payload) return;

    btnHelcim.disabled = true;
    btnInterac.disabled = true;
    spinnerHelcim.classList.remove('d-none');

    try {
      const response = await fetch(apiEndpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      const result = await response.json();

      spinnerHelcim.classList.add('d-none');
      btnHelcim.disabled = false;
      btnInterac.disabled = false;

      if (!result.success || !result.data?.checkout_token) {
        showAlert('danger', '<i class="bi bi-x-circle-fill me-1"></i> ' + (result.message || 'Could not initialize Helcim card checkout. You can also place your order via Interac e-Transfer below.'));
        return;
      }

      const acmFallback = (CATALOG.acm_finishes[payload.acm_finish] || {}).name || payload.acm_finish;
      const acrylicFallback = (CATALOG.acrylic_finishes[payload.acrylic_finish] || {}).name || payload.acrylic_finish;
      const sizeFallback = (CATALOG.sizes[payload.size] || {}).label || payload.size;

      activeHelcimOrder = {
        ...payload,
        order_id: result.data.order_id,
        order_number: result.data.order_number,
        subtotal_cad: result.data.subtotal_cad,
        hst_cad: result.data.hst_cad,
        total_cad: result.data.total_cad,
        acm_finish_label: result.data.acm_finish_label || acmFallback,
        acrylic_finish_label: result.data.acrylic_finish_label || acrylicFallback,
        finish_label: result.data.finish_label || `${acmFallback} + ${acrylicFallback}`,
        size_label: result.data.size_label || sizeFallback
      };

      // Dispatch open-helcim-checkout custom event and invoke official HelcimPay.js iframe
      window.dispatchEvent(new CustomEvent('open-helcim-checkout', {
        detail: { checkoutToken: result.data.checkout_token }
      }));

    } catch (err) {
      spinnerHelcim.classList.add('d-none');
      btnHelcim.disabled = false;
      btnInterac.disabled = false;
      showAlert('danger', '<i class="bi bi-x-circle-fill me-1"></i> Network error while initializing checkout. Please try again.');
    }
  });

  // Listen for open-helcim-checkout to launch HelcimPay.js Modal
  window.addEventListener('open-helcim-checkout', (e) => {
    const token = e.detail?.checkoutToken;
    if (!token) return;

    if (typeof appendHelcimPayIframe === 'function') {
      appendHelcimPayIframe(token);
    } else {
      showAlert('warning', 'HelcimPay.js script could not be loaded by your browser. Please disable any ad-blocker or use Interac e-Transfer.');
    }
  });

  // Listen for HelcimPay.js postMessage completion events
  window.addEventListener('message', async (event) => {
    if (!event.data || !activeHelcimOrder) return;

    const msg = event.data;
    const eventName = String(msg.eventName || msg.event || '');
    const eventStatus = String(msg.eventStatus || msg.status || msg.data?.status || '').toUpperCase();

    const isSuccess = eventName.includes('helcimPayJsIdentifier') && eventStatus === 'SUCCESS'
      || eventName === 'helcimPayTransactionSuccess'
      || eventStatus === 'APPROVED';

    if (isSuccess) {
      if (typeof removeHelcimPayIframe === 'function') {
        try { removeHelcimPayIframe(); } catch (_) {}
      }

      showAlert('info', '<i class="bi bi-hourglass-split me-1"></i> Verifying payment and confirming your order...');

      try {
        const confirmRes = await fetch(apiEndpoint, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            action: 'confirm_helcim',
            ...activeHelcimOrder,
            transaction_data: typeof msg === 'object' ? msg : { raw: msg }
          })
        });
        const confirmData = await confirmRes.json();

        hideAlert();
        const txId = confirmData.data?.transaction_id || 'CONFIRMED';
        const acmLabel = confirmData.data?.acm_finish_label || activeHelcimOrder.acm_finish_label;
        const acrylicLabel = confirmData.data?.acrylic_finish_label || activeHelcimOrder.acrylic_finish_label;

        confirmPanel.className = 'confirmation-box bg-success bg-opacity-10 border border-success text-light';
        confirmPanel.innerHTML = `
          <div class="d-flex align-items-center gap-2 text-success fw-bold mb-2">
            <i class="bi bi-check-circle-fill fs-4"></i>
            <span>Payment Approved &mdash; Order Confirmed!</span>
          </div>
          <p class="small text-light mb-2">
            Thank you, <strong>${activeHelcimOrder.customer_name}</strong>! Your custom 3D plaque is now queued for laser production in Charlottetown.
          </p>
          <div class="p-3 rounded-3 bg-dark bg-opacity-75 small font-monospace mb-2">
            <div><strong>Order Reference:</strong> ${activeHelcimOrder.order_number}</div>
            <div><strong>Helcim Tx ID:</strong> ${txId}</div>
            <div><strong>Front Plate (ACM):</strong> ${acmLabel}</div>
            <div><strong>3D Digits (Acrylic):</strong> ${acrylicLabel}</div>
            <div><strong>Size:</strong> ${activeHelcimOrder.size_label}</div>
            <div><strong>Total Paid:</strong> $${Number(activeHelcimOrder.total_cad).toFixed(2)} CAD (incl. 15% HST)</div>
          </div>
          <div class="small text-secondary">
            A confirmation copy has been sent to our production team.
          </div>
        `;
        confirmPanel.classList.remove('d-none');
        activeHelcimOrder = null;
      } catch (err) {
        showAlert('warning', 'Payment completed, please save your order reference: <strong>' + activeHelcimOrder.order_number + '</strong>.');
      }
    }
  });

  // 2. Order via Interac e-Transfer
  btnInterac.addEventListener('click', async () => {
    hideAlert();
    const payload = getCustomerPayload('interac');
    if (!payload) return;

    btnHelcim.disabled = true;
    btnInterac.disabled = true;
    spinnerInterac.classList.remove('d-none');

    try {
      const response = await fetch(apiEndpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      const result = await response.json();

      spinnerInterac.classList.add('d-none');
      btnHelcim.disabled = false;
      btnInterac.disabled = false;

      if (!result.success) {
        showAlert('danger', '<i class="bi bi-x-circle-fill me-1"></i> ' + (result.message || 'Unable to submit order.'));
        return;
      }

      const d = result.data;
      const acmFallback = (CATALOG.acm_finishes[payload.acm_finish] || {}).name || payload.acm_finish;
      const acrylicFallback = (CATALOG.acrylic_finishes[payload.acrylic_finish] || {}).name || payload.acrylic_finish;
      const sizeFallback = (CATALOG.sizes[payload.size] || {}).label || payload.size;

      confirmPanel.className = 'confirmation-box bg-warning bg-opacity-10 border border-warning text-light';
      confirmPanel.innerHTML = `
        <div class="d-flex align-items-center gap-2 text-warning fw-bold mb-2">
          <i class="bi bi-bank2 fs-4"></i>
          <span>Order Reserved &mdash; Interac e-Transfer Instructions</span>
        </div>
        <p class="small text-light mb-2">
          Your custom 3D plaque order has been registered in our production portal. To start fabrication, please send an <strong>Interac e-Transfer</strong> with the details below:
        </p>
        <div class="p-3 rounded-3 bg-dark bg-opacity-75 small mb-2">
          <div class="mb-1"><span class="text-secondary">Recipient Email:</span> <strong class="text-warning font-monospace">${d.interac_email || 'contact@pixellaserprints.ca'}</strong></div>
          <div class="mb-1"><span class="text-secondary">Amount (incl. 15% PEI HST):</span> <strong class="text-info fs-6">$${Number(d.total_cad).toFixed(2)} CAD</strong></div>
          <div class="mb-1"><span class="text-secondary">Message / Reference #:</span> <strong class="text-white font-monospace">${d.order_number}</strong></div>
          <hr class="border-secondary border-opacity-25 my-2">
          <div class="mb-1"><span class="text-secondary">Front Plate (ACM):</span> <strong class="text-light">${d.acm_finish_label || acmFallback}</strong></div>
          <div class="mb-1"><span class="text-secondary">3D Digits (Acrylic):</span> <strong class="text-light">${d.acrylic_finish_label || acrylicFallback}</strong></div>
          <div><span class="text-secondary">Size:</span> <strong class="text-light">${d.size_label || sizeFallback}</strong></div>
        </div>
        <div class="small text-secondary">
          <i class="bi bi-info-circle me-1"></i> Auto-deposit is enabled. Include your order number <strong>${d.order_number}</strong> in the transfer message.
        </div>
      `;
      confirmPanel.classList.remove('d-none');
      confirmPanel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

    } catch (err) {
      spinnerInterac.classList.add('d-none');
      btnHelcim.disabled = false;
      btnInterac.disabled = false;
      showAlert('danger', '<i class="bi bi-x-circle-fill me-1"></i> Network error submitting your order. Please try again.');
    }
  });
</script>

<?php include '../includes/footer.php'; ?>
