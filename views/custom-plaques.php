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
          Interactive multi-layer laser-cut acrylic, brushed metal &amp; hardwood signage with floating standoffs.
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
                  <div class="fw-bold text-white" id="summary-finish-name">Matte Black + Brushed Aluminum</div>
                  <div class="small text-secondary" id="summary-size-dims">Medium (10" &times; 15" / 25 &times; 38 cm) &bull; 4 Corner Standoffs Included</div>
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

            <!-- 3. PBR Finishes -->
            <div class="mb-4">
              <div class="config-section-label">
                <span>3. Architectural Material &amp; Finish</span>
              </div>
              <div class="finish-grid">
                <!-- Finish 1 -->
                <div class="choice-tile active" data-finish="matte_black_aluminum">
                  <div class="swatch-duo">
                    <span class="swatch-circle" style="background: #18181b;"></span>
                    <span class="swatch-circle secondary" style="background: linear-gradient(135deg, #f1f5f9, #94a3b8);"></span>
                  </div>
                  <div class="fw-bold small">Matte Black + Aluminum</div>
                  <div class="text-secondary" style="font-size: 0.72rem;">Brushed silver 3D relief</div>
                </div>

                <!-- Finish 2 -->
                <div class="choice-tile" data-finish="walnut_black">
                  <div class="swatch-duo">
                    <span class="swatch-circle" style="background: linear-gradient(135deg, #7c4a21, #4a2c11);"></span>
                    <span class="swatch-circle secondary" style="background: #141417;"></span>
                  </div>
                  <div class="fw-bold small">Natural Walnut + Black</div>
                  <div class="text-secondary" style="font-size: 0.72rem;">Hardwood base &amp; black acrylic</div>
                </div>

                <!-- Finish 3 -->
                <div class="choice-tile" data-finish="stainless_black">
                  <div class="swatch-duo">
                    <span class="swatch-circle" style="background: linear-gradient(135deg, #e2e8f0, #64748b);"></span>
                    <span class="swatch-circle secondary" style="background: #0f172a;"></span>
                  </div>
                  <div class="fw-bold small">Brushed Stainless + Black</div>
                  <div class="text-secondary" style="font-size: 0.72rem;">Steel base &amp; matte black letters</div>
                </div>

                <!-- Finish 4 -->
                <div class="choice-tile" data-finish="frosted_brass">
                  <div class="swatch-duo">
                    <span class="swatch-circle" style="background: rgba(241, 245, 249, 0.75);"></span>
                    <span class="swatch-circle secondary" style="background: linear-gradient(135deg, #fde047, #b45309);"></span>
                  </div>
                  <div class="fw-bold small">Frosted Acrylic + Brass</div>
                  <div class="text-secondary" style="font-size: 0.72rem;">Translucent glass look &amp; gold brass</div>
                </div>
              </div>
            </div>

            <!-- 4. Size Selector -->
            <div class="mb-4">
              <div class="config-section-label">
                <span>4. Plaque Size (CAD)</span>
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

            <!-- 5. Customer Information -->
            <div class="mb-4">
              <div class="config-section-label">
                <span>5. Customer &amp; Order Details</span>
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
  import { TextGeometry } from 'three/addons/geometries/TextGeometry.js';

  // ─── Reactive Configurator State ───────────────────────────────────────
  const state = {
    plaque_type: 'house',
    primary_text: '428',
    subtitle_text: 'QUEEN ST',
    finish: 'matte_black_aluminum',
    size: 'medium',
    exploded: false,
    subtotal_cad: 60.00,
    hst_cad: 9.00,
    total_cad: 69.00
  };

  const CATALOG = {
    sizes: {
      small:       { price: 55.00, label: 'Small (10" × 13" / 25 × 33 cm)',       shortLabel: 'Small (10" × 13")',       w: 4.20, h: 3.20 },
      medium:      { price: 60.00, label: 'Medium (10" × 15" / 25 × 38 cm)',      shortLabel: 'Medium (10" × 15")',      w: 4.80, h: 3.20 },
      large:       { price: 70.00, label: 'Large (10" × 17" / 25 × 43 cm)',       shortLabel: 'Large (10" × 17")',       w: 5.44, h: 3.20 },
      extra_large: { price: 80.00, label: 'Extra Large (10" × 23.5" / 25 × 60 cm)', shortLabel: 'XL (10" × 23.5")',        w: 7.52, h: 3.20 },
      vertical:    { price: 55.00, label: 'Vertical (5" × 17" / 13 × 43 cm)',    shortLabel: 'Vertical (5" × 17")',    w: 2.10, h: 6.40, isVertical: true }
    },
    finishes: {
      matte_black_aluminum: {
        name: 'Matte Black + Brushed Aluminum',
        baseColor: 0x16181d,
        baseRoughness: 0.72,
        baseMetalness: 0.12,
        baseTransmission: 0,
        baseOpacity: 1.0,
        accentColor: 0xe2e8f0,
        accentRoughness: 0.24,
        accentMetalness: 0.90,
        standoffColor: 0xdbeafe
      },
      walnut_black: {
        name: 'Natural Walnut + Matte Black',
        baseColor: 0x6e4726,
        baseRoughness: 0.55,
        baseMetalness: 0.05,
        baseTransmission: 0,
        baseOpacity: 1.0,
        isWood: true,
        accentColor: 0x141619,
        accentRoughness: 0.38,
        accentMetalness: 0.15,
        standoffColor: 0x1f242d
      },
      stainless_black: {
        name: 'Brushed Stainless + Black',
        baseColor: 0xcbd5e1,
        baseRoughness: 0.24,
        baseMetalness: 0.92,
        baseTransmission: 0,
        baseOpacity: 1.0,
        isBrushedMetal: true,
        accentColor: 0x111827,
        accentRoughness: 0.42,
        accentMetalness: 0.15,
        standoffColor: 0xe2e8f0
      },
      frosted_brass: {
        name: 'Frosted Acrylic + Brass',
        baseColor: 0xf1f5f9,
        baseRoughness: 0.25,
        baseMetalness: 0.05,
        baseTransmission: 0.55,
        baseOpacity: 0.86,
        accentColor: 0xd4af37,
        accentRoughness: 0.22,
        accentMetalness: 0.94,
        standoffColor: 0xd4af37
      }
    }
  };

  // ─── Procedural Textures (Wood Grain & Brushed Metal) ──────────────────
  function createWoodTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 512;
    canvas.height = 512;
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = '#6e4726';
    ctx.fillRect(0, 0, 512, 512);
    for (let i = 0; i < 160; i++) {
      ctx.fillStyle = i % 2 === 0 ? 'rgba(55, 30, 12, 0.16)' : 'rgba(145, 95, 50, 0.12)';
      const y = Math.random() * 512;
      const h = 2 + Math.random() * 8;
      ctx.fillRect(0, y, 512, h);
    }
    const tex = new THREE.CanvasTexture(canvas);
    tex.wrapS = THREE.RepeatWrapping;
    tex.wrapT = THREE.RepeatWrapping;
    return tex;
  }

  function createBrushedMetalTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 512;
    canvas.height = 512;
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = '#cbd5e1';
    ctx.fillRect(0, 0, 512, 512);
    for (let i = 0; i < 400; i++) {
      const shade = 185 + Math.floor(Math.random() * 55);
      ctx.fillStyle = `rgba(${shade}, ${shade}, ${shade + 5}, 0.22)`;
      ctx.fillRect(0, Math.random() * 512, 512, 1 + Math.random() * 2);
    }
    const tex = new THREE.CanvasTexture(canvas);
    return tex;
  }

  const woodTexture = createWoodTexture();
  const brushedTexture = createBrushedMetalTexture();

  // ─── Three.js Scene Setup ──────────────────────────────────────────────
  const container = document.getElementById('plaque-canvas-container');
  const scene = new THREE.Scene();

  const camera = new THREE.PerspectiveCamera(36, container.clientWidth / container.clientHeight, 0.1, 100);
  camera.position.set(0, 0.15, 8.8);

  const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
  renderer.setSize(container.clientWidth, container.clientHeight);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.shadowMap.enabled = true;
  renderer.shadowMap.type = THREE.PCFSoftShadowMap;
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  renderer.toneMappingExposure = 1.15;
  container.appendChild(renderer.domElement);

  const controls = new OrbitControls(camera, renderer.domElement);
  controls.enableDamping = true;
  controls.dampingFactor = 0.06;
  controls.minDistance = 4.2;
  controls.maxDistance = 14.5;
  controls.maxPolarAngle = Math.PI * 0.85;

  // Studio Lighting
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.85);
  scene.add(ambientLight);

  const keyLight = new THREE.DirectionalLight(0xfffbeb, 2.2);
  keyLight.position.set(5, 7, 6);
  keyLight.castShadow = true;
  keyLight.shadow.mapSize.width = 2048;
  keyLight.shadow.mapSize.height = 2048;
  keyLight.shadow.bias = -0.0005;
  scene.add(keyLight);

  const fillLight = new THREE.DirectionalLight(0x93c5fd, 1.1);
  fillLight.position.set(-6, 3, 4);
  scene.add(fillLight);

  const rimLight = new THREE.DirectionalLight(0xfde047, 0.75);
  rimLight.position.set(0, -5, -4);
  scene.add(rimLight);

  // Subtle architectural wall shadow plane behind the plaque
  const wallGeo = new THREE.PlaneGeometry(24, 16);
  const wallMat = new THREE.ShadowMaterial({ opacity: 0.28 });
  const wallMesh = new THREE.Mesh(wallGeo, wallMat);
  wallMesh.position.z = -0.55;
  wallMesh.receiveShadow = true;
  scene.add(wallMesh);

  // ─── Multi-Layer Plaque Hierarchy ──────────────────────────────────────
  const rootGroup = new THREE.Group();
  scene.add(rootGroup);

  const backplateLayer = new THREE.Group();
  const standoffsRearLayer = new THREE.Group();
  const trimFrameLayer = new THREE.Group();
  const textReliefLayer = new THREE.Group();
  const standoffsCapLayer = new THREE.Group();

  rootGroup.add(backplateLayer);
  rootGroup.add(standoffsRearLayer);
  rootGroup.add(trimFrameLayer);
  rootGroup.add(textReliefLayer);
  rootGroup.add(standoffsCapLayer);

  let loadedFont = null;

  // Rounded rectangle helper shape
  function createRoundedRectShape(width, height, radius) {
    const shape = new THREE.Shape();
    const x = -width / 2;
    const y = -height / 2;
    shape.moveTo(x, y + radius);
    shape.lineTo(x, y + height - radius);
    shape.quadraticCurveTo(x, y + height, x + radius, y + height);
    shape.lineTo(x + width - radius, y + height);
    shape.quadraticCurveTo(x + width, y + height, x + width, y + height - radius);
    shape.lineTo(x + width, y + radius);
    shape.quadraticCurveTo(x + width, y, x + width - radius, y);
    shape.lineTo(x + radius, y);
    shape.quadraticCurveTo(x, y, x, y + radius);
    return shape;
  }

  function clearGroup(group) {
    while (group.children.length > 0) {
      const child = group.children[0];
      if (child.geometry) child.geometry.dispose();
      group.remove(child);
    }
  }

  function buildPlaqueModel() {
    clearGroup(backplateLayer);
    clearGroup(standoffsRearLayer);
    clearGroup(trimFrameLayer);
    clearGroup(textReliefLayer);
    clearGroup(standoffsCapLayer);

    const sizeSpec = CATALOG.sizes[state.size] || CATALOG.sizes.medium;
    const finishSpec = CATALOG.finishes[state.finish] || CATALOG.finishes.matte_black_aluminum;
    const isVertical = Boolean(sizeSpec.isVertical || state.size === 'vertical');

    const width = isVertical ? sizeSpec.w : (state.plaque_type === 'business' ? sizeSpec.w * 1.08 : sizeSpec.w);
    const height = isVertical ? sizeSpec.h : (state.plaque_type === 'business' ? sizeSpec.h * 0.95 : sizeSpec.h);
    const cornerRadius = 0.28;

    // Materials
    const baseMaterial = new THREE.MeshPhysicalMaterial({
      color: finishSpec.baseColor,
      roughness: finishSpec.baseRoughness,
      metalness: finishSpec.baseMetalness,
      transmission: finishSpec.baseTransmission || 0,
      transparent: (finishSpec.baseOpacity ?? 1) < 1,
      opacity: finishSpec.baseOpacity ?? 1.0,
      thickness: 0.3,
      map: finishSpec.isWood ? woodTexture : (finishSpec.isBrushedMetal ? brushedTexture : null),
      clearcoat: finishSpec.baseTransmission ? 0.6 : 0.15,
      clearcoatRoughness: 0.25
    });

    const accentMaterial = new THREE.MeshStandardMaterial({
      color: finishSpec.accentColor,
      roughness: finishSpec.accentRoughness,
      metalness: finishSpec.accentMetalness
    });

    const standoffMaterial = new THREE.MeshStandardMaterial({
      color: finishSpec.standoffColor,
      roughness: 0.2,
      metalness: 0.92
    });

    // 1. Base Backplate
    const baseShape = createRoundedRectShape(width, height, cornerRadius);
    const baseGeo = new THREE.ExtrudeGeometry(baseShape, {
      depth: 0.16,
      bevelEnabled: true,
      bevelThickness: 0.03,
      bevelSize: 0.03,
      bevelSegments: 4
    });
    baseGeo.center();
    const baseMesh = new THREE.Mesh(baseGeo, baseMaterial);
    baseMesh.castShadow = true;
    baseMesh.receiveShadow = true;
    backplateLayer.add(baseMesh);

    // 2. Inner Raised Architectural Border / Accent Frame
    const frameOuter = createRoundedRectShape(width - 0.36, height - 0.36, cornerRadius * 0.75);
    const frameInner = createRoundedRectShape(width - 0.48, height - 0.48, cornerRadius * 0.65);
    frameOuter.holes.push(frameInner);
    const frameGeo = new THREE.ExtrudeGeometry(frameOuter, {
      depth: 0.045,
      bevelEnabled: true,
      bevelThickness: 0.01,
      bevelSize: 0.01,
      bevelSegments: 2
    });
    frameGeo.center();
    const frameMesh = new THREE.Mesh(frameGeo, accentMaterial);
    frameMesh.position.z = 0.11;
    frameMesh.castShadow = true;
    trimFrameLayer.add(frameMesh);

    // 3. Four Corner Metallic Standoffs
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

    const capGeo = new THREE.CylinderGeometry(0.14, 0.14, 0.09, 28);
    capGeo.rotateX(Math.PI / 2);

    corners.forEach(([cx, cy]) => {
      const barrel = new THREE.Mesh(barrelGeo, standoffMaterial);
      barrel.position.set(cx, cy, -0.25);
      barrel.castShadow = true;
      standoffsRearLayer.add(barrel);

      const cap = new THREE.Mesh(capGeo, standoffMaterial);
      cap.position.set(cx, cy, 0.15);
      cap.castShadow = true;
      standoffsCapLayer.add(cap);
    });

    // 4. 3D Extruded Primary Text & Subtitle Text
    const primaryStr = (state.primary_text || '428').trim().toUpperCase();
    const subtitleStr = (state.subtitle_text || '').trim().toUpperCase();

    if (loadedFont) {
      // Dynamic font sizing so long business names fit gracefully inside the plaque
      const maxTextWidth = isVertical ? (width - 0.48) : (width - 1.15);
      let primaryFontSize = state.plaque_type === 'house' ? (isVertical ? 0.72 : 0.92) : 0.62;
      if (primaryStr.length > 6) {
        primaryFontSize = Math.max(0.24, primaryFontSize * (6.2 / primaryStr.length));
      }

      const primaryGeo = new TextGeometry(primaryStr, {
        font: loadedFont,
        size: primaryFontSize,
        height: 0.11,
        curveSegments: 8,
        bevelEnabled: true,
        bevelThickness: 0.018,
        bevelSize: 0.012,
        bevelSegments: 3
      });
      primaryGeo.computeBoundingBox();
      const pBox = primaryGeo.boundingBox;
      const pWidth = pBox.max.x - pBox.min.x;
      if (pWidth > maxTextWidth && pWidth > 0) {
        const scale = maxTextWidth / pWidth;
        primaryGeo.scale(scale, scale, 1);
      }
      primaryGeo.center();

      const primaryMesh = new THREE.Mesh(primaryGeo, accentMaterial);
      primaryMesh.position.y = isVertical ? (subtitleStr ? 0.95 : 0.0) : (subtitleStr ? 0.28 : 0.0);
      primaryMesh.position.z = 0.14;
      primaryMesh.castShadow = true;
      textReliefLayer.add(primaryMesh);

      if (subtitleStr) {
        let subSize = state.plaque_type === 'house' ? (isVertical ? 0.20 : 0.27) : 0.24;
        if (subtitleStr.length > 14) {
          subSize = Math.max(0.12, subSize * (14 / subtitleStr.length));
        }

        const subGeo = new TextGeometry(subtitleStr, {
          font: loadedFont,
          size: subSize,
          height: 0.08,
          curveSegments: 6,
          bevelEnabled: true,
          bevelThickness: 0.01,
          bevelSize: 0.008,
          bevelSegments: 2
        });
        subGeo.computeBoundingBox();
        const sBox = subGeo.boundingBox;
        const sWidth = sBox.max.x - sBox.min.x;
        if (sWidth > maxTextWidth && sWidth > 0) {
          const sScale = maxTextWidth / sWidth;
          subGeo.scale(sScale, sScale, 1);
        }
        subGeo.center();

        const subMesh = new THREE.Mesh(subGeo, accentMaterial);
        subMesh.position.y = isVertical ? -1.15 : -0.62;
        subMesh.position.z = 0.13;
        subMesh.castShadow = true;
        textReliefLayer.add(subMesh);

        // Decorative divider bar between primary & subtitle
        const dividerWidth = isVertical ? Math.min(width * 0.65, 1.1) : Math.min(width * 0.45, 2.4);
        const dividerShape = createRoundedRectShape(dividerWidth, 0.045, 0.02);
        const dividerGeo = new THREE.ExtrudeGeometry(dividerShape, { depth: 0.05, bevelEnabled: false });
        dividerGeo.center();
        const dividerMesh = new THREE.Mesh(dividerGeo, accentMaterial);
        dividerMesh.position.set(0, isVertical ? -0.10 : -0.24, 0.12);
        textReliefLayer.add(dividerMesh);
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
  const targetCameraPos = new THREE.Vector3(0, 0.15, 8.8);
  const targetControlsLook = new THREE.Vector3(0, 0, 0);
  let cameraAnimating = false;

  const CAM_PRESETS = {
    front:   { pos: [0, 0.05, 8.6],    look: [0, 0, 0] },
    angle:   { pos: [4.2, 2.1, 7.4],   look: [0, 0, 0] },
    profile: { pos: [7.6, 0.3, 2.2],   look: [0, 0, 0] },
    mounts:  { pos: [2.6, 1.65, 3.6],  look: [1.8, 1.0, 0] }
  };

  document.querySelectorAll('.cam-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.cam-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const preset = CAM_PRESETS[btn.dataset.cam] || CAM_PRESETS.front;
      targetCameraPos.set(...preset.pos);
      targetControlsLook.set(...preset.look);
      cameraAnimating = true;
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

    // Smooth Assembly View (Assembled vs Exploded Z-axis separation)
    const targetExplode = state.exploded ? 1.0 : 0.0;
    explodeProgress += (targetExplode - explodeProgress) * 0.09;

    backplateLayer.position.z     = -explodeProgress * 0.65;
    standoffsRearLayer.position.z = -explodeProgress * 1.25;
    trimFrameLayer.position.z     =  explodeProgress * 0.35;
    textReliefLayer.position.z    =  explodeProgress * 0.85;
    standoffsCapLayer.position.z  =  explodeProgress * 1.25;

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
    const finishSpec = CATALOG.finishes[state.finish] || CATALOG.finishes.matte_black_aluminum;

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

    document.getElementById('summary-finish-name').textContent = finishSpec.name;
    document.getElementById('summary-size-dims').textContent = sizeSpec.label + ' • 4 Corner Standoffs Included';

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

  // Finish Selection
  document.querySelectorAll('[data-finish]').forEach(tile => {
    tile.addEventListener('click', () => {
      document.querySelectorAll('[data-finish]').forEach(t => t.classList.remove('active'));
      tile.classList.add('active');
      state.finish = tile.dataset.finish;
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
    });
  });

  // Assembly Exploded View Toggle
  document.getElementById('assemblyToggle').addEventListener('change', (e) => {
    state.exploded = e.target.checked;
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
      finish: state.finish,
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

      activeHelcimOrder = {
        ...payload,
        order_id: result.data.order_id,
        order_number: result.data.order_number,
        subtotal_cad: result.data.subtotal_cad,
        hst_cad: result.data.hst_cad,
        total_cad: result.data.total_cad,
        finish_label: result.data.finish_label,
        size_label: result.data.size_label
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
          <div><span class="text-secondary">Message / Reference #:</span> <strong class="text-white font-monospace">${d.order_number}</strong></div>
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
