<?php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');
$pageTitle = "3D Custom Architectural Plaque & Signage Configurator - Pixel Laser Prints";
$pageDescription = "Design your custom 3D laser-cut architectural house number plaque or business signage in real time. Crafted in Charlottetown, PEI, Canada.";
include '../includes/header.php';
?>

<!-- Official HelcimPay.js Script -->
<script type="text/javascript" src="https://secure.helcim.app/helcim-pay/services/start.js"></script>

<!-- Architectural Fonts for Live Selector Preview & 3D Extrusion -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@700&family=Montserrat:wght@700&display=swap" rel="stylesheet">

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
    padding-top: 180px;
    padding-bottom: 64px;
    color: #f8fafc;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  @media (max-width: 991.98px) {
    .plaque-config-page {
      padding-top: 135px;
    }
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
    top: 24px;
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
    height: 510px;
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

  /* Real-World Environment Simulation Toolbar */
  .viewer-env-bar {
    background: linear-gradient(90deg, rgba(15, 23, 42, 0.95), rgba(30, 41, 59, 0.88));
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding: 10px 16px;
  }

  .env-btn-group {
    display: inline-flex;
    background: rgba(15, 23, 42, 0.82);
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 999px;
    padding: 3px;
    gap: 3px;
  }

  .env-btn {
    background: transparent;
    border: none;
    color: #94a3b8;
    font-size: 0.73rem;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 999px;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    user-select: none;
    line-height: 1.2;
    white-space: nowrap;
  }

  .env-btn:hover {
    color: #f8fafc;
    background: rgba(255, 255, 255, 0.08);
  }

  .env-btn.active {
    background: #0284c7;
    color: #ffffff;
    box-shadow: 0 2px 10px rgba(2, 132, 199, 0.45);
  }

  .price-breakdown-bar {
    background: rgba(15, 23, 42, 0.96);
    border-top: 1px solid rgba(255, 255, 255, 0.09);
    padding: 18px 22px;
  }

  /* ─── 4-Step Studio Right Panel Card ────────────────────────────────── */
  .design-panel-card {
    background: linear-gradient(160deg, rgba(15, 23, 42, 0.9), rgba(11, 16, 30, 0.95));
    border: 1px solid rgba(255, 255, 255, 0.11);
    border-radius: 24px;
    padding: 0;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    backdrop-filter: blur(14px);
    box-shadow: 0 24px 50px -15px rgba(0, 0, 0, 0.65);
  }

  .studio-stepper {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 6px;
    background: rgba(9, 13, 24, 0.72);
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    padding: 10px 12px;
  }

  .studio-step-tab {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    background: rgba(30, 41, 59, 0.35);
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 12px;
    padding: 8px 6px;
    color: #94a3b8;
    font-size: 0.78rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    user-select: none;
  }

  .studio-step-tab:hover {
    color: #e2e8f0;
    border-color: rgba(96, 165, 250, 0.4);
    background: rgba(30, 41, 59, 0.7);
  }

  .studio-step-tab .step-num {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.68rem;
    font-weight: 700;
    background: rgba(148, 163, 184, 0.16);
    color: #cbd5e1;
    flex-shrink: 0;
    transition: all 0.2s ease;
  }

  .studio-step-tab.visited .step-num {
    background: rgba(56, 189, 248, 0.22);
    color: #7dd3fc;
  }

  .studio-step-tab.active {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.24), rgba(14, 165, 233, 0.18));
    border-color: #3b82f6;
    color: #ffffff;
    box-shadow: 0 4px 14px -4px rgba(59, 130, 246, 0.45);
  }

  .studio-step-tab.active .step-num {
    background: #3b82f6;
    color: #ffffff;
    box-shadow: 0 0 8px rgba(59, 130, 246, 0.7);
  }

  .studio-step-tab.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 20%;
    right: 20%;
    height: 2px;
    background: linear-gradient(90deg, #38bdf8, #3b82f6);
    border-radius: 999px;
    box-shadow: 0 0 8px rgba(56, 189, 248, 0.75);
  }

  .studio-alert-slot {
    padding: 0 22px;
  }

  .studio-alert-slot .alert {
    margin-top: 14px;
    margin-bottom: 0 !important;
  }

  .studio-step-body {
    padding: 20px 22px;
  }

  .studio-step-pane {
    animation: stepFadeIn 0.2s ease-out;
  }

  @keyframes stepFadeIn {
    from {
      opacity: 0;
      transform: translateY(5px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .studio-step-footer {
    background: rgba(9, 13, 24, 0.85);
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    padding: 14px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
  }

  .btn-step-prev {
    background: rgba(30, 41, 59, 0.65);
    border: 1px solid rgba(255, 255, 255, 0.14);
    color: #cbd5e1;
    border-radius: 12px;
    padding: 9px 15px;
    font-size: 0.82rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    cursor: pointer;
  }

  .btn-step-prev:hover {
    background: rgba(51, 65, 85, 0.85);
    color: #ffffff;
    border-color: rgba(255, 255, 255, 0.25);
  }

  .btn-step-next {
    background: linear-gradient(135deg, #2563eb 0%, #0284c7 100%);
    border: none;
    color: #ffffff;
    border-radius: 12px;
    padding: 10px 18px;
    font-size: 0.84rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.55);
    transition: all 0.2s ease;
    cursor: pointer;
  }

  .btn-step-next:hover {
    transform: translateY(-1px);
    background: linear-gradient(135deg, #3b82f6 0%, #0ea5e9 100%);
    color: #ffffff;
  }

  .config-section-label {
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #94a3b8;
    font-weight: 700;
    margin-bottom: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .type-segmented-pill {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
    background: rgba(9, 13, 24, 0.65);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 14px;
    padding: 5px;
  }

  .type-segmented-pill .choice-tile {
    padding: 10px 12px;
    border-radius: 10px;
    border-color: transparent;
    background: transparent;
  }

  .type-segmented-pill .choice-tile:hover {
    background: rgba(30, 41, 59, 0.65);
    border-color: rgba(96, 165, 250, 0.3);
  }

  .type-segmented-pill .choice-tile.active {
    background: rgba(37, 99, 235, 0.22);
    border-color: #3b82f6;
  }

  .choice-tile {
    background: rgba(30, 41, 59, 0.65);
    border: 1.5px solid rgba(255, 255, 255, 0.1);
    border-radius: 14px;
    padding: 12px 14px;
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

  .acm-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
  }

  .acrylic-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
  }

  .sintra-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
  }

  .standoff-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
  }

  .swatch-tile-compact {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
  }

  .swatch-single {
    display: inline-block;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.28);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.45);
    flex-shrink: 0;
    margin-bottom: 0;
  }

  .materials-live-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(15, 23, 42, 0.8);
    border: 1px solid rgba(56, 189, 248, 0.24);
    border-radius: 12px;
    padding: 8px 12px;
    font-size: 0.75rem;
    color: #cbd5e1;
    margin-bottom: 14px;
  }

  .sintra-selector-muted {
    opacity: 0.78;
    transition: opacity 0.2s ease;
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

  .construction-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
  }

  .font-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
  }

  .font-tile-compact {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 14px;
  }

  .font-preview-sample {
    font-size: 1.45rem;
    line-height: 1;
    color: #f8fafc;
    letter-spacing: 1px;
    margin-bottom: 0;
    flex-shrink: 0;
  }

  /* Step 3: Proportional 2-Column Size Grid + Craft Highlights */
  .size-grid-studio {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }

  .size-grid-studio .choice-tile[data-size="vertical"] {
    grid-column: 1 / -1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    text-align: left;
  }

  .size-ratio-wrap {
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 6px;
  }

  .size-grid-studio .choice-tile[data-size="vertical"] .size-ratio-wrap {
    margin-bottom: 0;
    height: 36px;
    width: 32px;
  }

  .size-ratio-box {
    border: 1.5px solid rgba(148, 163, 184, 0.55);
    background: rgba(15, 23, 42, 0.65);
    border-radius: 3px;
    transition: all 0.2s ease;
  }

  .choice-tile.active .size-ratio-box {
    border-color: #38bdf8;
    background: rgba(56, 189, 248, 0.2);
    box-shadow: 0 0 10px rgba(56, 189, 248, 0.35);
  }

  .craft-highlights-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
    margin-top: 14px;
  }

  .craft-highlight-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(15, 23, 42, 0.65);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    padding: 9px 11px;
    font-size: 0.72rem;
    color: #cbd5e1;
  }

  .delivery-toggle-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }

  .shipping-fields-panel {
    animation: fadeInSlide 0.25s ease-out;
  }

  @keyframes fadeInSlide {
    from {
      opacity: 0;
      transform: translateY(-6px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .precheckout-summary-card {
    background: rgba(15, 23, 42, 0.72);
    border: 1px solid rgba(59, 130, 246, 0.25);
    border-radius: 14px;
    padding: 12px 14px;
    margin-bottom: 14px;
  }

  @media (max-width: 575.98px) {
    .studio-step-tab {
      font-size: 0.72rem;
      padding: 7px 4px;
      gap: 4px;
    }
    .studio-step-tab .step-num {
      width: 18px;
      height: 18px;
      font-size: 0.64rem;
    }
    .studio-step-body {
      padding: 16px;
    }
    .studio-step-footer {
      padding: 12px 16px;
    }
    .acm-grid,
    .standoff-grid {
      grid-template-columns: 1fr 1fr;
    }
    .delivery-toggle-grid,
    .type-segmented-pill,
    .craft-highlights-grid,
    .font-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 479.98px) {
    .construction-grid {
      grid-template-columns: 1fr;
    }
  }

  .config-input {
    background: rgba(15, 23, 42, 0.9) !important;
    border: 1.5px solid rgba(255, 255, 255, 0.14) !important;
    color: #ffffff !important;
    border-radius: 12px !important;
    padding: 10px 13px !important;
    font-size: 0.92rem !important;
  }

  .config-input:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
  }

  .config-input::placeholder {
    color: #64748b !important;
  }

  .payment-method-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
  }

  @media (max-width: 575.98px) {
    .payment-method-grid {
      grid-template-columns: 1fr;
    }
  }

  .btn-primary-checkout {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: #ffffff;
    border: none;
    border-radius: 14px;
    padding: 14px 20px;
    font-weight: 700;
    font-size: 0.98rem;
    transition: all 0.25s ease;
    box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.5);
  }

  .btn-primary-checkout:hover:not(:disabled) {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    box-shadow: 0 14px 28px -5px rgba(59, 130, 246, 0.6);
    color: #ffffff;
  }

  .btn-primary-checkout.mode-interac {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    box-shadow: 0 10px 25px -5px rgba(217, 119, 6, 0.45);
  }

  .btn-primary-checkout.mode-interac:hover:not(:disabled) {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    box-shadow: 0 14px 28px -5px rgba(245, 158, 11, 0.55);
    color: #ffffff;
  }

  .btn-helcim-pay {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: #ffffff;
    border: none;
    border-radius: 14px;
    padding: 13px 20px;
    font-weight: 700;
    font-size: 0.96rem;
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
    padding: 12px 20px;
    font-weight: 600;
    font-size: 0.94rem;
    transition: all 0.2s ease;
  }

  .btn-interac-pay:hover:not(:disabled) {
    background: rgba(51, 65, 85, 0.95);
    border-color: #f59e0b;
    color: #ffffff;
  }

  .confirmation-box {
    border-radius: 16px;
    padding: 18px;
    margin-top: 16px;
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
    <!-- Testing Notice Banner -->
    <div class="alert border-0 rounded-4 shadow-sm mb-4 p-3 d-flex align-items-center gap-3" style="background: rgba(212, 175, 55, 0.12); border-left: 4px solid #D4AF37 !important; color: #f8fafc;">
      <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background: rgba(212, 175, 55, 0.2); color: #f3d467;">
        <i class="bi bi-tools fs-5"></i>
      </div>
      <div>
        <div class="fw-semibold text-warning" style="font-size: 0.88rem; letter-spacing: 0.04em;">
          3D STUDIO TESTING IN PROGRESS
        </div>
        <div class="small text-secondary" style="font-size: 0.82rem;">
          We are currently fine-tuning and testing our 3D configurator experience. You can explore the interactive 3D viewer and finishes while we prepare the official launch.
        </div>
      </div>
    </div>

    <!-- Header Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
      <div>
        <h1 class="fw-bold mb-1" style="font-size: clamp(1.6rem, 2.8vw, 2.35rem);">
          3D Architectural Plaque &amp; Signage Studio
        </h1>
        <p class="text-secondary mb-0 small">
          Real multi-layer architectural signage: ACM front plate, 6mm Sintra PVC backer &amp; 3D laser-cut acrylic lettering with 2 lateral standoffs.
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
            <!-- Architectural Environment Simulation Bar -->
            <div class="viewer-env-bar d-flex align-items-center justify-content-between flex-wrap gap-2">
              <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="small text-secondary text-uppercase fw-bold d-flex align-items-center" style="font-size: 0.69rem; letter-spacing: 0.8px;">
                  <i class="bi bi-eye-fill text-info me-1"></i> Real Environment:
                </span>
                <div class="env-btn-group" role="group" aria-label="Preview in real-world environment">
                  <button type="button" class="env-btn active" data-env="studio" title="Neutral 3D studio backdrop">
                    <i class="bi bi-display me-1"></i> Studio
                  </button>
                  <button type="button" class="env-btn" data-env="casa" title="Modern residential siding facade with wall sconce">
                    <i class="bi bi-house-door-fill me-1"></i> House Facade
                  </button>
                  <button type="button" class="env-btn" data-env="barda" title="Stacked stone perimeter wall with concrete coping">
                    <i class="bi bi-bricks me-1"></i> Stone Wall
                  </button>
                  <button type="button" class="env-btn" data-env="entrada" title="Modern entrance door with stainless pull bar & doorbell">
                    <i class="bi bi-door-closed-fill me-1"></i> Front Entry
                  </button>
                </div>
              </div>
              <span class="small text-secondary d-none d-md-inline" id="env-description-hint" style="font-size: 0.72rem;">
                Neutral 3D studio backdrop
              </span>
            </div>

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
                Back &rarr; Front: <strong>1. Rear Standoffs</strong> &rarr; <strong>2. Solid ACM Plate</strong> &rarr; <strong>3. Raised Acrylic Digits</strong> &rarr; <strong>4. Front Caps</strong>
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
                  <div class="fw-bold text-white" id="summary-finish-name">Raised 3D Acrylic &bull; Matte Black ACM + Mirror Gold</div>
                  <div class="small text-secondary" id="summary-size-dims">Medium (10" &times; 15") &bull; Athletic Block &bull; 2 Lateral Silver Standoffs</div>
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

      <!-- RIGHT COLUMN: 4-Step Interactive Studio Panel -->
      <div class="col-lg-5">
        <div class="design-panel-card">
          <!-- Sticky 4-Step Navigation Bar -->
          <div class="studio-stepper" role="tablist" aria-label="Configuration Steps">
            <button type="button" class="studio-step-tab active" data-step="1" role="tab" aria-selected="true">
              <span class="step-num">1</span>
              <span>Design</span>
            </button>
            <button type="button" class="studio-step-tab" data-step="2" role="tab" aria-selected="false">
              <span class="step-num">2</span>
              <span>Materials</span>
            </button>
            <button type="button" class="studio-step-tab" data-step="3" role="tab" aria-selected="false">
              <span class="step-num">3</span>
              <span>Size</span>
            </button>
            <button type="button" class="studio-step-tab" data-step="4" role="tab" aria-selected="false">
              <span class="step-num">4</span>
              <span>Order</span>
            </button>
          </div>

          <!-- Global Validation / Status Alert (Always visible across step switches) -->
          <div class="studio-alert-slot">
            <div id="checkoutAlertBox" class="alert d-none py-2 small rounded-3"></div>
          </div>

          <form id="plaqueConfigForm" onsubmit="return false;">
            <div class="studio-step-body">

              <!-- ══ STEP 1: DESIGN & TYPOGRAPHY ══════════════════════════════ -->
              <div class="studio-step-pane" data-step-pane="1">
                <!-- Plaque Style (Compact Segmented Pill) -->
                <div class="mb-3">
                  <div class="config-section-label">
                    <span>Plaque Style</span>
                    <span class="text-info">Laser-Cut Multi-Layer</span>
                  </div>
                  <div class="type-segmented-pill">
                    <div class="choice-tile active" data-type="house" id="tile-type-house">
                      <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="fw-bold small d-flex align-items-center gap-2">
                          <i class="bi bi-house-door-fill text-info"></i> House Number
                        </span>
                        <span class="badge bg-info bg-opacity-10 text-info" style="font-size: 0.65rem;">Residential</span>
                      </div>
                      <div class="text-secondary" style="font-size: 0.71rem;">Civic number + street name</div>
                    </div>

                    <div class="choice-tile" data-type="business" id="tile-type-business">
                      <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="fw-bold small d-flex align-items-center gap-2">
                          <i class="bi bi-building-fill text-info"></i> Business / Office
                        </span>
                        <span class="badge bg-primary bg-opacity-25 text-light" style="font-size: 0.65rem;">Commercial</span>
                      </div>
                      <div class="text-secondary" style="font-size: 0.71rem;">Company title + suite / city</div>
                    </div>
                  </div>
                </div>

                <!-- Construction Style -->
                <div class="mb-3">
                  <div class="config-section-label">
                    <span>Construction Style</span>
                    <span class="text-secondary">Fabrication Method</span>
                  </div>
                  <div class="construction-grid">
                    <div class="choice-tile active" data-construction-style="raised_acrylic">
                      <div class="d-flex align-items-center justify-content-between mb-1 gap-1">
                        <i class="bi bi-box-fill text-info"></i>
                        <span class="badge bg-secondary bg-opacity-25 text-light" style="font-size: 0.65rem;">Base Price</span>
                      </div>
                      <div class="fw-bold small">Raised 3D Acrylic</div>
                      <div class="text-secondary" style="font-size: 0.7rem;">Solid ACM plate + surface 3D digits</div>
                    </div>

                    <div class="choice-tile" data-construction-style="cnc_cut_acm">
                      <div class="d-flex align-items-center justify-content-between mb-1 gap-1">
                        <i class="bi bi-layers-fill text-warning"></i>
                        <span class="badge bg-warning bg-opacity-25 text-warning" id="cnc-surcharge-badge" style="font-size: 0.65rem;">+$10 CAD</span>
                      </div>
                      <div class="fw-bold small">CNC Cut ACM + Inlaid</div>
                      <div class="text-secondary" style="font-size: 0.7rem;">6mm Sintra backer + CNC cutouts</div>
                    </div>
                  </div>
                </div>

                <!-- Custom 3D Lettering -->
                <div class="mb-3">
                  <div class="config-section-label">
                    <span>3D Raised Lettering</span>
                    <span id="char-counter" class="text-secondary">3 / 24</span>
                  </div>
                  <div class="mb-2">
                    <label for="primaryTextInput" class="form-label small text-light mb-1">Primary 3D Text <span class="text-danger">*</span></label>
                    <input type="text" id="primaryTextInput" class="form-control config-input fw-bold"
                           value="428" maxlength="24" placeholder="e.g. 428 or POU TECH" required>
                  </div>
                  <div id="subtitleInputGroup">
                    <label for="subtitleTextInput" class="form-label small text-light mb-1">Subtitle / Street / Suite <span class="text-secondary fw-normal">(Optional)</span></label>
                    <input type="text" id="subtitleTextInput" class="form-control config-input"
                           value="QUEEN ST" maxlength="32" placeholder="e.g. QUEEN ST or CHARLOTTETOWN">
                    <div id="subtitle-vertical-hint" class="small text-info mt-1 d-none" style="font-size: 0.72rem;">
                      <i class="bi bi-info-circle-fill me-1"></i> Vertical Column uses the entire vertical length for civic numbers (subtitle omitted).
                    </div>
                  </div>
                </div>

                <!-- Typography / Font Style -->
                <div>
                  <div class="config-section-label">
                    <span>Typography / Font Style</span>
                    <span class="text-secondary">Laser / CNC Font</span>
                  </div>
                  <div class="font-grid">
                    <div class="choice-tile font-tile-compact active" data-font-style="athletic_block">
                      <div class="font-preview-sample" style="font-family: 'Chakra Petch', sans-serif; font-weight: 700;">428</div>
                      <div>
                        <div class="fw-bold small">Athletic Block</div>
                        <div class="text-secondary" style="font-size: 0.69rem;">45&deg; octagonal block</div>
                      </div>
                    </div>

                    <div class="choice-tile font-tile-compact" data-font-style="modern_sans">
                      <div class="font-preview-sample" style="font-family: 'Montserrat', sans-serif; font-weight: 700;">428</div>
                      <div>
                        <div class="fw-bold small">Modern Sans</div>
                        <div class="text-secondary" style="font-size: 0.69rem;">Bold architectural</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ══ STEP 2: MATERIALS & HARDWARE ═════════════════════════════ -->
              <div class="studio-step-pane d-none" data-step-pane="2">
                <div class="materials-live-bar">
                  <i class="bi bi-palette-fill text-info"></i>
                  <span class="text-secondary">Active Stack:</span>
                  <strong class="text-light text-truncate" id="materials-live-pill">Matte Black ACM &bull; Mirror Gold &bull; Silver Standoffs</strong>
                </div>

                <!-- Front Plate Finish — ACM -->
                <div class="mb-3">
                  <div class="config-section-label">
                    <span>Front Plate &mdash; ACM</span>
                    <span class="text-secondary">Architectural Panel</span>
                  </div>
                  <div class="acm-grid">
                    <div class="choice-tile swatch-tile-compact active" data-acm-finish="matte_black">
                      <span class="swatch-single" style="background: #18181b;"></span>
                      <div class="min-w-0">
                        <div class="fw-bold small text-truncate">Matte Black</div>
                        <div class="text-secondary text-truncate" style="font-size: 0.69rem;">Deep matte</div>
                      </div>
                    </div>

                    <div class="choice-tile swatch-tile-compact" data-acm-finish="brushed_silver">
                      <span class="swatch-single" style="background: linear-gradient(135deg, #e4e4e7 0%, #a1a1aa 50%, #e4e4e7 100%);"></span>
                      <div class="min-w-0">
                        <div class="fw-bold small text-truncate">Brushed Silver</div>
                        <div class="text-secondary text-truncate" style="font-size: 0.69rem;">Aluminum</div>
                      </div>
                    </div>

                    <div class="choice-tile swatch-tile-compact" data-acm-finish="white">
                      <span class="swatch-single" style="background: #f8fafc;"></span>
                      <div class="min-w-0">
                        <div class="fw-bold small text-truncate">White</div>
                        <div class="text-secondary text-truncate" style="font-size: 0.69rem;">Satin white</div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 3D Digits & Text Finish — Laser Acrylic -->
                <div class="mb-3">
                  <div class="config-section-label">
                    <span>3D Digits &amp; Text &mdash; Acrylic</span>
                    <span class="text-secondary">3mm/6mm Laser Acrylic</span>
                  </div>
                  <div class="acrylic-grid">
                    <div class="choice-tile swatch-tile-compact active" data-acrylic-finish="mirror_gold">
                      <span class="swatch-single" style="background: linear-gradient(135deg, #fef08a 0%, #eab308 45%, #a16207 75%, #fde047 100%);"></span>
                      <div class="min-w-0">
                        <div class="fw-bold small">Mirror Gold</div>
                        <div class="text-secondary" style="font-size: 0.69rem;">High-gloss mirror</div>
                      </div>
                    </div>

                    <div class="choice-tile swatch-tile-compact" data-acrylic-finish="mirror_silver">
                      <span class="swatch-single" style="background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 45%, #64748b 70%, #f8fafc 100%);"></span>
                      <div class="min-w-0">
                        <div class="fw-bold small">Mirror Silver</div>
                        <div class="text-secondary" style="font-size: 0.69rem;">Chrome mirror</div>
                      </div>
                    </div>

                    <div class="choice-tile swatch-tile-compact" data-acrylic-finish="matte_white">
                      <span class="swatch-single" style="background: #ffffff;"></span>
                      <div class="min-w-0">
                        <div class="fw-bold small">Matte White</div>
                        <div class="text-secondary" style="font-size: 0.69rem;">Crisp satin matte</div>
                      </div>
                    </div>

                    <div class="choice-tile swatch-tile-compact" data-acrylic-finish="matte_black">
                      <span class="swatch-single" style="background: #111111;"></span>
                      <div class="min-w-0">
                        <div class="fw-bold small">Matte Black</div>
                        <div class="text-secondary" style="font-size: 0.69rem;">Deep matte black</div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Sintra Backing Color — 6mm PVC -->
                <div class="mb-3 sintra-selector-muted" id="sintraSelectorWrap">
                  <div class="config-section-label">
                    <span>Sintra Backing &mdash; 6mm PVC</span>
                    <span class="text-secondary" id="sintra-mode-hint">Selecting enables CNC Cut ACM</span>
                  </div>
                  <div class="sintra-grid">
                    <div class="choice-tile swatch-tile-compact active" data-sintra-color="black">
                      <span class="swatch-single" style="background: #121215;"></span>
                      <div class="min-w-0">
                        <div class="fw-bold small">Black Sintra</div>
                        <div class="text-secondary" style="font-size: 0.69rem;">6mm matte black PVC</div>
                      </div>
                    </div>

                    <div class="choice-tile swatch-tile-compact" data-sintra-color="white">
                      <span class="swatch-single" style="background: #f4f4f5;"></span>
                      <div class="min-w-0">
                        <div class="fw-bold small">White Sintra</div>
                        <div class="text-secondary" style="font-size: 0.69rem;">6mm matte white PVC</div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Standoff Hardware Finish -->
                <div>
                  <div class="config-section-label">
                    <span>Standoff Hardware Finish</span>
                    <span class="text-secondary">2 Lateral Mounts</span>
                  </div>
                  <div class="standoff-grid">
                    <div class="choice-tile swatch-tile-compact" data-standoff-finish="black">
                      <span class="swatch-single" style="background: #18181b;"></span>
                      <div class="min-w-0">
                        <div class="fw-bold small">Black</div>
                        <div class="text-secondary" style="font-size: 0.68rem;">Anodized</div>
                      </div>
                    </div>

                    <div class="choice-tile swatch-tile-compact" data-standoff-finish="gold">
                      <span class="swatch-single" style="background: linear-gradient(135deg, #fef08a 0%, #d4af37 50%, #92400e 100%);"></span>
                      <div class="min-w-0">
                        <div class="fw-bold small">Gold</div>
                        <div class="text-secondary" style="font-size: 0.68rem;">Brushed</div>
                      </div>
                    </div>

                    <div class="choice-tile swatch-tile-compact active" data-standoff-finish="silver">
                      <span class="swatch-single" style="background: linear-gradient(135deg, #f8fafc 0%, #a1a1aa 55%, #e4e4e7 100%);"></span>
                      <div class="min-w-0">
                        <div class="fw-bold small">Silver</div>
                        <div class="text-secondary" style="font-size: 0.68rem;">Stainless</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ══ STEP 3: SIZE & DIMENSIONS ════════════════════════════════ -->
              <div class="studio-step-pane d-none" data-step-pane="3">
                <div class="config-section-label">
                  <span>Select Plaque Dimensions (CAD)</span>
                  <span class="text-secondary">+15% PEI HST at checkout</span>
                </div>

                <div class="size-grid-studio">
                  <div class="choice-tile text-center" data-size="small" data-price="55">
                    <div class="size-ratio-wrap">
                      <div class="size-ratio-box" style="width: 28px; height: 21px;"></div>
                    </div>
                    <div class="fw-bold small">Small</div>
                    <div class="text-secondary" style="font-size: 0.72rem;">10" &times; 13" (25 &times; 33 cm)</div>
                    <div class="fw-bold text-info mt-1 size-tile-price">$55 CAD</div>
                  </div>

                  <div class="choice-tile text-center active" data-size="medium" data-price="60">
                    <div class="size-ratio-wrap">
                      <div class="size-ratio-box" style="width: 33px; height: 22px;"></div>
                    </div>
                    <div class="fw-bold small">Medium</div>
                    <div class="text-secondary" style="font-size: 0.72rem;">10" &times; 15" (25 &times; 38 cm)</div>
                    <div class="fw-bold text-info mt-1 size-tile-price">$60 CAD</div>
                  </div>

                  <div class="choice-tile text-center" data-size="large" data-price="70">
                    <div class="size-ratio-wrap">
                      <div class="size-ratio-box" style="width: 38px; height: 22px;"></div>
                    </div>
                    <div class="fw-bold small">Large</div>
                    <div class="text-secondary" style="font-size: 0.72rem;">10" &times; 17" (25 &times; 43 cm)</div>
                    <div class="fw-bold text-info mt-1 size-tile-price">$70 CAD</div>
                  </div>

                  <div class="choice-tile text-center" data-size="extra_large" data-price="80">
                    <div class="size-ratio-wrap">
                      <div class="size-ratio-box" style="width: 48px; height: 20px;"></div>
                    </div>
                    <div class="fw-bold small">Extra Large</div>
                    <div class="text-secondary" style="font-size: 0.72rem;">10" &times; 23.5" (25 &times; 60 cm)</div>
                    <div class="fw-bold text-info mt-1 size-tile-price">$80 CAD</div>
                  </div>

                  <div class="choice-tile" data-size="vertical" data-price="55">
                    <div class="d-flex align-items-center gap-3">
                      <div class="size-ratio-wrap">
                        <div class="size-ratio-box" style="width: 11px; height: 34px;"></div>
                      </div>
                      <div>
                        <div class="d-flex align-items-center gap-1">
                          <span class="fw-bold small">Vertical Column</span>
                          <i class="bi bi-arrows-vertical text-info" style="font-size: 0.75rem;"></i>
                        </div>
                        <div class="text-secondary" style="font-size: 0.72rem;">5" &times; 17" (13 &times; 43 cm) &bull; Slim pillars &amp; trim</div>
                      </div>
                    </div>
                    <div class="fw-bold text-info size-tile-price">$55 CAD</div>
                  </div>
                </div>

                <!-- Included Architectural Spec Badges -->
                <div class="craft-highlights-grid">
                  <div class="craft-highlight-pill">
                    <i class="bi bi-cloud-sun-fill text-info"></i>
                    <span>Weatherproof exterior grade</span>
                  </div>
                  <div class="craft-highlight-pill">
                    <i class="bi bi-nut-fill text-info"></i>
                    <span>2 lateral standoffs included</span>
                  </div>
                  <div class="craft-highlight-pill">
                    <i class="bi bi-stars text-info"></i>
                    <span>Precision CNC &amp; laser cut</span>
                  </div>
                  <div class="craft-highlight-pill">
                    <i class="bi bi-geo-alt-fill text-danger"></i>
                    <span>Crafted in Charlottetown, PEI</span>
                  </div>
                </div>
              </div>

              <!-- ══ STEP 4: CUSTOMER, FULFILLMENT & CHECKOUT ═════════════════ -->
              <div class="studio-step-pane d-none" data-step-pane="4">
                <!-- Customer Information -->
                <div class="mb-3">
                  <div class="config-section-label">
                    <span>Customer Details</span>
                    <span class="text-danger">* Required</span>
                  </div>
                  <div class="mb-2">
                    <label for="customerName" class="form-label small text-light mb-1">Full Name <span class="text-danger">*</span></label>
                    <input type="text" id="customerName" class="form-control config-input" placeholder="Jane Doe" required>
                  </div>
                  <div class="row g-2 mb-3">
                    <div class="col-sm-7">
                      <label for="customerEmail" class="form-label small text-light mb-1">Email Address <span class="text-danger">*</span></label>
                      <input type="email" id="customerEmail" class="form-control config-input" placeholder="jane@example.com" required>
                    </div>
                    <div class="col-sm-5">
                      <label for="customerPhone" class="form-label small text-light mb-1">Phone</label>
                      <input type="tel" id="customerPhone" class="form-control config-input" placeholder="902-555-0199">
                    </div>
                  </div>

                  <!-- Fulfillment Method: Store Pickup vs Shipping -->
                  <div class="pt-2 border-top border-secondary border-opacity-25">
                    <label class="form-label small text-light fw-bold mb-2 d-flex justify-content-between align-items-center">
                      <span>Fulfillment / Delivery Method</span>
                      <span class="text-info small fw-normal"><i class="bi bi-geo-alt me-1"></i> Charlottetown, PEI</span>
                    </label>

                    <div class="delivery-toggle-grid mb-2">
                      <div class="choice-tile active" data-delivery="pickup" id="tile-delivery-pickup">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                          <span class="fw-bold small d-flex align-items-center gap-2">
                            <i class="bi bi-shop-window text-info"></i> Pick Up in Store
                          </span>
                          <span class="badge bg-success bg-opacity-25 text-success" style="font-size: 0.65rem;">Free</span>
                        </div>
                        <div class="text-light opacity-75" style="font-size: 0.71rem; line-height: 1.35;">
                          <strong>180 Belvedere Ave</strong>, Charlottetown, PEI, C1A 2Z1, Canada
                        </div>
                      </div>

                      <div class="choice-tile" data-delivery="shipping" id="tile-delivery-shipping">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                          <span class="fw-bold small d-flex align-items-center gap-2">
                            <i class="bi bi-truck text-info"></i> Direct Shipping
                          </span>
                          <span class="badge bg-primary bg-opacity-25 text-info" style="font-size: 0.65rem;">To Address</span>
                        </div>
                        <div class="text-light opacity-75" style="font-size: 0.71rem; line-height: 1.35;">
                          Delivered directly to your home or office address
                        </div>
                      </div>
                    </div>

                    <!-- Collapsible Shipping Address Form -->
                    <div id="shippingFieldsContainer" class="shipping-fields-panel d-none mt-2">
                      <div class="p-3 rounded-3" style="background: rgba(15, 23, 42, 0.75); border: 1px solid rgba(56, 189, 248, 0.25);">
                        <div class="text-info small fw-bold mb-2 d-flex align-items-center" style="font-size: 0.75rem;">
                          <i class="bi bi-pin-map-fill me-1"></i> Shipping Destination Address
                        </div>
                        <div class="mb-2">
                          <label for="shippingAddress1" class="form-label small text-light mb-1">Street Address <span class="text-danger">*</span></label>
                          <input type="text" id="shippingAddress1" class="form-control config-input" placeholder="e.g. 428 Queen St">
                        </div>
                        <div class="mb-2">
                          <label for="shippingAddress2" class="form-label small text-light mb-1">Apt, Suite, Unit <span class="text-secondary fw-normal">(Optional)</span></label>
                          <input type="text" id="shippingAddress2" class="form-control config-input" placeholder="e.g. Suite 200 or Apt 4B">
                        </div>
                        <div class="row g-2 mb-2">
                          <div class="col-sm-6">
                            <label for="shippingCity" class="form-label small text-light mb-1">City <span class="text-danger">*</span></label>
                            <input type="text" id="shippingCity" class="form-control config-input" placeholder="e.g. Charlottetown">
                          </div>
                          <div class="col-sm-3 col-6">
                            <label for="shippingProvince" class="form-label small text-light mb-1">Province <span class="text-danger">*</span></label>
                            <select id="shippingProvince" class="form-select config-input">
                              <option value="PE" selected>PE</option>
                              <option value="NS">NS</option>
                              <option value="NB">NB</option>
                              <option value="ON">ON</option>
                              <option value="QC">QC</option>
                              <option value="BC">BC</option>
                              <option value="AB">AB</option>
                              <option value="SK">SK</option>
                              <option value="MB">MB</option>
                              <option value="NL">NL</option>
                              <option value="YT">YT</option>
                              <option value="NT">NT</option>
                              <option value="NU">NU</option>
                            </select>
                          </div>
                          <div class="col-sm-3 col-6">
                            <label for="shippingPostal" class="form-label small text-light mb-1">Postal Code <span class="text-danger">*</span></label>
                            <input type="text" id="shippingPostal" class="form-control config-input" placeholder="e.g. C1A 2Z1">
                          </div>
                        </div>
                        <div class="row g-2">
                          <div class="col-sm-5">
                            <label for="shippingCountry" class="form-label small text-light mb-1">Country</label>
                            <input type="text" id="shippingCountry" class="form-control config-input" value="Canada" readonly>
                          </div>
                          <div class="col-sm-7">
                            <label for="shippingNotes" class="form-label small text-light mb-1">Delivery Notes <span class="text-secondary fw-normal">(Optional)</span></label>
                            <input type="text" id="shippingNotes" class="form-control config-input" placeholder="e.g. Leave by side door">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Payment Method Selector -->
                  <div class="pt-2 border-top border-secondary border-opacity-25 mb-3">
                    <label class="form-label small text-light fw-bold mb-2 d-flex justify-content-between align-items-center">
                      <span>Payment Method</span>
                      <span class="text-info small fw-normal"><i class="bi bi-shield-check me-1"></i> Secure Checkout</span>
                    </label>

                    <div class="payment-method-grid mb-1">
                      <div class="choice-tile active" data-payment-method="helcim" id="tile-payment-helcim">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                          <span class="fw-bold small d-flex align-items-center gap-2">
                            <i class="bi bi-credit-card-2-front-fill text-info"></i> Credit / Debit Card
                          </span>
                          <span class="badge bg-success bg-opacity-25 text-success" style="font-size: 0.65rem;">Instant</span>
                        </div>
                        <div class="text-light opacity-75" style="font-size: 0.71rem; line-height: 1.35;">
                          Visa, Mastercard &amp; Amex via secure HelcimPay
                        </div>
                      </div>

                      <div class="choice-tile" data-payment-method="interac" id="tile-payment-interac">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                          <span class="fw-bold small d-flex align-items-center gap-2">
                            <i class="bi bi-bank2 text-warning"></i> Interac e-Transfer
                          </span>
                          <span class="badge bg-primary bg-opacity-25 text-info" style="font-size: 0.65rem;">Bank Transfer</span>
                        </div>
                        <div class="text-light opacity-75" style="font-size: 0.71rem; line-height: 1.35;">
                          Pay via online Canadian banking e-Transfer
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Pre-Checkout Order Review Summary -->
                <div class="precheckout-summary-card" id="precheckoutSummary">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="text-info small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 1px;">
                      <i class="bi bi-receipt me-1"></i> Order Summary Preview
                    </div>
                    <button type="button" class="btn btn-link btn-sm p-0 text-info text-decoration-none" style="font-size: 0.72rem;" data-goto-step="1">
                      <i class="bi bi-pencil-square me-1"></i>Edit
                    </button>
                  </div>
                  <div class="d-flex justify-content-between small mb-1 gap-2">
                    <span class="text-secondary">Construction:</span>
                    <span class="text-light fw-semibold text-end" id="review-construction">Raised 3D Acrylic (Solid ACM)</span>
                  </div>
                  <div class="d-flex justify-content-between small mb-1 gap-2">
                    <span class="text-secondary">Font Style:</span>
                    <span class="text-light fw-semibold text-end" id="review-font">Athletic Octagonal Block</span>
                  </div>
                  <div class="d-flex justify-content-between small mb-1 gap-2">
                    <span class="text-secondary">Materials:</span>
                    <span class="text-light fw-semibold text-end" id="review-materials">Matte Black ACM + Mirror Gold Acrylic</span>
                  </div>
                  <div class="d-flex justify-content-between small mb-1 gap-2 d-none" id="review-sintra-row">
                    <span class="text-secondary">Sintra Backing (6mm):</span>
                    <span class="text-light fw-semibold text-end" id="review-sintra">Black Sintra (6mm)</span>
                  </div>
                  <div class="d-flex justify-content-between small mb-1 gap-2">
                    <span class="text-secondary">Standoffs:</span>
                    <span class="text-light fw-semibold text-end" id="review-standoffs">2 Lateral Silver Standoffs</span>
                  </div>
                  <div class="d-flex justify-content-between small mb-1 gap-2">
                    <span class="text-secondary">Fulfillment:</span>
                    <span class="text-light fw-semibold text-end" id="review-fulfillment">Pick Up in Store (Charlottetown, PEI)</span>
                  </div>
                  <div class="d-flex justify-content-between small mb-1 gap-2">
                    <span class="text-secondary">Payment Method:</span>
                    <span class="text-light fw-semibold text-end" id="review-payment-method">Credit / Debit Card (Instant)</span>
                  </div>
                  <div class="d-flex justify-content-between small mb-1 gap-2">
                    <span class="text-secondary">Size:</span>
                    <span class="text-light fw-semibold text-end" id="review-size">Medium (10" &times; 15")</span>
                  </div>
                  <div class="d-flex justify-content-between align-items-center small pt-2 mt-2 border-top border-secondary border-opacity-25">
                    <span class="text-white fw-bold">Total incl. 15% PEI HST:</span>
                    <span class="text-info fw-bold fs-6" id="review-total">$69.00 CAD</span>
                  </div>
                </div>

                <!-- Single Primary Action Button -->
                <div class="d-grid gap-2">
                  <button type="button" id="btnSubmitOrder" class="btn btn-primary-checkout d-flex align-items-center justify-content-center gap-2">
                    <span class="spinner-border spinner-border-sm d-none" id="spinnerSubmitOrder"></span>
                    <i class="bi bi-lock-fill" id="btnSubmitIcon"></i>
                    <span id="btnSubmitLabel">Proceed to Secure Payment &mdash; <strong id="btn-submit-total">$69.00 CAD</strong></span>
                  </button>
                </div>

                <!-- Order Confirmation / Interac Instructions Panel -->
                <div id="orderConfirmationPanel" class="confirmation-box d-none"></div>
              </div>

            </div>
          </form>

          <!-- Persistent Footer Dock -->
          <div class="studio-step-footer" id="studioNavSteps">
            <div class="d-flex align-items-center gap-2">
              <button type="button" class="btn-step-prev d-none" id="btnStepPrev">
                <i class="bi bi-arrow-left"></i> Back
              </button>
              <div class="small">
                <span class="text-secondary d-block" style="font-size: 0.65rem; line-height: 1.1;">Est. Total</span>
                <strong class="text-info" id="footer-step-total" style="font-size: 0.85rem;">$69.00 CAD</strong>
              </div>
            </div>
            <button type="button" class="btn-step-next" id="btnStepNext">
              <span>Next: Materials</span> <i class="bi bi-arrow-right"></i>
            </button>
          </div>

          <div class="studio-step-footer d-none" id="studioNavCheckout">
            <button type="button" class="btn-step-prev" data-goto-step="3">
              <i class="bi bi-arrow-left"></i> Back to Size
            </button>
            <button type="button" class="btn-step-prev" data-goto-step="1">
              <i class="bi bi-sliders"></i> Edit Design
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Studio Footer / Origin Badge -->
    <div class="d-flex justify-content-center align-items-center mt-4 pt-3 border-top border-secondary border-opacity-25 text-center">
      <div class="plaque-badge-pei">
        <i class="bi bi-geo-alt-fill text-danger"></i>
        <span>Made in PEI Canada</span>
      </div>
    </div>
  </div>
</div>

<script type="module">
  import * as THREE from 'three';
  import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
  import { FontLoader } from 'three/addons/loaders/FontLoader.js';
  import { TTFLoader } from 'three/addons/loaders/TTFLoader.js';
  import { RoomEnvironment } from 'three/addons/environments/RoomEnvironment.js';

  // ─── Reactive Configurator State ───────────────────────────────────────
  const state = {
    delivery_method: 'pickup',
    payment_method: 'helcim',
    environment: 'studio',
    plaque_type: 'house',
    construction_style: 'raised_acrylic',
    font_style: 'athletic_block',
    primary_text: '428',
    subtitle_text: 'QUEEN ST',
    acm_finish: 'matte_black',
    acrylic_finish: 'mirror_gold',
    sintra_color: 'black',
    standoff_finish: 'silver',
    size: 'medium',
    exploded: false,
    base_price_cad: 60.00,
    cnc_surcharge_cad: 0.00,
    subtotal_cad: 60.00,
    hst_cad: 9.00,
    total_cad: 69.00
  };

  let activeHelcimOrder = null;
  let isSubmittingOrder = false;
  let currentCheckoutKey = null;

  function getOrCreateCheckoutKey() {
    if (!currentCheckoutKey) {
      currentCheckoutKey = (window.crypto && typeof window.crypto.randomUUID === 'function')
        ? window.crypto.randomUUID()
        : ('plp-' + Date.now() + '-' + Math.random().toString(36).slice(2, 10));
    }
    return currentCheckoutKey;
  }

  function resetCheckoutKey() {
    currentCheckoutKey = null;
    activeHelcimOrder = null;
  }

  const CATALOG = {
    construction_styles: {
      raised_acrylic: {
        name: 'Raised 3D Acrylic (Solid ACM)',
        shortName: 'Raised 3D Acrylic',
        legendHtml: 'Back &rarr; Front: <strong>1. Rear Standoffs</strong> &rarr; <strong>2. Solid ACM Plate</strong> &rarr; <strong>3. Raised Acrylic Digits</strong> &rarr; <strong>4. Front Caps</strong>',
        backingSummary: 'Solid ACM Plate & 2 Lateral Standoffs'
      },
      cnc_cut_acm: {
        name: 'CNC Cut ACM + Inlaid Acrylic (Black Sintra Backer)',
        shortName: 'CNC Cut ACM + Inlaid',
        legendHtml: 'Back &rarr; Front: <strong>1. Rear Standoffs</strong> &rarr; <strong>2. Black Sintra</strong> &rarr; <strong>3. Acrylic Digits</strong> &rarr; <strong>4. CNC ACM Plate</strong> &rarr; <strong>5. Front Caps</strong>',
        backingSummary: 'Black Sintra Base & 2 Lateral Standoffs'
      }
    },
    font_styles: {
      athletic_block: {
        name: 'Athletic Octagonal Block',
        shortName: 'Athletic Block',
        ttfUrl: 'https://fonts.gstatic.com/s/chakrapetch/v13/cIflMapbsEk7TDLdtEz1BwkeJI9FQA.ttf',
        fallbackJsonUrl: 'https://cdn.jsdelivr.net/npm/three@0.160.0/examples/fonts/helvetiker_bold.typeface.json',
        useProceduralDigits: true,
        bevelScale: 0.013,
        maxPrimaryBevel: 0.008,
        maxSubBevel: 0.004
      },
      modern_sans: {
        name: 'Modern Architectural Sans',
        shortName: 'Modern Sans',
        ttfUrl: 'https://fonts.gstatic.com/s/montserrat/v31/JTUHjIg1_i6t8kCHKm4532VJOt5-QNFgpCuM70w-.ttf',
        fallbackJsonUrl: 'https://cdn.jsdelivr.net/npm/three@0.160.0/examples/fonts/helvetiker_bold.typeface.json',
        useProceduralDigits: false,
        bevelScale: 0.013,
        maxPrimaryBevel: 0.008,
        maxSubBevel: 0.004
      }
    },
    sizes: {
      small:       { price: 55.00, cncSurcharge: 10.00, label: 'Small (10" × 13" / 25 × 33 cm)',         shortLabel: 'Small (10" × 13")',    w: 4.20, h: 3.20, camScale: 0.96 },
      medium:      { price: 60.00, cncSurcharge: 10.00, label: 'Medium (10" × 15" / 25 × 38 cm)',        shortLabel: 'Medium (10" × 15")',   w: 4.80, h: 3.20, camScale: 1.00 },
      large:       { price: 70.00, cncSurcharge: 15.00, label: 'Large (10" × 17" / 25 × 43 cm)',         shortLabel: 'Large (10" × 17")',    w: 5.44, h: 3.20, camScale: 1.08 },
      extra_large: { price: 80.00, cncSurcharge: 15.00, label: 'Extra Large (10" × 23.5" / 25 × 60 cm)', shortLabel: 'XL (10" × 23.5")',     w: 7.52, h: 3.20, camScale: 1.28 },
      vertical:    { price: 55.00, cncSurcharge: 10.00, label: 'Vertical (5" × 17" / 13 × 43 cm)',      shortLabel: 'Vertical (5" × 17")',  w: 2.10, h: 6.40, isVertical: true, camScale: 1.40 }
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
    },
    sintra_colors: {
      black: {
        name: 'Black Sintra (6mm)',
        shortName: 'Black Sintra 6mm',
        color: 0x121215,
        roughness: 0.88,
        metalness: 0.04,
        envMapIntensity: 0.50
      },
      white: {
        name: 'White Sintra (6mm)',
        shortName: 'White Sintra 6mm',
        color: 0xf4f4f5,
        roughness: 0.78,
        metalness: 0.02,
        envMapIntensity: 0.65
      }
    },
    standoff_finishes: {
      black: {
        name: 'Black Standoffs',
        shortName: 'Black',
        color: 0x18181b,
        metalness: 0.55,
        roughness: 0.42,
        envMapIntensity: 0.90
      },
      gold: {
        name: 'Gold Standoffs',
        shortName: 'Gold',
        color: 0xd4af37,
        metalness: 0.94,
        roughness: 0.18,
        envMapIntensity: 1.45
      },
      silver: {
        name: 'Silver Standoffs',
        shortName: 'Silver',
        color: 0xd4d4d8,
        metalness: 0.92,
        roughness: 0.22,
        envMapIntensity: 1.25
      }
    },
    environments: {
      studio: {
        name: 'Studio',
        hint: 'Neutral 3D studio backdrop with balanced lighting'
      },
      casa: {
        name: 'House Facade',
        hint: 'Modern residential siding facade with warm exterior wall sconce'
      },
      barda: {
        name: 'Stone Wall',
        hint: 'Exterior stacked stone masonry wall with concrete coping cap'
      },
      entrada: {
        name: 'Front Entry',
        hint: 'Modern front door entryway with tall pull bar handle & smart doorbell'
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

  const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance', preserveDrawingBuffer: true });
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
  keyLight.position.set(4.5, 5.5, 6.5);
  keyLight.castShadow = true;
  keyLight.shadow.mapSize.width = 2048;
  keyLight.shadow.mapSize.height = 2048;
  keyLight.shadow.bias = -0.00015;
  keyLight.shadow.normalBias = 0.008;
  keyLight.shadow.camera.near = 1.0;
  keyLight.shadow.camera.far = 22;
  keyLight.shadow.camera.left = -5.5;
  keyLight.shadow.camera.right = 5.5;
  keyLight.shadow.camera.top = 4.5;
  keyLight.shadow.camera.bottom = -4.5;
  scene.add(keyLight);

  const fillLight = new THREE.DirectionalLight(0x93c5fd, 0.75);
  fillLight.position.set(-6, 3, 4);
  scene.add(fillLight);

  const rimLight = new THREE.DirectionalLight(0xfde047, 0.55);
  rimLight.position.set(0, -5, -4);
  scene.add(rimLight);

  // Subtle architectural wall + standoff contact shadow group behind the plaque
  function createContactShadowTexture() {
    const size = 128;
    const canvas = document.createElement('canvas');
    canvas.width = size;
    canvas.height = size;
    const ctx = canvas.getContext('2d');
    const grad = ctx.createRadialGradient(size / 2, size / 2, 4, size / 2, size / 2, size / 2);
    grad.addColorStop(0.0, 'rgba(0, 0, 0, 0.52)');
    grad.addColorStop(0.45, 'rgba(0, 0, 0, 0.22)');
    grad.addColorStop(1.0, 'rgba(0, 0, 0, 0.0)');
    ctx.fillStyle = grad;
    ctx.fillRect(0, 0, size, size);
    const tex = new THREE.CanvasTexture(canvas);
    return tex;
  }

  const contactShadowTexture = createContactShadowTexture();

  const wallGroup = new THREE.Group();
  wallGroup.position.z = -0.62;
  scene.add(wallGroup);

  const wallGeo = new THREE.PlaneGeometry(26, 18);
  const wallMat = new THREE.ShadowMaterial({ opacity: 0.34 });
  const wallMesh = new THREE.Mesh(wallGeo, wallMat);
  wallMesh.receiveShadow = true;

  const wallContactShadowsLayer = new THREE.Group();
  wallGroup.add(wallContactShadowsLayer);

  // ─── Procedural Architectural Environment Textures & Groups ───────────
  function createCasaTextures() {
    const size = 512;
    const colorCanvas = document.createElement('canvas');
    colorCanvas.width = size;
    colorCanvas.height = size;
    const cCtx = colorCanvas.getContext('2d');

    const bumpCanvas = document.createElement('canvas');
    bumpCanvas.width = size;
    bumpCanvas.height = size;
    const bCtx = bumpCanvas.getContext('2d');

    cCtx.fillStyle = '#22262f';
    cCtx.fillRect(0, 0, size, size);
    bCtx.fillStyle = '#808080';
    bCtx.fillRect(0, 0, size, size);

    const boardH = size / 8;
    for (let b = 0; b < 8; b++) {
      const y = b * boardH;
      const boardGrad = cCtx.createLinearGradient(0, y, 0, y + boardH);
      boardGrad.addColorStop(0, '#2b313d');
      boardGrad.addColorStop(0.85, '#232731');
      boardGrad.addColorStop(1, '#1b1e25');
      cCtx.fillStyle = boardGrad;
      cCtx.fillRect(0, y, size, boardH - 4);

      cCtx.fillStyle = '#3f4756';
      cCtx.fillRect(0, y, size, 2);
      bCtx.fillStyle = '#b0b0b0';
      bCtx.fillRect(0, y, size, 2);

      cCtx.fillStyle = '#0f1217';
      cCtx.fillRect(0, y + boardH - 4, size, 4);
      bCtx.fillStyle = '#1c1c1c';
      bCtx.fillRect(0, y + boardH - 4, size, 4);

      for (let i = 0; i < 90; i++) {
        const sx = (i * 97) % size;
        const sy = y + 3 + ((i * 31) % (boardH - 8));
        const sw = 40 + (i % 120);
        cCtx.fillStyle = 'rgba(255, 255, 255, 0.04)';
        cCtx.fillRect(sx, sy, sw, 1);
        if (sx + sw > size) cCtx.fillRect(0, sy, (sx + sw) - size, 1);
      }
    }

    const colorMap = new THREE.CanvasTexture(colorCanvas);
    colorMap.wrapS = THREE.RepeatWrapping;
    colorMap.wrapT = THREE.RepeatWrapping;
    colorMap.repeat.set(2.4, 2.8);
    colorMap.colorSpace = THREE.SRGBColorSpace;

    const bumpMap = new THREE.CanvasTexture(bumpCanvas);
    bumpMap.wrapS = THREE.RepeatWrapping;
    bumpMap.wrapT = THREE.RepeatWrapping;
    bumpMap.repeat.set(2.4, 2.8);

    return { colorMap, bumpMap };
  }

  function createBardaTextures() {
    const size = 512;
    const colorCanvas = document.createElement('canvas');
    colorCanvas.width = size;
    colorCanvas.height = size;
    const cCtx = colorCanvas.getContext('2d');

    const bumpCanvas = document.createElement('canvas');
    bumpCanvas.width = size;
    bumpCanvas.height = size;
    const bCtx = bumpCanvas.getContext('2d');

    cCtx.fillStyle = '#181a1e';
    cCtx.fillRect(0, 0, size, size);
    bCtx.fillStyle = '#151515';
    bCtx.fillRect(0, 0, size, size);

    const stonePalette = ['#2d323a', '#363c46', '#3f4551', '#282c33', '#393f4a', '#444b57', '#323740'];
    const rows = 10;
    const rowH = size / rows;

    for (let r = 0; r < rows; r++) {
      const y = r * rowH;
      let x = (r % 2 === 0 ? 0 : -25);
      let sIdx = 0;
      while (x < size + 60) {
        const stoneW = 55 + ((r * 37 + sIdx * 53) % 75);
        const col = stonePalette[(r * 5 + sIdx * 3) % stonePalette.length];
        const pad = 3;

        cCtx.fillStyle = col;
        cCtx.fillRect(x + pad, y + pad, stoneW - (pad * 2), rowH - (pad * 2));

        cCtx.fillStyle = 'rgba(255, 255, 255, 0.10)';
        cCtx.fillRect(x + pad, y + pad, stoneW - (pad * 2), 2);
        cCtx.fillStyle = 'rgba(0, 0, 0, 0.22)';
        cCtx.fillRect(x + pad, y + rowH - pad - 2, stoneW - (pad * 2), 2);

        bCtx.fillStyle = '#9e9e9e';
        bCtx.fillRect(x + pad, y + pad, stoneW - (pad * 2), rowH - (pad * 2));
        bCtx.fillStyle = '#bfbfbf';
        bCtx.fillRect(x + pad, y + pad, stoneW - (pad * 2), 2);

        for (let s = 0; s < 25; s++) {
          const px = x + pad + ((s * 31) % Math.max(1, stoneW - pad * 2));
          const py = y + pad + ((s * 19) % Math.max(1, rowH - pad * 2));
          cCtx.fillStyle = s % 2 === 0 ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.08)';
          cCtx.fillRect(px, py, 2, 2);
        }

        x += stoneW;
        sIdx++;
      }
    }

    const colorMap = new THREE.CanvasTexture(colorCanvas);
    colorMap.wrapS = THREE.RepeatWrapping;
    colorMap.wrapT = THREE.RepeatWrapping;
    colorMap.repeat.set(2.0, 2.0);
    colorMap.colorSpace = THREE.SRGBColorSpace;

    const bumpMap = new THREE.CanvasTexture(bumpCanvas);
    bumpMap.wrapS = THREE.RepeatWrapping;
    bumpMap.wrapT = THREE.RepeatWrapping;
    bumpMap.repeat.set(2.0, 2.0);

    return { colorMap, bumpMap };
  }

  function createEntradaTextures() {
    const size = 512;
    const stuccoCanvas = document.createElement('canvas');
    stuccoCanvas.width = size;
    stuccoCanvas.height = size;
    const sCtx = stuccoCanvas.getContext('2d');
    sCtx.fillStyle = '#343841';
    sCtx.fillRect(0, 0, size, size);

    const bumpCanvas = document.createElement('canvas');
    bumpCanvas.width = size;
    bumpCanvas.height = size;
    const bCtx = bumpCanvas.getContext('2d');
    bCtx.fillStyle = '#808080';
    bCtx.fillRect(0, 0, size, size);

    for (let i = 0; i < 2500; i++) {
      const x = (i * 97) % size;
      const y = (i * 131) % size;
      const bright = i % 2 === 0;
      sCtx.fillStyle = bright ? 'rgba(255, 255, 255, 0.04)' : 'rgba(0, 0, 0, 0.06)';
      sCtx.fillRect(x, y, 2, 2);
      bCtx.fillStyle = bright ? '#949494' : '#6c6c6c';
      bCtx.fillRect(x, y, 2, 2);
    }

    const stuccoMap = new THREE.CanvasTexture(stuccoCanvas);
    stuccoMap.wrapS = THREE.RepeatWrapping;
    stuccoMap.wrapT = THREE.RepeatWrapping;
    stuccoMap.repeat.set(3, 3);
    stuccoMap.colorSpace = THREE.SRGBColorSpace;

    const stuccoBump = new THREE.CanvasTexture(bumpCanvas);
    stuccoBump.wrapS = THREE.RepeatWrapping;
    stuccoBump.wrapT = THREE.RepeatWrapping;
    stuccoBump.repeat.set(3, 3);

    const doorCanvas = document.createElement('canvas');
    doorCanvas.width = 512;
    doorCanvas.height = 1024;
    const dCtx = doorCanvas.getContext('2d');

    const doorGrad = dCtx.createLinearGradient(0, 0, 0, 1024);
    doorGrad.addColorStop(0, '#241f1c');
    doorGrad.addColorStop(0.5, '#2b2521');
    doorGrad.addColorStop(1, '#1e1a17');
    dCtx.fillStyle = doorGrad;
    dCtx.fillRect(0, 0, 512, 1024);

    for (let i = 0; i < 400; i++) {
      const x = (i * 19) % 512;
      const w = 1 + (i % 3);
      dCtx.fillStyle = `rgba(${i % 2 === 0 ? 200 : 30}, ${i % 2 === 0 ? 180 : 25}, 160, 0.04)`;
      dCtx.fillRect(x, 0, w, 1024);
    }

    for (let g = 1; g <= 5; g++) {
      const gy = Math.round(g * (1024 / 6));
      dCtx.fillStyle = '#0c0a09';
      dCtx.fillRect(0, gy - 2, 512, 4);
      dCtx.fillStyle = 'rgba(255, 255, 255, 0.12)';
      dCtx.fillRect(0, gy + 2, 512, 1);
    }

    const doorMap = new THREE.CanvasTexture(doorCanvas);
    doorMap.colorSpace = THREE.SRGBColorSpace;

    return { stuccoMap, stuccoBump, doorMap };
  }

  // ─── Environment Subgroups inside wallGroup ────────────────────────────
  const envStudioGroup  = new THREE.Group();
  const envCasaGroup    = new THREE.Group();
  const envBardaGroup   = new THREE.Group();
  const envEntradaGroup = new THREE.Group();

  wallGroup.add(envStudioGroup);
  wallGroup.add(envCasaGroup);
  wallGroup.add(envBardaGroup);
  wallGroup.add(envEntradaGroup);

  // 1. Studio Backdrop (transparent ShadowMaterial receiver)
  envStudioGroup.add(wallMesh);

  // 2. Casa: Modern Architectural Siding + Exterior Wall Sconce + Soffit
  const casaMaps = createCasaTextures();
  const casaWallMat = new THREE.MeshStandardMaterial({
    color: 0xffffff,
    map: casaMaps.colorMap,
    bumpMap: casaMaps.bumpMap,
    bumpScale: 0.05,
    roughness: 0.72,
    metalness: 0.08
  });
  const casaWallMesh = new THREE.Mesh(new THREE.PlaneGeometry(34, 24), casaWallMat);
  casaWallMesh.position.z = -0.002;
  casaWallMesh.receiveShadow = true;
  envCasaGroup.add(casaWallMesh);

  const sconceGroup = new THREE.Group();
  sconceGroup.position.set(-4.2, 0.75, 0.22);
  const sconceBody = new THREE.Mesh(
    new THREE.CylinderGeometry(0.18, 0.18, 0.95, 24),
    new THREE.MeshStandardMaterial({ color: 0x18181b, metalness: 0.88, roughness: 0.32 })
  );
  sconceBody.castShadow = true;
  sconceGroup.add(sconceBody);

  const sconceLensMat = new THREE.MeshStandardMaterial({
    color: 0xffedd5,
    emissive: 0xffedd5,
    emissiveIntensity: 2.5,
    roughness: 0.2
  });
  const sconceTopLens = new THREE.Mesh(new THREE.CylinderGeometry(0.17, 0.17, 0.07, 24), sconceLensMat);
  sconceTopLens.position.y = 0.45;
  sconceGroup.add(sconceTopLens);
  const sconceBottomLens = new THREE.Mesh(new THREE.CylinderGeometry(0.17, 0.17, 0.07, 24), sconceLensMat);
  sconceBottomLens.position.y = -0.45;
  sconceGroup.add(sconceBottomLens);

  const sconceLight = new THREE.PointLight(0xffedd5, 2.2, 9.0, 2.0);
  sconceLight.position.set(-4.2, 0.75, 0.45);
  envCasaGroup.add(sconceLight);
  envCasaGroup.add(sconceGroup);

  const casaOverhang = new THREE.Mesh(
    new THREE.BoxGeometry(34, 0.55, 0.75),
    new THREE.MeshStandardMaterial({ color: 0x18181b, roughness: 0.75 })
  );
  casaOverhang.position.set(0, 5.2, 0.37);
  casaOverhang.castShadow = true;
  envCasaGroup.add(casaOverhang);

  // 3. Barda: Stacked Slate/Stone Wall + Concrete Coping Ledge
  const bardaMaps = createBardaTextures();
  const bardaWallMat = new THREE.MeshStandardMaterial({
    color: 0xffffff,
    map: bardaMaps.colorMap,
    bumpMap: bardaMaps.bumpMap,
    bumpScale: 0.08,
    roughness: 0.88,
    metalness: 0.04
  });
  const bardaWallMesh = new THREE.Mesh(new THREE.PlaneGeometry(34, 24), bardaWallMat);
  bardaWallMesh.position.z = -0.002;
  bardaWallMesh.receiveShadow = true;
  envBardaGroup.add(bardaWallMesh);

  const bardaCoping = new THREE.Mesh(
    new THREE.BoxGeometry(34, 0.48, 0.65),
    new THREE.MeshStandardMaterial({ color: 0x717986, roughness: 0.82, metalness: 0.05 })
  );
  bardaCoping.position.set(0, 3.8, 0.30);
  bardaCoping.castShadow = true;
  envBardaGroup.add(bardaCoping);

  // 4. Entrada: Stucco Wall + Contemporary Entry Door + Stainless Pull Bar + Smart Doorbell
  const entradaMaps = createEntradaTextures();
  const entradaWallMat = new THREE.MeshStandardMaterial({
    color: 0xffffff,
    map: entradaMaps.stuccoMap,
    bumpMap: entradaMaps.stuccoBump,
    bumpScale: 0.04,
    roughness: 0.82,
    metalness: 0.05
  });
  const entradaWallMesh = new THREE.Mesh(new THREE.PlaneGeometry(34, 24), entradaWallMat);
  entradaWallMesh.position.z = -0.002;
  entradaWallMesh.receiveShadow = true;
  envEntradaGroup.add(entradaWallMesh);

  const doorFrame = new THREE.Mesh(
    new THREE.BoxGeometry(4.4, 11.2, 0.18),
    new THREE.MeshStandardMaterial({ color: 0x111113, roughness: 0.65 })
  );
  doorFrame.position.set(5.2, 0.5, 0.08);
  envEntradaGroup.add(doorFrame);

  const doorSlab = new THREE.Mesh(
    new THREE.BoxGeometry(4.1, 10.8, 0.14),
    new THREE.MeshStandardMaterial({
      map: entradaMaps.doorMap,
      roughness: 0.58,
      metalness: 0.08
    })
  );
  doorSlab.position.set(5.2, 0.5, 0.11);
  doorSlab.castShadow = true;
  doorSlab.receiveShadow = true;
  envEntradaGroup.add(doorSlab);

  const handleGeo = new THREE.CylinderGeometry(0.042, 0.042, 2.5, 24);
  const handleMat = new THREE.MeshStandardMaterial({ color: 0xe2e8f0, metalness: 0.95, roughness: 0.18 });
  const doorHandle = new THREE.Mesh(handleGeo, handleMat);
  doorHandle.position.set(3.45, -0.2, 0.35);
  doorHandle.castShadow = true;
  envEntradaGroup.add(doorHandle);

  const bracketGeo = new THREE.CylinderGeometry(0.035, 0.035, 0.18, 16);
  bracketGeo.rotateX(Math.PI / 2);
  const hBracketTop = new THREE.Mesh(bracketGeo, handleMat);
  hBracketTop.position.set(3.45, 0.95, 0.25);
  envEntradaGroup.add(hBracketTop);
  const hBracketBottom = new THREE.Mesh(bracketGeo, handleMat);
  hBracketBottom.position.set(3.45, -1.35, 0.25);
  envEntradaGroup.add(hBracketBottom);

  const doorbellBody = new THREE.Mesh(
    new THREE.BoxGeometry(0.25, 0.75, 0.10),
    new THREE.MeshStandardMaterial({ color: 0x18181b, roughness: 0.45, metalness: 0.6 })
  );
  doorbellBody.position.set(2.55, -0.45, 0.05);
  doorbellBody.castShadow = true;
  envEntradaGroup.add(doorbellBody);

  const doorbellRing = new THREE.Mesh(
    new THREE.CylinderGeometry(0.065, 0.065, 0.03, 20),
    new THREE.MeshStandardMaterial({
      color: 0x38bdf8,
      emissive: 0x0284c7,
      emissiveIntensity: 2.2,
      roughness: 0.2
    })
  );
  doorbellRing.rotateX(Math.PI / 2);
  doorbellRing.position.set(2.55, -0.62, 0.11);
  envEntradaGroup.add(doorbellRing);

  const porchBeam = new THREE.Mesh(
    new THREE.BoxGeometry(34, 0.65, 1.4),
    new THREE.MeshStandardMaterial({ color: 0x18181b, roughness: 0.72 })
  );
  porchBeam.position.set(0, 5.4, 0.68);
  porchBeam.castShadow = true;
  envEntradaGroup.add(porchBeam);

  const porchSpot = new THREE.SpotLight(0xfff7ed, 2.5, 14, Math.PI / 3.5, 0.45, 1.8);
  porchSpot.position.set(1.5, 5.1, 0.9);
  porchSpot.target.position.set(1.5, 0, 0);
  envEntradaGroup.add(porchSpot);
  envEntradaGroup.add(porchSpot.target);

  // Default: studio active
  envStudioGroup.visible  = true;
  envCasaGroup.visible    = false;
  envBardaGroup.visible   = false;
  envEntradaGroup.visible = false;

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

  const fontCache = {};
  const fontLoadPromises = {};
  let loadedFontFallback = null;
  const jsonFontLoader = new FontLoader();
  const ttfLoader = new TTFLoader();

  function loadJsonFont(url) {
    return new Promise((resolve, reject) => {
      jsonFontLoader.load(url, resolve, undefined, reject);
    });
  }

  async function loadFontForStyle(styleKey) {
    const spec = CATALOG.font_styles[styleKey];
    if (!spec) return null;
    if (fontCache[styleKey]) return fontCache[styleKey];
    if (fontLoadPromises[styleKey]) return fontLoadPromises[styleKey];

    fontLoadPromises[styleKey] = (async () => {
      try {
        const res = await fetch(spec.ttfUrl, { mode: 'cors' });
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const buf = await res.arrayBuffer();

        ttfLoader.reversed = false;
        let parsed = jsonFontLoader.parse(ttfLoader.parse(buf.slice(0)));
        const testO = parsed.generateShapes('O', 100) || [];
        const hasCleanHole = testO.length === 1 && testO[0].holes && testO[0].holes.length === 1;

        if (!hasCleanHole) {
          ttfLoader.reversed = true;
          const alt = jsonFontLoader.parse(ttfLoader.parse(buf.slice(0)));
          const altO = alt.generateShapes('O', 100) || [];
          if (altO.length === 1 && altO[0].holes && altO[0].holes.length === 1) {
            parsed = alt;
          }
        }
        ttfLoader.reversed = false;

        fontCache[styleKey] = parsed;
        if (!loadedFontFallback) loadedFontFallback = parsed;
        return parsed;
      } catch (err) {
        ttfLoader.reversed = false;
        try {
          const fallbackFont = await loadJsonFont(spec.fallbackJsonUrl);
          fontCache[styleKey] = fallbackFont;
          if (!loadedFontFallback) loadedFontFallback = fallbackFont;
          return fallbackFont;
        } catch (_) {
          return loadedFontFallback;
        }
      } finally {
        if (state.font_style === styleKey) {
          buildPlaqueModel();
        }
      }
    })();

    return fontLoadPromises[styleKey];
  }

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

  // ─── Procedural 45° Chamfered Athletic Octagonal Block Digits (0–9) ────
  const ATHLETIC_DIGIT_DEFS = {
    '0': {
      w: 0.68,
      outer: [
        [0.13, 0.00], [0.55, 0.00], [0.68, 0.13], [0.68, 0.87],
        [0.55, 1.00], [0.13, 1.00], [0.00, 0.87], [0.00, 0.13]
      ],
      holes: [
        [[0.21, 0.20], [0.21, 0.80], [0.47, 0.80], [0.47, 0.20]]
      ]
    },
    '1': {
      w: 0.56,
      outer: [
        [0.06, 0.00], [0.50, 0.00], [0.54, 0.04], [0.54, 0.19],
        [0.39, 0.19], [0.39, 1.00], [0.19, 1.00], [0.04, 0.85],
        [0.04, 0.69], [0.18, 0.69], [0.18, 0.19], [0.02, 0.19],
        [0.02, 0.04]
      ],
      holes: []
    },
    '2': {
      w: 0.68,
      outer: [
        [0.00, 0.00], [0.68, 0.00], [0.68, 0.20], [0.21, 0.20],
        [0.21, 0.40], [0.55, 0.40], [0.68, 0.53], [0.68, 0.87],
        [0.55, 1.00], [0.13, 1.00], [0.00, 0.87], [0.00, 0.69],
        [0.21, 0.69], [0.21, 0.80], [0.47, 0.80], [0.47, 0.60],
        [0.13, 0.60], [0.00, 0.47]
      ],
      holes: []
    },
    '3': {
      w: 0.68,
      outer: [
        [0.13, 0.00], [0.55, 0.00], [0.68, 0.13], [0.68, 0.41],
        [0.60, 0.50], [0.68, 0.59], [0.68, 0.87], [0.55, 1.00],
        [0.13, 1.00], [0.00, 0.87], [0.00, 0.71], [0.21, 0.71],
        [0.21, 0.80], [0.47, 0.80], [0.47, 0.59], [0.22, 0.59],
        [0.22, 0.41], [0.47, 0.41], [0.47, 0.20], [0.21, 0.20],
        [0.21, 0.29], [0.00, 0.29], [0.00, 0.13]
      ],
      holes: []
    },
    '4': {
      w: 0.70,
      outer: [
        [0.41, 0.00], [0.62, 0.00], [0.62, 0.25], [0.70, 0.25],
        [0.70, 0.44], [0.62, 0.44], [0.62, 1.00], [0.35, 1.00],
        [0.00, 0.44], [0.00, 0.25], [0.41, 0.25]
      ],
      holes: [
        [[0.20, 0.44], [0.41, 0.77], [0.41, 0.44]]
      ]
    },
    '5': {
      w: 0.68,
      outer: [
        [0.13, 0.00], [0.55, 0.00], [0.68, 0.13], [0.68, 0.50],
        [0.55, 0.63], [0.21, 0.63], [0.21, 0.80], [0.64, 0.80],
        [0.64, 1.00], [0.02, 1.00], [0.02, 0.44], [0.47, 0.44],
        [0.47, 0.20], [0.21, 0.20], [0.21, 0.29], [0.00, 0.29],
        [0.00, 0.13]
      ],
      holes: []
    },
    '6': {
      w: 0.68,
      outer: [
        [0.13, 0.00], [0.55, 0.00], [0.68, 0.13], [0.68, 0.47],
        [0.55, 0.60], [0.21, 0.60], [0.21, 0.80], [0.47, 0.80],
        [0.47, 0.72], [0.68, 0.72], [0.68, 0.87], [0.55, 1.00],
        [0.13, 1.00], [0.00, 0.87], [0.00, 0.13]
      ],
      holes: [
        [[0.21, 0.20], [0.21, 0.41], [0.47, 0.41], [0.47, 0.20]]
      ]
    },
    '7': {
      w: 0.66,
      outer: [
        [0.18, 0.00], [0.40, 0.00], [0.66, 0.79], [0.66, 1.00],
        [0.00, 1.00], [0.00, 0.71], [0.20, 0.71], [0.20, 0.80],
        [0.43, 0.80]
      ],
      holes: []
    },
    '8': {
      w: 0.68,
      outer: [
        [0.13, 0.00], [0.55, 0.00], [0.68, 0.13], [0.68, 0.39],
        [0.60, 0.50], [0.68, 0.61], [0.68, 0.87], [0.55, 1.00],
        [0.13, 1.00], [0.00, 0.87], [0.00, 0.61], [0.08, 0.50],
        [0.00, 0.39], [0.00, 0.13]
      ],
      holes: [
        [[0.21, 0.19], [0.21, 0.41], [0.47, 0.41], [0.47, 0.19]],
        [[0.21, 0.59], [0.21, 0.81], [0.47, 0.81], [0.47, 0.59]]
      ]
    }
  };
  // 9 is exact 180-degree rotational mirror of 6
  ATHLETIC_DIGIT_DEFS['9'] = {
    w: ATHLETIC_DIGIT_DEFS['6'].w,
    outer: ATHLETIC_DIGIT_DEFS['6'].outer.map(([x, y]) => [+(0.68 - x).toFixed(4), +(1.00 - y).toFixed(4)]),
    holes: ATHLETIC_DIGIT_DEFS['6'].holes.map(h => h.map(([x, y]) => [+(0.68 - x).toFixed(4), +(1.00 - y).toFixed(4)]))
  };

  function getAthleticBlockDigit(ch, fontSize) {
    const def = ATHLETIC_DIGIT_DEFS[ch];
    if (!def) return null;
    const outerPts = def.outer.map(([x, y]) => new THREE.Vector2(x * fontSize, y * fontSize));
    const holePtsList = def.holes.map(h => h.map(([x, y]) => new THREE.Vector2(x * fontSize, y * fontSize)));
    return {
      advance: def.w * fontSize,
      contours: [{ outerPts, holePtsList }]
    };
  }

  function extractRawCharContours(ch, fontSize, curveDivisions, useProceduralDigits, activeFont, resolution, glyphs) {
    if (useProceduralDigits && /^[0-9]$/.test(ch)) {
      const proc = getAthleticBlockDigit(ch, fontSize);
      if (proc) {
        return { advance: proc.advance, contours: proc.contours };
      }
    }

    if (!activeFont) {
      return { advance: fontSize * 0.62, contours: [] };
    }

    const glyphMeta = glyphs[ch] || glyphs['?'];
    if (!glyphMeta) {
      return { advance: fontSize * 0.50, contours: [] };
    }

    const glyphShapes = activeFont.generateShapes(ch, fontSize) || [];
    const advance = typeof glyphMeta.ha === 'number'
      ? (glyphMeta.ha / resolution) * fontSize
      : fontSize * 0.65;

    const contours = [];
    for (const shape of glyphShapes) {
      const outerPts = sampleCleanPoints(shape, curveDivisions);
      if (!outerPts) continue;

      const holePtsList = [];
      for (const hole of (shape.holes || [])) {
        const holePts = sampleCleanPoints(hole, curveDivisions);
        if (!holePts) continue;
        holePtsList.push(holePts);
      }

      contours.push({ outerPts, holePtsList });
    }

    return { advance, contours };
  }

  // Builds centered & auto-fitted per-character 2D contours in plaque XY coordinates
  function buildCharGlyphLayouts(text, fontSize, maxWidth, maxHeight, targetY, curveDivisions, fontStyleKey, activeFont, verticalStack = false) {
    if (!text) {
      return { characters: [], effectiveFontSize: fontSize };
    }

    const fontSpec = CATALOG.font_styles[fontStyleKey] || CATALOG.font_styles.athletic_block;
    const useProceduralDigits = Boolean(fontSpec.useProceduralDigits);
    const normalizedText = verticalStack ? text.replace(/\s+/g, ' ').trim() : text;
    if (!normalizedText) {
      return { characters: [], effectiveFontSize: fontSize };
    }

    const chars = Array.from(normalizedText);
    const extraSpacing = fontSize * 0.055;
    const resolution = activeFont?.data?.resolution || 1000;
    const glyphs = activeFont?.data?.glyphs || {};

    let minX = Infinity, maxX = -Infinity, minY = Infinity, maxY = -Infinity;
    const rawChars = [];

    if (verticalStack) {
      const charGap = fontSize * 0.10;
      const wordGap = fontSize * 0.40;
      let cursorY = 0;
      let pendingGap = 0;

      for (const ch of chars) {
        if (ch === ' ') {
          if (rawChars.length > 0) {
            pendingGap = Math.max(pendingGap, wordGap);
          }
          continue;
        }

        const extracted = extractRawCharContours(
          ch, fontSize, curveDivisions, useProceduralDigits, activeFont, resolution, glyphs
        );
        if (!extracted.contours || extracted.contours.length === 0) {
          continue;
        }

        let gMinX = Infinity, gMaxX = -Infinity, gMinY = Infinity, gMaxY = -Infinity;
        for (const c of extracted.contours) {
          for (const p of c.outerPts) {
            if (p.x < gMinX) gMinX = p.x;
            if (p.x > gMaxX) gMaxX = p.x;
            if (p.y < gMinY) gMinY = p.y;
            if (p.y > gMaxY) gMaxY = p.y;
          }
        }
        if (!Number.isFinite(gMinX)) {
          continue;
        }

        if (rawChars.length > 0) {
          cursorY -= pendingGap;
        }

        const gCenterX = (gMinX + gMaxX) / 2;
        const actualH = Math.max(gMaxY - gMinY, 1e-4);
        const slotH = Math.max(actualH, fontSize * 0.18);
        const dx = -gCenterX;
        const dy = cursorY - (slotH - actualH) / 2 - gMaxY;

        const shiftedContours = extracted.contours.map(c => ({
          outerPts: c.outerPts.map(p => {
            const sx = p.x + dx;
            const sy = p.y + dy;
            if (sx < minX) minX = sx;
            if (sx > maxX) maxX = sx;
            if (sy < minY) minY = sy;
            if (sy > maxY) maxY = sy;
            return new THREE.Vector2(sx, sy);
          }),
          holePtsList: c.holePtsList.map(h => h.map(p => new THREE.Vector2(p.x + dx, p.y + dy)))
        }));

        rawChars.push({ char: ch, contours: shiftedContours });
        cursorY -= slotH;
        pendingGap = charGap;
      }
    } else {
      let cursorX = 0;

      for (const ch of chars) {
        if (ch === ' ') {
          const sp = glyphs[' '];
          const spAdv = sp && typeof sp.ha === 'number' ? (sp.ha / resolution) * fontSize : fontSize * 0.35;
          cursorX += spAdv + extraSpacing;
          continue;
        }

        const extracted = extractRawCharContours(
          ch, fontSize, curveDivisions, useProceduralDigits, activeFont, resolution, glyphs
        );

        if (extracted.contours.length > 0) {
          const shiftedContours = extracted.contours.map(c => ({
            outerPts: c.outerPts.map(p => {
              const sx = p.x + cursorX;
              const sy = p.y;
              if (sx < minX) minX = sx;
              if (sx > maxX) maxX = sx;
              if (sy < minY) minY = sy;
              if (sy > maxY) maxY = sy;
              return new THREE.Vector2(sx, sy);
            }),
            holePtsList: c.holePtsList.map(h => h.map(p => new THREE.Vector2(p.x + cursorX, p.y)))
          }));
          rawChars.push({ char: ch, contours: shiftedContours });
        }
        cursorX += extracted.advance + extraSpacing;
      }
    }

    if (rawChars.length === 0 || !Number.isFinite(minX)) {
      return { characters: [], effectiveFontSize: fontSize };
    }

    const rawW = Math.max(maxX - minX, 1e-4);
    const rawH = Math.max(maxY - minY, 1e-4);
    const centerX = (minX + maxX) / 2;
    const centerY = (minY + maxY) / 2;
    const fitScale = verticalStack
      ? Math.min(maxWidth / rawW, maxHeight / rawH)
      : Math.min(1, maxWidth / rawW, maxHeight / rawH);

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

  function addLayoutToAcrylicAndAcm(
    layout,
    extrusionDepth,
    bevelThickness,
    bevelScale,
    bevelSizeMax,
    zAcrylicMount,
    acrylicMaterial,
    acmDepth,
    acmFaceMat,
    acmEdgeMat,
    safeHalfW,
    safeHalfH,
    isCncCut,
    acmHolesList,
    acmIslandsQueue
  ) {
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

        const bevelSize = Math.min(bevelSizeMax, layout.effectiveFontSize * bevelScale);
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
        charMesh.position.z = backOffsetZ + zAcrylicMount;
        charMesh.castShadow = true;
        charMesh.receiveShadow = true;
        acrylicDigitsLayer.add(charMesh);

        // 2. Register Matching CNC Cutout Hole + Inner Island ONLY when cnc_cut_acm is active
        if (isCncCut) {
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
  }

  function buildPlaqueModel() {
    clearGroup(standoffsRearLayer);
    clearGroup(sintraBackLayer);
    clearGroup(acrylicDigitsLayer);
    clearGroup(acmFrontLayer);
    clearGroup(standoffsCapLayer);
    clearGroup(wallContactShadowsLayer);

    const sizeSpec = CATALOG.sizes[state.size] || CATALOG.sizes.medium;
    const acmSpec = CATALOG.acm_finishes[state.acm_finish] || CATALOG.acm_finishes.matte_black;
    const acrylicSpec = CATALOG.acrylic_finishes[state.acrylic_finish] || CATALOG.acrylic_finishes.mirror_gold;
    const sintraSpec = CATALOG.sintra_colors[state.sintra_color] || CATALOG.sintra_colors.black;
    const standoffSpec = CATALOG.standoff_finishes[state.standoff_finish] || CATALOG.standoff_finishes.silver;
    const fontSpec = CATALOG.font_styles[state.font_style] || CATALOG.font_styles.athletic_block;
    const isCncCut = state.construction_style === 'cnc_cut_acm';
    const isVertical = Boolean(sizeSpec.isVertical || state.size === 'vertical');

    const activeFont = fontCache[state.font_style] || loadedFontFallback;

    const width = isVertical ? sizeSpec.w : (state.plaque_type === 'business' ? sizeSpec.w * 1.08 : sizeSpec.w);
    const height = isVertical ? sizeSpec.h : (state.plaque_type === 'business' ? sizeSpec.h * 0.95 : sizeSpec.h);
    const cornerRadius = 0.28;

    // ─── Materials ───────────────────────────────────────────────────────
    const sintraMat = new THREE.MeshStandardMaterial({
      color: sintraSpec.color,
      roughness: sintraSpec.roughness,
      metalness: sintraSpec.metalness,
      envMapIntensity: sintraSpec.envMapIntensity ?? 0.50
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
      roughness: 0.55,
      metalness: 0.25,
      envMapIntensity: 0.75
    });

    const acrylicMat = new THREE.MeshStandardMaterial({
      color: acrylicSpec.color,
      metalness: acrylicSpec.metalness,
      roughness: acrylicSpec.roughness,
      envMapIntensity: acrylicSpec.envMapIntensity ?? 1.0
    });

    const standoffMat = new THREE.MeshStandardMaterial({
      color: standoffSpec.color,
      metalness: standoffSpec.metalness,
      roughness: standoffSpec.roughness,
      envMapIntensity: standoffSpec.envMapIntensity ?? 1.20
    });

    // ─── 1. Two Centered Lateral Metallic Standoffs (or Top/Bottom for Vertical) ───
    const mountPoints = isVertical
      ? [[0, height / 2 - 0.38], [0, -(height / 2 - 0.38)]]
      : [[-(width / 2 - 0.34), 0], [width / 2 - 0.34, 0]];

    const barrelGeo = new THREE.CylinderGeometry(0.11, 0.11, 0.50, 28);
    barrelGeo.rotateX(Math.PI / 2);

    const capGeo = new THREE.CylinderGeometry(0.135, 0.135, 0.085, 28);
    capGeo.rotateX(Math.PI / 2);

    // CNC mode: ACM front face sits at z = 0.147 -> cap center 0.190
    // Raised mode: Solid ACM front face sits at z = 0.000 -> cap center 0.043
    const frontCapZ = isCncCut ? 0.190 : 0.043;

    const contactGeo = new THREE.PlaneGeometry(0.55, 0.55);

    mountPoints.forEach(([cx, cy]) => {
      const barrel = new THREE.Mesh(barrelGeo.clone(), standoffMat.clone());
      barrel.position.set(cx, cy, -0.37); // Spans -0.62 (wall) to -0.12 (rear of Sintra or Solid ACM)
      barrel.castShadow = true;
      standoffsRearLayer.add(barrel);

      const cap = new THREE.Mesh(capGeo.clone(), standoffMat.clone());
      cap.position.set(cx, cy, frontCapZ);
      cap.castShadow = true;
      standoffsCapLayer.add(cap);

      const contactDisc = new THREE.Mesh(
        contactGeo.clone(),
        new THREE.MeshBasicMaterial({
          map: contactShadowTexture,
          transparent: true,
          opacity: 0.72,
          depthWrite: false
        })
      );
      contactDisc.position.set(cx, cy, 0.002); // Sits directly on the wall plane at wallGroup (z = -0.62)
      wallContactShadowsLayer.add(contactDisc);
    });

    barrelGeo.dispose();
    capGeo.dispose();
    contactGeo.dispose();
    standoffMat.dispose();

    // ─── 2. Black Sintra PVC Backing Layer (CNC Cut Mode Only) ───────────
    if (isCncCut) {
      const sintraShape = createRoundedRectShape(width, height, cornerRadius);
      mountPoints.forEach(([cx, cy]) => {
        sintraShape.holes.push(createCirclePath(cx, cy, 0.095, 20));
      });

      const sintraGeo = new THREE.ExtrudeGeometry(sintraShape, {
        depth: 0.12,
        bevelEnabled: false,
        curveSegments: 10
      });
      const sintraMesh = new THREE.Mesh(sintraGeo, sintraMat);
      sintraMesh.position.z = -0.12; // Flush front surface at z = 0.000
      sintraMesh.castShadow = true;
      sintraMesh.receiveShadow = true;
      sintraBackLayer.add(sintraMesh);
    } else {
      sintraMat.dispose();
    }

    // ─── 3. Individual 3D Acrylic Digits & Subtitle + ACM Plate ──────────
    // CNC mode: visible thick 0.145 ACM front plate at z=0.002..0.147 + recessed 0.086 acrylic shadow box
    // Raised mode: solid 0.120 ACM at z=-0.120..0.000 + bold 0.197 tall protruding acrylic numbers
    const acmDepth = isCncCut ? 0.145 : 0.120;
    const acmPosZ = isCncCut ? 0.002 : -0.120;
    const zAcrylicMount = isCncCut ? 0.000 : 0.002;
    const primaryExtrudeDepth = isCncCut ? 0.068 : 0.165;
    const primaryBevelThickness = isCncCut ? 0.009 : 0.016;
    const subtitleExtrudeDepth = isCncCut ? 0.062 : 0.085;
    const subtitleBevelThickness = isCncCut ? 0.006 : 0.008;
    const dividerExtrudeDepth = isCncCut ? 0.060 : 0.065;
    const dividerBevelThickness = isCncCut ? 0.005 : 0.006;

    const acmShape = createRoundedRectShape(width, height, cornerRadius);
    const acmHolesList = [];
    const acmIslandsQueue = [];

    mountPoints.forEach(([cx, cy]) => {
      acmHolesList.push(createCirclePath(cx, cy, 0.095, 20));
    });

    const primaryStr = (state.primary_text || '428').trim().toUpperCase();
    const subtitleStr = isVertical ? '' : (state.subtitle_text || '').trim().toUpperCase();

    const safeHalfW = isVertical ? (width / 2 - 0.14) : (width / 2 - 0.50);
    const safeHalfH = isVertical ? (height / 2 - 0.54) : (height / 2 - 0.16);
    const maxTextWidth = isVertical ? 1.65 : (width - 1.24);

    // Hero Primary 3D Text (Protagonist Scale; spans full height between standoffs on Vertical Column)
    const primaryMaxH = isVertical
      ? 5.20
      : (subtitleStr ? 1.82 : 2.25);
    const primaryTargetY = isVertical
      ? 0.0
      : (subtitleStr ? 0.36 : 0.0);
    const basePrimarySize = isVertical
      ? 1.0
      : (state.plaque_type === 'house' ? (subtitleStr ? 1.85 : 2.20) : (subtitleStr ? 1.15 : 1.35));

    const primaryLayout = buildCharGlyphLayouts(
      primaryStr,
      basePrimarySize,
      maxTextWidth,
      primaryMaxH,
      primaryTargetY,
      8,
      state.font_style,
      activeFont,
      isVertical
    );

    addLayoutToAcrylicAndAcm(
      primaryLayout,
      primaryExtrudeDepth,
      primaryBevelThickness,
      fontSpec.bevelScale,
      fontSpec.maxPrimaryBevel,
      zAcrylicMount,
      acrylicMat,
      acmDepth,
      acmFaceMat,
      acmEdgeMat,
      safeHalfW,
      safeHalfH,
      isCncCut,
      acmHolesList,
      acmIslandsQueue
    );

    // Optional Secondary Subtitle & Slim Architectural Divider Bar (Only for horizontal plaques)
    if (!isVertical && subtitleStr) {
      const subTargetY = -1.06;
      const subMaxH = 0.28;
      const baseSubSize = 0.28;

      const subLayout = buildCharGlyphLayouts(
        subtitleStr,
        baseSubSize,
        maxTextWidth,
        subMaxH,
        subTargetY,
        6,
        state.font_style,
        activeFont,
        false
      );

      addLayoutToAcrylicAndAcm(
        subLayout,
        subtitleExtrudeDepth,
        subtitleBevelThickness,
        fontSpec.bevelScale,
        fontSpec.maxSubBevel,
        zAcrylicMount,
        acrylicMat,
        acmDepth,
        acmFaceMat,
        acmEdgeMat,
        safeHalfW,
        safeHalfH,
        isCncCut,
        acmHolesList,
        acmIslandsQueue
      );

      const dividerW = Math.min(width * 0.38, 2.0);
      const dividerH = 0.032;
      const dividerY = -0.72;

      const divShape = createRoundedRectShape(dividerW, dividerH, 0.015);
      const divPtsRaw = sampleCleanPoints(divShape, 4);
      if (divPtsRaw) {
        const divPtsAcrylic = ensureWinding(
          divPtsRaw.map(p => new THREE.Vector2(p.x, p.y + dividerY)),
          false
        );
        const divAcrylicShape = new THREE.Shape(divPtsAcrylic);
        divAcrylicShape.closePath();

        const divGeo = new THREE.ExtrudeGeometry(divAcrylicShape, {
          depth: dividerExtrudeDepth,
          bevelEnabled: true,
          bevelThickness: dividerBevelThickness,
          bevelSize: 0.0025,
          bevelOffset: -0.0025,
          bevelSegments: 2
        });
        divGeo.computeBoundingBox();
        const divBackZ = divGeo.boundingBox ? -divGeo.boundingBox.min.z : 0;
        const divMesh = new THREE.Mesh(divGeo, acrylicMat);
        divMesh.position.z = divBackZ + zAcrylicMount;
        divMesh.castShadow = true;
        divMesh.receiveShadow = true;
        acrylicDigitsLayer.add(divMesh);

        if (isCncCut) {
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

    // ─── 4. Front ACM Plate (CNC Cutout Holes OR Solid Panel) ───────────
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
      mountPoints.forEach(([cx, cy]) => {
        fallbackAcm.holes.push(createCirclePath(cx, cy, 0.095, 20));
      });
      acmGeo = new THREE.ExtrudeGeometry(fallbackAcm, {
        depth: acmDepth,
        bevelEnabled: false,
        curveSegments: 8
      });
    }

    const acmMesh = new THREE.Mesh(acmGeo, [acmFaceMat, acmEdgeMat]);
    acmMesh.position.z = acmPosZ;
    acmMesh.castShadow = true;
    acmMesh.receiveShadow = true;
    acmFrontLayer.add(acmMesh);

    // Floating Inner Counter Islands of the ACM Plate (CNC Cut Mode Only)
    if (isCncCut) {
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
  }

  // Load initial typeface (procedural Athletic Block digits render immediately) & build initial model
  loadFontForStyle(state.font_style);
  buildPlaqueModel();

  // Quietly preload the remaining font styles in the background for instant switching
  setTimeout(() => {
    Object.keys(CATALOG.font_styles).forEach(key => {
      if (key !== state.font_style) loadFontForStyle(key);
    });
  }, 600);

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
      const cx = isVertical ? 0 : (width / 2 - 0.34);
      const cy = isVertical ? (height / 2 - 0.38) : 0;
      targetControlsLook.set(cx, cy, 0);
      targetCameraPos.set(cx + 1.15, cy + 0.55, 3.20);
    } else {
      const preset = CAM_PRESETS[currentCamKey] || CAM_PRESETS.front;
      const offsetX = state.environment === 'entrada' ? 0.65 : 0;
      targetCameraPos.set(
        preset.pos[0] * camScale + offsetX,
        preset.pos[1] * camScale,
        preset.pos[2] * camScale
      );
      targetControlsLook.set(preset.look[0] + offsetX, preset.look[1], preset.look[2]);
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

  // ─── Real-World Environment Switcher (Studio, Casa, Barda, Entrada) ───
  function setEnvironment(envKey) {
    state.environment = envKey;
    envStudioGroup.visible  = (envKey === 'studio');
    envCasaGroup.visible    = (envKey === 'casa');
    envBardaGroup.visible   = (envKey === 'barda');
    envEntradaGroup.visible = (envKey === 'entrada');

    // Adapt directional & ambient lighting per environment
    if (envKey === 'barda') {
      keyLight.intensity = 2.4;
      ambientLight.intensity = 0.55;
      fillLight.intensity = 0.65;
    } else if (envKey === 'casa') {
      keyLight.intensity = 1.6;
      ambientLight.intensity = 0.35;
      fillLight.intensity = 0.75;
    } else if (envKey === 'entrada') {
      keyLight.intensity = 1.6;
      ambientLight.intensity = 0.38;
      fillLight.intensity = 0.75;
    } else {
      keyLight.intensity = 1.8;
      ambientLight.intensity = 0.35;
      fillLight.intensity = 0.75;
    }

    // Re-frame camera smoothly if needed
    if (currentCamKey !== 'mounts') {
      applyCameraPreset(currentCamKey);
    }

    document.querySelectorAll('[data-env]').forEach(btn => {
      btn.classList.toggle('active', btn.dataset.env === envKey);
    });

    const hintEl = document.getElementById('env-description-hint');
    if (hintEl) {
      hintEl.textContent = (CATALOG.environments && CATALOG.environments[envKey])
        ? CATALOG.environments[envKey].hint
        : '';
    }
  }

  document.querySelectorAll('[data-env]').forEach(btn => {
    btn.addEventListener('click', () => {
      setEnvironment(btn.dataset.env);
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

    // Smooth Exploded Assembly View per active Construction Style
    const targetExplode = state.exploded ? 1.0 : 0.0;
    explodeProgress += (targetExplode - explodeProgress) * 0.09;

    if (state.construction_style === 'cnc_cut_acm') {
      // Back → Front: 1. Rear Standoffs → 2. Black Sintra → 3. Acrylic Digits → 4. CNC ACM Plate → 5. Front Caps
      standoffsRearLayer.position.z = -explodeProgress * 1.60;
      sintraBackLayer.position.z    = -explodeProgress * 0.80;
      acrylicDigitsLayer.position.z =  explodeProgress * 0.15;
      acmFrontLayer.position.z      =  explodeProgress * 1.15;
      standoffsCapLayer.position.z  =  explodeProgress * 1.65;
      wallGroup.position.z          = -0.62 - explodeProgress * 1.65;
    } else {
      // Back → Front: 1. Rear Standoffs → 2. Solid ACM Plate → 3. Raised Acrylic Digits → 4. Front Caps
      standoffsRearLayer.position.z = -explodeProgress * 1.45;
      sintraBackLayer.position.z    =  0;
      acmFrontLayer.position.z      = -explodeProgress * 0.45;
      acrylicDigitsLayer.position.z =  explodeProgress * 0.55;
      standoffsCapLayer.position.z  =  explodeProgress * 1.30;
      wallGroup.position.z          = -0.62 - explodeProgress * 1.50;
    }

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

  // ─── UI Reactivity, Pricing Updates & Browser Event Bridge ────────────
  function updatePricingAndSummaryUI() {
    const sizeSpec = CATALOG.sizes[state.size] || CATALOG.sizes.medium;
    const constructionSpec = CATALOG.construction_styles[state.construction_style] || CATALOG.construction_styles.raised_acrylic;
    const fontSpec = CATALOG.font_styles[state.font_style] || CATALOG.font_styles.athletic_block;
    const acmSpec = CATALOG.acm_finishes[state.acm_finish] || CATALOG.acm_finishes.matte_black;
    const acrylicSpec = CATALOG.acrylic_finishes[state.acrylic_finish] || CATALOG.acrylic_finishes.mirror_gold;
    const sintraSpec = CATALOG.sintra_colors[state.sintra_color] || CATALOG.sintra_colors.black;
    const standoffSpec = CATALOG.standoff_finishes[state.standoff_finish] || CATALOG.standoff_finishes.silver;
    const isCncCut = state.construction_style === 'cnc_cut_acm';
    const isVertical = Boolean(sizeSpec.isVertical || state.size === 'vertical');

    state.base_price_cad = sizeSpec.price;
    state.cnc_surcharge_cad = isCncCut ? (sizeSpec.cncSurcharge || 0) : 0;
    state.subtotal_cad = Math.round((state.base_price_cad + state.cnc_surcharge_cad) * 100) / 100;
    state.hst_cad = Math.round(state.subtotal_cad * 0.15 * 100) / 100;
    state.total_cad = Math.round((state.subtotal_cad + state.hst_cad) * 100) / 100;

    const fmtSub = '$' + state.subtotal_cad.toFixed(2);
    const fmtHst = '$' + state.hst_cad.toFixed(2);
    const fmtTot = '$' + state.total_cad.toFixed(2) + ' CAD';

    document.getElementById('price-subtotal').textContent = fmtSub;
    document.getElementById('price-hst').textContent = fmtHst;
    document.getElementById('price-total').textContent = fmtTot;

    const submitBtn = document.getElementById('btnSubmitOrder');
    const submitLabel = document.getElementById('btnSubmitLabel');
    const submitIcon = document.getElementById('btnSubmitIcon');
    const submitTotal = document.getElementById('btn-submit-total');
    if (submitTotal) {
      submitTotal.textContent = fmtTot;
    }
    if (submitLabel && submitIcon && submitBtn) {
      if (state.payment_method === 'interac') {
        submitBtn.classList.add('mode-interac');
        submitIcon.className = 'bi bi-bank2 text-warning';
        submitLabel.innerHTML = `Place Order via Interac e-Transfer &mdash; <strong id="btn-submit-total">${fmtTot}</strong>`;
      } else {
        submitBtn.classList.remove('mode-interac');
        submitIcon.className = 'bi bi-lock-fill';
        submitLabel.innerHTML = `Proceed to Secure Payment &mdash; <strong id="btn-submit-total">${fmtTot}</strong>`;
      }
    }

    const footerTotal = document.getElementById('footer-step-total');
    if (footerTotal) {
      footerTotal.textContent = fmtTot;
    }

    const materialsPill = document.getElementById('materials-live-pill');
    if (materialsPill) {
      materialsPill.textContent =
        `${acmSpec.shortName} ACM • ${acrylicSpec.shortName}${isCncCut ? ' • ' + sintraSpec.shortName : ''} • ${standoffSpec.shortName} Standoffs`;
    }

    // Update dynamic CNC surcharge badge for currently selected plaque size
    const cncBadge = document.getElementById('cnc-surcharge-badge');
    if (cncBadge) {
      cncBadge.textContent = `+$${sizeSpec.cncSurcharge || 10} CAD`;
    }

    // Update every size tile price label dynamically when toggling raised_acrylic vs cnc_cut_acm
    document.querySelectorAll('[data-size]').forEach(tile => {
      const sSpec = CATALOG.sizes[tile.dataset.size];
      const priceEl = tile.querySelector('.size-tile-price');
      if (sSpec && priceEl) {
        const displayPrice = sSpec.price + (isCncCut ? (sSpec.cncSurcharge || 0) : 0);
        tile.dataset.price = String(displayPrice);
        priceEl.textContent = `$${displayPrice} CAD`;
      }
    });

    // Update viewer & pre-checkout summaries
    const backingDetail = isCncCut
      ? `${sintraSpec.shortName} • 2 Lateral ${standoffSpec.shortName} Standoffs`
      : `2 Lateral ${standoffSpec.shortName} Standoffs`;

    document.getElementById('summary-finish-name').textContent =
      `${constructionSpec.shortName} • ${acmSpec.shortName} ACM + ${acrylicSpec.shortName}`;
    document.getElementById('summary-size-dims').textContent =
      `${sizeSpec.shortLabel} • ${fontSpec.shortName} • ${backingDetail}`;

    const legendPill = document.getElementById('assemblyLegendPill');
    if (legendPill) {
      const legendText = isCncCut
        ? `1. ${standoffSpec.shortName} Standoffs → 2. ${sintraSpec.shortName} → 3. Acrylic Digits → 4. CNC Cut ACM → 5. Standoff Caps`
        : `1. ${standoffSpec.shortName} Standoffs → 2. Solid ACM Plate → 3. Raised Acrylic Digits → 4. Standoff Caps`;
      legendPill.innerHTML = `<i class="bi bi-layers-half text-info me-1"></i> ${legendText}`;
    }

    const sintraWrap = document.getElementById('sintraSelectorWrap');
    if (sintraWrap) {
      sintraWrap.classList.toggle('sintra-selector-muted', !isCncCut);
    }
    const sintraHint = document.getElementById('sintra-mode-hint');
    if (sintraHint) {
      sintraHint.textContent = isCncCut ? 'Active • 6mm PVC' : 'Selecting enables CNC Cut ACM';
    }

    document.getElementById('review-construction').textContent = constructionSpec.name;
    document.getElementById('review-font').textContent = fontSpec.name;
    document.getElementById('review-materials').textContent = `${acmSpec.name} + ${acrylicSpec.name}`;
    const reviewSintraRow = document.getElementById('review-sintra-row');
    if (reviewSintraRow) {
      reviewSintraRow.classList.toggle('d-none', !isCncCut);
    }
    const reviewSintra = document.getElementById('review-sintra');
    if (reviewSintra) {
      reviewSintra.textContent = sintraSpec.name;
    }
    const reviewStandoffs = document.getElementById('review-standoffs');
    if (reviewStandoffs) {
      reviewStandoffs.textContent = `2 Lateral ${standoffSpec.name}`;
    }
    const reviewFulfillment = document.getElementById('review-fulfillment');
    if (reviewFulfillment) {
      if (state.delivery_method === 'shipping') {
        const city = (document.getElementById('shippingCity')?.value || '').trim();
        const prov = (document.getElementById('shippingProvince')?.value || '').trim();
        const postal = (document.getElementById('shippingPostal')?.value || '').trim();
        if (city && prov) {
          reviewFulfillment.textContent = `Direct Shipping (${city}, ${prov}${postal ? ' ' + postal : ''})`;
        } else {
          reviewFulfillment.textContent = 'Direct Shipping (Address below)';
        }
      } else {
        reviewFulfillment.textContent = 'Pick Up in Store (Charlottetown, PEI)';
      }
    }
    const reviewPayment = document.getElementById('review-payment-method');
    if (reviewPayment) {
      reviewPayment.textContent = state.payment_method === 'interac'
        ? 'Interac e-Transfer'
        : 'Credit / Debit Card (Instant)';
    }
    document.getElementById('review-size').textContent =
      isCncCut && state.cnc_surcharge_cad > 0
        ? `${sizeSpec.shortLabel} (+$${state.cnc_surcharge_cad} CNC)`
        : sizeSpec.shortLabel;
    document.getElementById('review-total').textContent = fmtTot;

    const typeLabel = state.plaque_type === 'business' ? 'Business Signage' : 'House Plaque';
    document.getElementById('viewer-spec-text').textContent = `${typeLabel} • ${sizeSpec.shortLabel}`;

    // On Vertical Column, civic numbers span the full vertical height; subtitle is omitted
    const subtitleGroup = document.getElementById('subtitleInputGroup');
    const subtitleHint = document.getElementById('subtitle-vertical-hint');
    const subtitleInputEl = document.getElementById('subtitleTextInput');
    const subtitleLabel = subtitleGroup?.querySelector('label');
    if (subtitleHint && subtitleInputEl && subtitleLabel) {
      if (isVertical) {
        subtitleInputEl.classList.add('d-none');
        subtitleLabel.classList.add('d-none');
        subtitleHint.classList.remove('d-none');
      } else {
        subtitleInputEl.classList.remove('d-none');
        subtitleLabel.classList.remove('d-none');
        subtitleHint.classList.add('d-none');
      }
    }

    resetCheckoutKey();
  }

  function dispatchPlaqueUpdate() {
    window.dispatchEvent(new CustomEvent('update-3d-plaque', { detail: { ...state } }));
  }

  window.addEventListener('update-3d-plaque', () => {
    try {
      updatePricingAndSummaryUI();
    } catch (err) {
      console.error('UI summary update error:', err);
    }
    buildPlaqueModel();
  });

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
      dispatchPlaqueUpdate();
    });
  });

  // Construction Style Switch (raised_acrylic vs cnc_cut_acm)
  document.querySelectorAll('[data-construction-style]').forEach(tile => {
    tile.addEventListener('click', () => {
      document.querySelectorAll('[data-construction-style]').forEach(t => t.classList.remove('active'));
      tile.classList.add('active');
      state.construction_style = tile.dataset.constructionStyle;
      dispatchPlaqueUpdate();
    });
  });

  // Live Text Inputs
  const primaryInput = document.getElementById('primaryTextInput');
  const subtitleInput = document.getElementById('subtitleTextInput');

  primaryInput.addEventListener('input', (e) => {
    state.primary_text = e.target.value || ' ';
    document.getElementById('char-counter').textContent = `${e.target.value.length} / 24`;
    dispatchPlaqueUpdate();
  });

  subtitleInput.addEventListener('input', (e) => {
    state.subtitle_text = e.target.value;
    dispatchPlaqueUpdate();
  });

  // Font Style Switch (athletic_block, modern_sans)
  document.querySelectorAll('[data-font-style]').forEach(tile => {
    tile.addEventListener('click', () => {
      document.querySelectorAll('[data-font-style]').forEach(t => t.classList.remove('active'));
      tile.classList.add('active');
      state.font_style = tile.dataset.fontStyle;
      dispatchPlaqueUpdate();
      if (!fontCache[state.font_style]) {
        loadFontForStyle(state.font_style);
      }
    });
  });

  // ACM Front Plate Finish Selection
  document.querySelectorAll('[data-acm-finish]').forEach(tile => {
    tile.addEventListener('click', () => {
      document.querySelectorAll('[data-acm-finish]').forEach(t => t.classList.remove('active'));
      tile.classList.add('active');
      state.acm_finish = tile.dataset.acmFinish;
      dispatchPlaqueUpdate();
    });
  });

  // Acrylic Digits Finish Selection
  document.querySelectorAll('[data-acrylic-finish]').forEach(tile => {
    tile.addEventListener('click', () => {
      document.querySelectorAll('[data-acrylic-finish]').forEach(t => t.classList.remove('active'));
      tile.classList.add('active');
      state.acrylic_finish = tile.dataset.acrylicFinish;
      dispatchPlaqueUpdate();
    });
  });

  // 6mm Sintra Backing Color Selection
  document.querySelectorAll('[data-sintra-color]').forEach(tile => {
    tile.addEventListener('click', () => {
      document.querySelectorAll('[data-sintra-color]').forEach(t => t.classList.remove('active'));
      tile.classList.add('active');
      state.sintra_color = tile.dataset.sintraColor;

      // Switch to CNC Cut ACM automatically so the 6mm Sintra backing is visible
      if (state.construction_style !== 'cnc_cut_acm') {
        state.construction_style = 'cnc_cut_acm';
        document.querySelectorAll('[data-construction-style]').forEach(c => {
          c.classList.toggle('active', c.dataset.constructionStyle === 'cnc_cut_acm');
        });
      }

      dispatchPlaqueUpdate();
    });
  });

  // Standoff Hardware Finish Selection
  document.querySelectorAll('[data-standoff-finish]').forEach(tile => {
    tile.addEventListener('click', () => {
      document.querySelectorAll('[data-standoff-finish]').forEach(t => t.classList.remove('active'));
      tile.classList.add('active');
      state.standoff_finish = tile.dataset.standoffFinish;
      dispatchPlaqueUpdate();
    });
  });

  // Size Selection
  document.querySelectorAll('[data-size]').forEach(tile => {
    tile.addEventListener('click', () => {
      document.querySelectorAll('[data-size]').forEach(t => t.classList.remove('active'));
      tile.classList.add('active');
      state.size = tile.dataset.size;
      dispatchPlaqueUpdate();
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
    dispatchPlaqueUpdate();
  });

  // Delivery / Fulfillment Option Selection (pickup vs shipping)
  document.querySelectorAll('[data-delivery]').forEach(tile => {
    tile.addEventListener('click', () => {
      document.querySelectorAll('[data-delivery]').forEach(t => t.classList.remove('active'));
      tile.classList.add('active');
      state.delivery_method = tile.dataset.delivery;
      const shipPanel = document.getElementById('shippingFieldsContainer');
      if (shipPanel) {
        shipPanel.classList.toggle('d-none', state.delivery_method !== 'shipping');
      }
      updatePricingAndSummaryUI();
    });
  });

  // Live update review summary on shipping input changes
  ['shippingAddress1', 'shippingAddress2', 'shippingCity', 'shippingProvince', 'shippingPostal'].forEach(id => {
    const el = document.getElementById(id);
    if (el) {
      el.addEventListener('input', updatePricingAndSummaryUI);
      el.addEventListener('change', updatePricingAndSummaryUI);
    }
  });

  ['customerName', 'customerEmail', 'customerPhone', 'shippingCountry', 'shippingNotes'].forEach(id => {
    const el = document.getElementById(id);
    if (el) {
      el.addEventListener('input', resetCheckoutKey);
      el.addEventListener('change', resetCheckoutKey);
    }
  });

  // ─── 4-Step Studio Panel Controller ────────────────────────────────────
  let currentStep = 1;
  const visitedSteps = new Set([1]);
  const STEP_NEXT_LABELS = {
    1: 'Next: Materials',
    2: 'Next: Size',
    3: 'Continue to Order'
  };

  function setActiveStep(stepNum, shouldScroll = false) {
    const target = Math.min(4, Math.max(1, Number(stepNum) || 1));
    currentStep = target;
    visitedSteps.add(target);

    document.querySelectorAll('[data-step]').forEach(tab => {
      const s = Number(tab.dataset.step);
      const isActive = s === target;
      tab.classList.toggle('active', isActive);
      tab.classList.toggle('visited', visitedSteps.has(s) && !isActive);
      tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
    });

    document.querySelectorAll('[data-step-pane]').forEach(pane => {
      pane.classList.toggle('d-none', Number(pane.dataset.stepPane) !== target);
    });

    const navSteps = document.getElementById('studioNavSteps');
    const navCheckout = document.getElementById('studioNavCheckout');
    if (navSteps) navSteps.classList.toggle('d-none', target === 4);
    if (navCheckout) navCheckout.classList.toggle('d-none', target !== 4);

    const btnPrev = document.getElementById('btnStepPrev');
    if (btnPrev) btnPrev.classList.toggle('d-none', target <= 1);

    const btnNext = document.getElementById('btnStepNext');
    if (btnNext && STEP_NEXT_LABELS[target]) {
      btnNext.innerHTML = `<span>${STEP_NEXT_LABELS[target]}</span> <i class="bi bi-arrow-right"></i>`;
    }

    if (shouldScroll && window.innerWidth < 992) {
      document.querySelector('.design-panel-card')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }

  document.querySelectorAll('[data-step]').forEach(tab => {
    tab.addEventListener('click', () => setActiveStep(tab.dataset.step, true));
  });

  document.querySelectorAll('[data-goto-step]').forEach(btn => {
    btn.addEventListener('click', () => setActiveStep(btn.dataset.gotoStep, true));
  });

  document.getElementById('btnStepPrev')?.addEventListener('click', () => {
    setActiveStep(currentStep - 1, true);
  });

  document.getElementById('btnStepNext')?.addEventListener('click', () => {
    setActiveStep(currentStep + 1, true);
  });

  // ─── Payment Method Selector ──────────────────────────────────────────
  document.querySelectorAll('[data-payment-method]').forEach(tile => {
    tile.addEventListener('click', () => {
      document.querySelectorAll('[data-payment-method]').forEach(t => t.classList.remove('active'));
      tile.classList.add('active');
      state.payment_method = tile.dataset.paymentMethod;
      updatePricingAndSummaryUI();
    });
  });

  // ─── Checkout & Unified Order Submission ──────────────────────────────
  const apiEndpoint = "<?php echo BASE_URL; ?>/includes/plaque_api.php";
  const alertBox = document.getElementById('checkoutAlertBox');
  const confirmPanel = document.getElementById('orderConfirmationPanel');
  const btnSubmitOrder = document.getElementById('btnSubmitOrder');
  const spinnerSubmitOrder = document.getElementById('spinnerSubmitOrder');

  function showAlert(type, message) {
    alertBox.className = `alert alert-${type} py-2 small rounded-3 mb-3`;
    alertBox.innerHTML = message;
    alertBox.classList.remove('d-none');
  }

  function hideAlert() {
    alertBox.classList.add('d-none');
  }

  function capturePlaqueSnapshot() {
    try {
      if (renderer && scene && camera) {
        renderer.render(scene, camera);
        const w = renderer.domElement.width;
        const h = renderer.domElement.height;
        if (w > 0 && h > 0) {
          const exportCanvas = document.createElement('canvas');
          exportCanvas.width = Math.min(w, 900);
          exportCanvas.height = Math.round(exportCanvas.width * (h / w));
          const ctx = exportCanvas.getContext('2d');
          if (ctx) {
            const grad = ctx.createLinearGradient(0, 0, 0, exportCanvas.height);
            grad.addColorStop(0, '#151922');
            grad.addColorStop(0.5, '#0e1219');
            grad.addColorStop(1, '#090b10');
            ctx.fillStyle = grad;
            ctx.fillRect(0, 0, exportCanvas.width, exportCanvas.height);
            ctx.drawImage(renderer.domElement, 0, 0, exportCanvas.width, exportCanvas.height);
            return exportCanvas.toDataURL('image/jpeg', 0.82);
          }
        }
        return renderer.domElement.toDataURL('image/jpeg', 0.82);
      }
    } catch (e) {
      console.warn('Could not capture plaque 3D snapshot:', e);
    }
    return null;
  }

  function getCustomerPayload(paymentMethod) {
    const name = document.getElementById('customerName').value.trim();
    const email = document.getElementById('customerEmail').value.trim();
    const phone = document.getElementById('customerPhone').value.trim();
    const primary = document.getElementById('primaryTextInput').value.trim();
    const activeSizeSpec = CATALOG.sizes[state.size] || CATALOG.sizes.medium;
    const isVerticalSize = Boolean(activeSizeSpec.isVertical || state.size === 'vertical');
    const subtitle = isVerticalSize ? '' : document.getElementById('subtitleTextInput').value.trim();

    if (!primary) {
      setActiveStep(1, true);
      showAlert('warning', '<i class="bi bi-exclamation-triangle-fill me-1"></i> Please enter the primary 3D text for your plaque.');
      document.getElementById('primaryTextInput').focus();
      return null;
    }
    if (!name || !email) {
      setActiveStep(4, true);
      showAlert('warning', '<i class="bi bi-exclamation-triangle-fill me-1"></i> Please enter your Full Name and Email Address.');
      if (!name) document.getElementById('customerName').focus();
      else document.getElementById('customerEmail').focus();
      return null;
    }

    const deliveryMethod = state.delivery_method || 'pickup';
    const shipAddr1 = (document.getElementById('shippingAddress1')?.value || '').trim();
    const shipAddr2 = (document.getElementById('shippingAddress2')?.value || '').trim();
    const shipCity = (document.getElementById('shippingCity')?.value || '').trim();
    const shipProv = (document.getElementById('shippingProvince')?.value || '').trim();
    const shipPostal = (document.getElementById('shippingPostal')?.value || '').trim();
    const shipCountry = (document.getElementById('shippingCountry')?.value || 'Canada').trim();
    const shipNotes = (document.getElementById('shippingNotes')?.value || '').trim();

    if (deliveryMethod === 'shipping') {
      if (!shipAddr1 || !shipCity || !shipProv || !shipPostal) {
        setActiveStep(4, true);
        showAlert('warning', '<i class="bi bi-exclamation-triangle-fill me-1"></i> Please complete your shipping street address, city, province, and postal code.');
        if (!shipAddr1) document.getElementById('shippingAddress1')?.focus();
        else if (!shipCity) document.getElementById('shippingCity')?.focus();
        else if (!shipPostal) document.getElementById('shippingPostal')?.focus();
        return null;
      }
    }

    const snapshotImage = capturePlaqueSnapshot();

    return {
      action: 'create_order',
      customer_name: name,
      customer_email: email,
      customer_phone: phone,
      delivery_method: deliveryMethod,
      shipping_address_line1: shipAddr1,
      shipping_address_line2: shipAddr2,
      shipping_city: shipCity,
      shipping_province: shipProv,
      shipping_postal_code: shipPostal,
      shipping_country: shipCountry,
      shipping_instructions: shipNotes,
      preview_image: snapshotImage,
      plaque_type: state.plaque_type,
      construction_style: state.construction_style,
      font_style: state.font_style,
      primary_text: primary,
      subtitle_text: subtitle,
      acm_finish: state.acm_finish,
      acrylic_finish: state.acrylic_finish,
      sintra_color: state.sintra_color,
      standoff_finish: state.standoff_finish,
      size: state.size,
      payment_method: paymentMethod,
      idempotency_key: getOrCreateCheckoutKey()
    };
  }

  // Single Action Button: Trigger Payment with Card (Helcim) or Order with Interac
  btnSubmitOrder?.addEventListener('click', async () => {
    if (isSubmittingOrder) return;
    hideAlert();
    const method = state.payment_method || 'helcim';
    const payload = getCustomerPayload(method);
    if (!payload) return;

    isSubmittingOrder = true;
    btnSubmitOrder.disabled = true;
    spinnerSubmitOrder?.classList.remove('d-none');

    try {
      if (method === 'helcim') {
        if (activeHelcimOrder && activeHelcimOrder.idempotency_key === payload.idempotency_key && activeHelcimOrder.checkout_token) {
          spinnerSubmitOrder?.classList.add('d-none');
          window.dispatchEvent(new CustomEvent('open-helcim-checkout', {
            detail: { checkoutToken: activeHelcimOrder.checkout_token }
          }));
          return;
        }

        try {
          const response = await fetch(apiEndpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
          });
          const result = await response.json();

          spinnerSubmitOrder?.classList.add('d-none');

          if (!result.success || !result.data?.checkout_token) {
            btnSubmitOrder.disabled = false;
            showAlert('danger', '<i class="bi bi-x-circle-fill me-1"></i> ' + (result.message || 'Could not initialize Helcim card checkout. You can also select Interac e-Transfer.'));
            return;
          }

          const constructionFallback = (CATALOG.construction_styles[payload.construction_style] || {}).name || payload.construction_style;
          const fontFallback = (CATALOG.font_styles[payload.font_style] || {}).name || payload.font_style;
          const acmFallback = (CATALOG.acm_finishes[payload.acm_finish] || {}).name || payload.acm_finish;
          const acrylicFallback = (CATALOG.acrylic_finishes[payload.acrylic_finish] || {}).name || payload.acrylic_finish;
          const sintraFallback = (CATALOG.sintra_colors[payload.sintra_color] || {}).name || payload.sintra_color;
          const standoffFallback = (CATALOG.standoff_finishes[payload.standoff_finish] || {}).name || payload.standoff_finish;
          const sizeFallback = (CATALOG.sizes[payload.size] || {}).label || payload.size;
          const deliveryFallback = payload.delivery_method === 'shipping'
            ? `Direct Shipping to ${payload.shipping_address_line1}, ${payload.shipping_city}, ${payload.shipping_province} ${payload.shipping_postal_code}, Canada`
            : 'Pick up in Store — 180 Belvedere Ave, Charlottetown, PEI, C1A 2Z1, Canada';

          activeHelcimOrder = {
            ...payload,
            checkout_token: result.data.checkout_token,
            order_id: result.data.order_id,
            order_number: result.data.order_number,
            subtotal_cad: result.data.subtotal_cad,
            hst_cad: result.data.hst_cad,
            total_cad: result.data.total_cad,
            delivery_method: payload.delivery_method,
            delivery_summary: result.data.delivery_summary || deliveryFallback,
            construction_style_label: result.data.construction_style_label || constructionFallback,
            font_style_label: result.data.font_style_label || fontFallback,
            acm_finish_label: result.data.acm_finish_label || acmFallback,
            acrylic_finish_label: result.data.acrylic_finish_label || acrylicFallback,
            sintra_color_label: result.data.sintra_color_label || sintraFallback,
            standoff_finish_label: result.data.standoff_finish_label || standoffFallback,
            finish_label: result.data.finish_label || `${acmFallback} + ${acrylicFallback}`,
            size_label: result.data.size_label || sizeFallback
          };

          // Dispatch open-helcim-checkout custom event and invoke official HelcimPay.js iframe
          window.dispatchEvent(new CustomEvent('open-helcim-checkout', {
            detail: { checkoutToken: result.data.checkout_token }
          }));

        } catch (err) {
          spinnerSubmitOrder?.classList.add('d-none');
          btnSubmitOrder.disabled = false;
          showAlert('danger', '<i class="bi bi-x-circle-fill me-1"></i> Network error while initializing checkout. Please try again.');
        }
      } else {
        // Interac e-Transfer Submission
        try {
          const response = await fetch(apiEndpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
          });
          const result = await response.json();

          spinnerSubmitOrder?.classList.add('d-none');

          if (!result.success) {
            btnSubmitOrder.disabled = false;
            showAlert('danger', '<i class="bi bi-x-circle-fill me-1"></i> ' + (result.message || 'Unable to submit order.'));
            return;
          }

          currentCheckoutKey = null;

        const d = result.data;
        const constructionFallback = (CATALOG.construction_styles[payload.construction_style] || {}).name || payload.construction_style;
        const fontFallback = (CATALOG.font_styles[payload.font_style] || {}).name || payload.font_style;
        const acmFallback = (CATALOG.acm_finishes[payload.acm_finish] || {}).name || payload.acm_finish;
        const acrylicFallback = (CATALOG.acrylic_finishes[payload.acrylic_finish] || {}).name || payload.acrylic_finish;
        const sintraFallback = (CATALOG.sintra_colors[payload.sintra_color] || {}).name || payload.sintra_color;
        const standoffFallback = (CATALOG.standoff_finishes[payload.standoff_finish] || {}).name || payload.standoff_finish;
        const sizeFallback = (CATALOG.sizes[payload.size] || {}).label || payload.size;
        const deliveryFallback = payload.delivery_method === 'shipping'
          ? `Direct Shipping to ${payload.shipping_address_line1}, ${payload.shipping_city}, ${payload.shipping_province} ${payload.shipping_postal_code}, Canada`
          : 'Pick up in Store — 180 Belvedere Ave, Charlottetown, PEI, C1A 2Z1, Canada';

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
            <div class="mb-1"><span class="text-secondary">Construction:</span> <strong class="text-light">${d.construction_style_label || constructionFallback}</strong></div>
            <div class="mb-1"><span class="text-secondary">Font Style:</span> <strong class="text-light">${d.font_style_label || fontFallback}</strong></div>
            <div class="mb-1"><span class="text-secondary">Front Plate (ACM):</span> <strong class="text-light">${d.acm_finish_label || acmFallback}</strong></div>
            <div class="mb-1"><span class="text-secondary">3D Digits (Acrylic):</span> <strong class="text-light">${d.acrylic_finish_label || acrylicFallback}</strong></div>
            ${payload.construction_style === 'cnc_cut_acm' ? `<div class="mb-1"><span class="text-secondary">Sintra Backing (6mm):</span> <strong class="text-light">${d.sintra_color_label || sintraFallback}</strong></div>` : ''}
            <div class="mb-1"><span class="text-secondary">Standoffs:</span> <strong class="text-light">2 Lateral ${d.standoff_finish_label || standoffFallback}</strong></div>
            <div class="mb-1"><span class="text-secondary">Fulfillment:</span> <strong class="text-light">${d.delivery_summary || deliveryFallback}</strong></div>
            <div><span class="text-secondary">Size:</span> <strong class="text-light">${d.size_label || sizeFallback}</strong></div>
          </div>
          <div class="small text-secondary">
            <i class="bi bi-info-circle me-1"></i> Auto-deposit is enabled. Include your order number <strong>${d.order_number}</strong> in the transfer message.
          </div>
        `;
        confirmPanel.classList.remove('d-none');
        btnSubmitOrder.classList.add('d-none');
        confirmPanel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

      } catch (err) {
        spinnerSubmitOrder?.classList.add('d-none');
        btnSubmitOrder.disabled = false;
        showAlert('danger', '<i class="bi bi-x-circle-fill me-1"></i> Network error submitting your order. Please try again.');
      }
    }
    } finally {
      isSubmittingOrder = false;
    }
  });

  // Helcim Sandbox Test Modal for Developer / Testing Mode
  function showHelcimTestModal(token) {
    let modal = document.getElementById('helcimTestModal');
    if (!modal) {
      modal = document.createElement('div');
      modal.id = 'helcimTestModal';
      modal.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.78);backdrop-filter:blur(8px);z-index:99999;display:flex;align-items:center;justify-content:center;padding:16px;';
      document.body.appendChild(modal);
    }

    const totalFmt = activeHelcimOrder ? ('$' + Number(activeHelcimOrder.total_cad).toFixed(2) + ' CAD') : '$69.00 CAD';
    const orderNum = activeHelcimOrder ? activeHelcimOrder.order_number : 'PLP-TEST';

    modal.innerHTML = `
      <div style="background:#0f172a;border:1.5px solid rgba(59,130,246,0.4);border-radius:20px;max-width:440px;width:100%;padding:24px;color:#f8fafc;box-shadow:0 25px 50px rgba(0,0,0,0.85);font-family:sans-serif;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
          <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:36px;height:36px;border-radius:10px;background:#2563eb;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(37,99,235,0.4);">
              <i class="bi bi-credit-card-2-front-fill" style="color:#fff;font-size:1.1rem;"></i>
            </div>
            <div>
              <div style="font-weight:700;font-size:1rem;line-height:1.2;">HelcimPay.js Simulator</div>
              <div style="font-size:0.72rem;color:#38bdf8;">Sandbox Test Checkout Mode</div>
            </div>
          </div>
          <button type="button" id="btnCancelHelcimTest" style="background:none;border:none;color:#94a3b8;font-size:1.4rem;cursor:pointer;padding:0 4px;line-height:1;">&times;</button>
        </div>

        <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:14px;margin-bottom:16px;font-size:0.83rem;">
          <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
            <span style="color:#94a3b8;">Order Reference:</span>
            <span style="font-weight:600;font-family:monospace;color:#fff;">${orderNum}</span>
          </div>
          <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
            <span style="color:#94a3b8;">Customer:</span>
            <span style="color:#fff;">${activeHelcimOrder?.customer_name || 'Customer'}</span>
          </div>
          <div style="display:flex;justify-content:space-between;align-items:center;padding-top:6px;border-top:1px solid rgba(255,255,255,0.08);">
            <span style="color:#94a3b8;">Total to Authorize:</span>
            <span style="font-weight:700;color:#38bdf8;font-size:1.1rem;">${totalFmt}</span>
          </div>
        </div>

        <div style="margin-bottom:12px;">
          <label style="display:block;font-size:0.75rem;color:#94a3b8;margin-bottom:5px;">Simulated Card Number</label>
          <input type="text" value="4500 •••• •••• 0001 (Visa Test)" readonly style="width:100%;padding:10px 13px;border-radius:10px;background:rgba(15,23,42,0.9);border:1px solid rgba(255,255,255,0.18);color:#fff;font-size:0.88rem;box-sizing:border-box;">
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:18px;">
          <div>
            <label style="display:block;font-size:0.75rem;color:#94a3b8;margin-bottom:5px;">Expiry</label>
            <input type="text" value="12/28" readonly style="width:100%;padding:10px 13px;border-radius:10px;background:rgba(15,23,42,0.9);border:1px solid rgba(255,255,255,0.18);color:#fff;font-size:0.88rem;box-sizing:border-box;">
          </div>
          <div>
            <label style="display:block;font-size:0.75rem;color:#94a3b8;margin-bottom:5px;">CVV</label>
            <input type="text" value="123" readonly style="width:100%;padding:10px 13px;border-radius:10px;background:rgba(15,23,42,0.9);border:1px solid rgba(255,255,255,0.18);color:#fff;font-size:0.88rem;box-sizing:border-box;">
          </div>
        </div>

        <div style="display:grid;gap:8px;">
          <button type="button" id="btnConfirmHelcimTest" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);border:none;color:#fff;padding:13px;border-radius:12px;font-weight:700;font-size:0.95rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 8px 20px rgba(37,99,235,0.5);">
            <i class="bi bi-shield-check"></i> Authorize &amp; Pay ${totalFmt}
          </button>
          <button type="button" id="btnCancelHelcimTest2" style="background:transparent;border:1px solid rgba(255,255,255,0.15);color:#94a3b8;padding:10px;border-radius:12px;font-size:0.85rem;cursor:pointer;">
            Cancel
          </button>
        </div>

        <div style="margin-top:14px;text-align:center;font-size:0.7rem;color:#64748b;">
          <i class="bi bi-info-circle me-1"></i> Simulated checkout for test/review. Order notification will be dispatched to <strong>test@poutechnologies.com</strong>.
        </div>
      </div>
    `;

    modal.style.display = 'flex';

    const closeModal = () => {
      modal.style.display = 'none';
      if (btnSubmitOrder) btnSubmitOrder.disabled = false;
      if (spinnerSubmitOrder) spinnerSubmitOrder.classList.add('d-none');
    };

    document.getElementById('btnCancelHelcimTest')?.addEventListener('click', closeModal);
    document.getElementById('btnCancelHelcimTest2')?.addEventListener('click', closeModal);

    document.getElementById('btnConfirmHelcimTest')?.addEventListener('click', () => {
      modal.style.display = 'none';
      const fakeTxId = 'TX-TEST-' + Math.floor(100000 + Math.random() * 900000);
      window.postMessage({
        eventName: 'helcimPayTransactionSuccess',
        eventStatus: 'SUCCESS',
        data: {
          status: 'APPROVED',
          transactionId: fakeTxId,
          amount: activeHelcimOrder?.total_cad || 69.00,
          currency: 'CAD',
          cardBatchId: 'TEST-BATCH-001'
        }
      }, '*');
    });
  }

  // Listen for open-helcim-checkout to launch HelcimPay.js Modal or Sandbox Simulator
  window.addEventListener('open-helcim-checkout', (e) => {
    const token = e.detail?.checkoutToken;
    if (!token) return;

    if (token.startsWith('test_helcim_')) {
      showHelcimTestModal(token);
      return;
    }

    if (typeof appendHelcimPayIframe === 'function') {
      appendHelcimPayIframe(token);
    } else {
      if (btnSubmitOrder) btnSubmitOrder.disabled = false;
      showAlert('warning', 'HelcimPay.js script could not be loaded by your browser. Please disable any ad-blocker or select Interac e-Transfer.');
    }
  });

  // Listen for HelcimPay.js postMessage completion events
  window.addEventListener('message', async (event) => {
    if (!event.data || !activeHelcimOrder) return;

    const msg = event.data;
    const eventName = String(msg.eventName || msg.event || '');
    const eventStatus = String(msg.eventStatus || msg.status || msg.data?.status || '').toUpperCase();

    const isAborted = eventStatus === 'ABORTED' || eventStatus === 'CANCELLED' || eventStatus === 'HIDE'
      || eventName.toLowerCase().includes('abort') || eventName.toLowerCase().includes('hide');
    if (isAborted && !activeHelcimOrder._confirming) {
      if (btnSubmitOrder) btnSubmitOrder.disabled = false;
      if (spinnerSubmitOrder) spinnerSubmitOrder.classList.add('d-none');
      return;
    }

    const isSuccess = eventName.includes('helcimPayJsIdentifier') && eventStatus === 'SUCCESS'
      || eventName === 'helcimPayTransactionSuccess'
      || eventStatus === 'APPROVED';

    if (isSuccess && !activeHelcimOrder._confirming) {
      activeHelcimOrder._confirming = true;
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
            preview_image: activeHelcimOrder?.preview_image || capturePlaqueSnapshot(),
            transaction_data: typeof msg === 'object' ? msg : { raw: msg }
          })
        });
        const confirmData = await confirmRes.json();

        if (!confirmRes.ok || !confirmData.success) {
          activeHelcimOrder._confirming = false;
          if (btnSubmitOrder) btnSubmitOrder.disabled = false;
          showAlert('danger', '<i class="bi bi-x-circle-fill me-1"></i> ' + (confirmData.message || 'Could not verify Helcim payment. Please contact us with reference ' + activeHelcimOrder.order_number + '.'));
          return;
        }

        hideAlert();
        const txId = confirmData.data?.transaction_id || 'CONFIRMED';
        const constructionLabel = confirmData.data?.construction_style_label || activeHelcimOrder.construction_style_label;
        const fontLabel = confirmData.data?.font_style_label || activeHelcimOrder.font_style_label;
        const acmLabel = confirmData.data?.acm_finish_label || activeHelcimOrder.acm_finish_label;
        const acrylicLabel = confirmData.data?.acrylic_finish_label || activeHelcimOrder.acrylic_finish_label;
        const sintraLabel = confirmData.data?.sintra_color_label || activeHelcimOrder.sintra_color_label;
        const standoffLabel = confirmData.data?.standoff_finish_label || activeHelcimOrder.standoff_finish_label;

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
            <div><strong>Construction:</strong> ${constructionLabel}</div>
            <div><strong>Font Style:</strong> ${fontLabel}</div>
            <div><strong>Front Plate (ACM):</strong> ${acmLabel}</div>
            <div><strong>3D Digits (Acrylic):</strong> ${acrylicLabel}</div>
            ${activeHelcimOrder.construction_style === 'cnc_cut_acm' ? `<div><strong>Sintra Backing (6mm):</strong> ${sintraLabel}</div>` : ''}
            <div><strong>Standoffs:</strong> 2 Lateral ${standoffLabel}</div>
            <div><strong>Fulfillment:</strong> ${activeHelcimOrder.delivery_summary}</div>
            <div><strong>Size:</strong> ${activeHelcimOrder.size_label}</div>
            <div><strong>Total Paid:</strong> $${Number(activeHelcimOrder.total_cad).toFixed(2)} CAD (incl. 15% HST)</div>
          </div>
          <div class="small text-secondary">
            A confirmation copy has been sent to our production team.
          </div>
        `;
        confirmPanel.classList.remove('d-none');
        btnSubmitOrder?.classList.add('d-none');
        activeHelcimOrder = null;
        currentCheckoutKey = null;
      } catch (err) {
        if (activeHelcimOrder) {
          activeHelcimOrder._confirming = false;
        }
        if (btnSubmitOrder) btnSubmitOrder.disabled = false;
        showAlert('warning', 'Payment completed, please save your order reference: <strong>' + (activeHelcimOrder?.order_number || '') + '</strong>.');
      }
    }
  });
</script>

<?php include '../includes/footer.php'; ?>
