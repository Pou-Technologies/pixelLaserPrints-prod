<?php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/PortalApiClient.php';

$pageTitle = 'Store | ' . COMPANY_NAME;
$pageDescription = 'Minimalist curated collection of precision laser engraved signage, gifts, and architectural pieces crafted in Charlottetown, PEI.';

$ttl = isset($_GET['refresh']) ? 0 : 90;
$storeRes = PortalApiClient::getStoreProducts($ttl);

$storePayload = (!empty($storeRes['success']) && !empty($storeRes['data']['data']))
    ? $storeRes['data']['data']
    : ['store' => ['name' => COMPANY_NAME], 'carousel' => [], 'categories' => [], 'products' => []];

$carouselItems = is_array($storePayload['carousel'] ?? null) ? $storePayload['carousel'] : [];
$categories = is_array($storePayload['categories'] ?? null) ? $storePayload['categories'] : [];
$products = is_array($storePayload['products'] ?? null) ? $storePayload['products'] : [];
$initialQuery = trim((string) ($_GET['q'] ?? ''));

include __DIR__ . '/../includes/header.php';
?>

<style>
  :root {
    --plp-bg: #fafafa;
    --plp-surface: #ffffff;
    --plp-ink: #111111;
    --plp-muted: #6e6e73;
    --plp-line: #e6e6e3;
    --plp-gold: #D4AF37;
    --plp-dark: #0c0c0e;
  }

  .plp-store-hero {
    background: radial-gradient(circle at 80% 20%, rgba(212, 175, 55, 0.12) 0%, rgba(12, 12, 14, 0) 50%), var(--plp-dark);
    color: #fff;
    padding: 122px 0 46px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  }

  .plp-eyebrow {
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--plp-gold);
  }

  .plp-store-title {
    font-weight: 200;
    letter-spacing: -0.02em;
    font-size: clamp(2rem, 4vw, 3.1rem);
    color: #fff;
  }

  .plp-store-main {
    background: var(--plp-bg);
    color: var(--plp-ink);
  }

  /* Vertical New Arrivals Carousel */
  .plp-carousel-section {
    padding: 3.5rem 0 2.5rem;
    border-bottom: 1px solid var(--plp-line);
    background: var(--plp-surface);
  }

  .plp-carousel-track {
    display: flex;
    gap: 1.25rem;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    padding: 0.25rem 0 1rem;
    scrollbar-width: none;
    cursor: grab;
  }

  .plp-carousel-track::-webkit-scrollbar {
    display: none;
  }

  .plp-carousel-track.is-dragging {
    cursor: grabbing;
    scroll-snap-type: none;
  }

  .plp-vertical-card {
    flex: 0 0 278px;
    aspect-ratio: 3 / 4;
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    background: #141416;
    scroll-snap-align: start;
    border: 1px solid var(--plp-line);
    transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.35s ease;
    cursor: pointer;
    user-select: none;
  }

  @media (max-width: 575.98px) {
    .plp-vertical-card {
      flex: 0 0 76vw;
    }
  }

  .plp-vertical-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 36px rgba(0, 0, 0, 0.12);
  }

  .plp-vertical-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    pointer-events: none;
  }

  .plp-vertical-card:hover img {
    transform: scale(1.04);
  }

  .plp-vertical-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(10, 10, 12, 0.88) 0%, rgba(10, 10, 12, 0.2) 45%, rgba(10, 10, 12, 0.08) 100%);
    pointer-events: none;
  }

  .plp-vertical-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 0.65rem;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    background: rgba(255, 255, 255, 0.92);
    color: var(--plp-ink);
    backdrop-filter: blur(6px);
  }

  .plp-vertical-caption {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 1.25rem;
    color: #fff;
  }

  .plp-nav-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid var(--plp-line);
    background: var(--plp-surface);
    color: var(--plp-ink);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
  }

  .plp-nav-circle:hover {
    background: var(--plp-ink);
    color: #fff;
    border-color: var(--plp-ink);
  }

  /* Minimalist Filter Bar & Product Grid */
  .plp-grid-section {
    padding: 3rem 0 4.5rem;
  }

  .plp-pill-btn {
    border: 1px solid var(--plp-line);
    background: var(--plp-surface);
    color: var(--plp-ink);
    padding: 0.45rem 1rem;
    border-radius: 999px;
    font-size: 0.82rem;
    font-weight: 500;
    letter-spacing: 0.01em;
    transition: all 0.2s ease;
    white-space: nowrap;
  }

  .plp-pill-btn:hover {
    border-color: var(--plp-ink);
  }

  .plp-pill-btn.active {
    background: var(--plp-ink);
    color: #fff;
    border-color: var(--plp-ink);
  }

  .plp-product-card {
    background: transparent;
    border: none;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .plp-product-frame {
    position: relative;
    aspect-ratio: 4 / 5;
    border-radius: 12px;
    overflow: hidden;
    background: #efefe9;
    border: 1px solid var(--plp-line);
    cursor: pointer;
  }

  .plp-product-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.55s cubic-bezier(0.22, 1, 0.36, 1);
  }

  .plp-product-card:hover .plp-product-frame img {
    transform: scale(1.04);
  }

  .plp-quick-add {
    position: absolute;
    left: 12px;
    right: 12px;
    bottom: 12px;
    background: rgba(17, 17, 17, 0.92);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 0.58rem 0.85rem;
    font-size: 0.78rem;
    font-weight: 500;
    letter-spacing: 0.04em;
    opacity: 0;
    transform: translateY(6px);
    transition: all 0.22s ease;
    backdrop-filter: blur(6px);
  }

  .plp-product-card:hover .plp-quick-add,
  .plp-product-frame:focus-within .plp-quick-add {
    opacity: 1;
    transform: translateY(0);
  }

  @media (hover: none) {
    .plp-quick-add {
      opacity: 1;
      transform: none;
    }
  }

  .plp-product-title {
    font-size: 0.96rem;
    font-weight: 500;
    color: var(--plp-ink);
    margin: 0;
    line-height: 1.35;
  }

  .plp-product-category {
    font-size: 0.72rem;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    color: var(--plp-muted);
  }

  .plp-custom-banner {
    background: var(--plp-dark);
    color: #fff;
    border-radius: 16px;
    padding: 2.25rem 2.5rem;
    border: 1px solid rgba(255, 255, 255, 0.08);
  }

  .plp-thumb-btn {
    width: 64px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid transparent;
    padding: 0;
    background: #f2f2ef;
    cursor: pointer;
    flex-shrink: 0;
  }

  .plp-thumb-btn.active {
    border-color: var(--plp-ink);
  }

  .plp-thumb-btn img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* Notice Bar / Coming Soon Banner */
  .plp-teaser-bar {
    background: linear-gradient(90deg, rgba(212, 175, 55, 0.16) 0%, rgba(212, 175, 55, 0.05) 50%, rgba(212, 175, 55, 0.16) 100%), #121215;
    border-bottom: 1px solid rgba(212, 175, 55, 0.3);
    color: #fff;
    padding: 0.85rem 1rem;
    position: relative;
    z-index: 2;
  }

  .plp-teaser-badge {
    background: var(--plp-gold);
    color: #111;
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    padding: 0.25rem 0.65rem;
    border-radius: 999px;
  }
</style>

<!-- Minimalist Store Top Strip (ensures crisp white header nav legibility) -->
<section class="plp-store-hero">
  <div class="container">
    <div class="row align-items-end g-3">
      <div class="col-lg-8">
        <div class="plp-eyebrow mb-2">Studio Storefront &mdash; Charlottetown, PEI</div>
        <h1 class="plp-store-title mb-2">Objects Crafted with Laser Precision</h1>
        <p class="text-white-50 mb-0" style="max-width: 560px; font-weight: 300;">
          A minimalist selection of ready-to-order engravings, signage, and limited studio releases.
        </p>
      </div>
      <div class="col-lg-4 d-flex justify-content-lg-end align-items-center gap-2">
        <button type="button" class="btn btn-outline-light btn-sm rounded-pill px-3 py-2" data-bs-toggle="offcanvas" data-bs-target="#storeBagOffcanvas">
          <i class="bi bi-bag me-1"></i> Bag (<span id="heroBagCount">0</span>)
        </button>
        <button type="button" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold opacity-75" style="background: var(--plp-gold); color: #111; cursor: not-allowed;" title="3D Configurator is temporarily paused for testing" disabled>
          3D House Numbers <span class="badge bg-dark text-warning ms-1" style="font-size: 0.62rem;">Testing</span>
        </button>
      </div>
    </div>
  </div>
</section>

<!-- Teaser Announcement Banner -->
<aside class="plp-teaser-bar text-center" aria-label="Announcement">
  <div class="container d-flex flex-wrap align-items-center justify-content-center gap-2">
    <span class="plp-teaser-badge">
      <i class="bi bi-stars me-1"></i> Coming Soon
    </span>
    <span class="small fw-light" style="letter-spacing: 0.02em;">
      We are preparing something big for you &mdash; <strong>stay tuned!</strong> We are currently conducting tests and fine-tuning our online store experience.
    </span>
  </div>
</aside>

<main class="plp-store-main">
  <!-- Section 1: Vertical New Arrivals Carousel -->
  <?php if (!empty($carouselItems)): ?>
  <section class="plp-carousel-section" aria-label="New Arrivals Vertical Carousel">
    <div class="container">
      <div class="d-flex justify-content-between align-items-end mb-4 gap-3">
        <div>
          <span class="plp-eyebrow d-block mb-1" style="color: #9b7d1b;">Just Landed</span>
          <h2 class="h3 fw-light mb-0" style="color: var(--plp-ink); letter-spacing: -0.01em;">New Arrivals</h2>
        </div>
        <div class="d-flex align-items-center gap-2">
          <button type="button" class="plp-nav-circle" id="carouselPrev" aria-label="Previous slide">
            <i class="bi bi-arrow-left"></i>
          </button>
          <button type="button" class="plp-nav-circle" id="carouselNext" aria-label="Next slide">
            <i class="bi bi-arrow-right"></i>
          </button>
        </div>
      </div>

      <div class="plp-carousel-track" id="verticalCarouselTrack">
        <?php foreach ($carouselItems as $idx => $slide):
          $imgUrl = $slide['image_url'] ?? '';
          $productId = !empty($slide['product_id']) ? (int) $slide['product_id'] : 0;
          $title = (string) ($slide['title'] ?? 'New Release');
          $badge = (string) ($slide['badge'] ?? 'NEW ARRIVAL');
          $subtitle = (string) ($slide['subtitle'] ?? '');
          $price = isset($slide['price']) && $slide['price'] !== null ? (float) $slide['price'] : null;
        ?>
        <article class="plp-vertical-card"
          data-product-id="<?php echo $productId; ?>"
          data-slide-title="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>"
          data-slide-subtitle="<?php echo htmlspecialchars($subtitle, ENT_QUOTES, 'UTF-8'); ?>"
          data-slide-badge="<?php echo htmlspecialchars($badge, ENT_QUOTES, 'UTF-8'); ?>"
          data-slide-image="<?php echo htmlspecialchars($imgUrl, ENT_QUOTES, 'UTF-8'); ?>"
          data-slide-price="<?php echo $price !== null ? number_format($price, 2, '.', '') : ''; ?>">
          <?php if ($imgUrl !== ''): ?>
            <img src="<?php echo htmlspecialchars($imgUrl, ENT_QUOTES, 'UTF-8'); ?>"
                 alt="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>"
                 loading="<?php echo $idx < 4 ? 'eager' : 'lazy'; ?>">
          <?php endif; ?>
          <div class="plp-vertical-overlay"></div>
          <span class="plp-vertical-badge"><?php echo htmlspecialchars($badge, ENT_QUOTES, 'UTF-8'); ?></span>
          <div class="plp-vertical-caption">
            <?php if ($subtitle !== ''): ?>
              <div class="small text-white-50 text-truncate mb-1" style="font-size: 0.76rem;"><?php echo htmlspecialchars($subtitle, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <h3 class="h6 fw-semibold mb-1 text-truncate" style="color: #fff; font-family: var(--font-family);"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h3>
            <div class="d-flex justify-content-between align-items-center mt-2">
              <span class="small fw-semibold" style="color: var(--plp-gold);">
                <?php echo $price !== null ? '$' . number_format($price, 2) . ' CAD' : 'View Release'; ?>
              </span>
              <span class="small text-white-50"><i class="bi bi-arrow-up-right"></i></span>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- Section 2: Minimalist Product Grid -->
  <section class="plp-grid-section">
    <div class="container">
      <!-- Filter Toolbar -->
      <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 pb-4 mb-4" style="border-bottom: 1px solid var(--plp-line);">
        <div class="d-flex flex-wrap align-items-center gap-2" id="categoryFilters">
          <button type="button" class="plp-pill-btn active" data-category="all">
            All (<?php echo count($products); ?>)
          </button>
          <?php foreach ($categories as $cat): ?>
            <button type="button" class="plp-pill-btn" data-category="<?php echo htmlspecialchars((string) $cat['name'], ENT_QUOTES, 'UTF-8'); ?>">
              <?php echo htmlspecialchars((string) $cat['name'], ENT_QUOTES, 'UTF-8'); ?> (<?php echo (int) $cat['count']; ?>)
            </button>
          <?php endforeach; ?>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
          <div class="input-group input-group-sm" style="width: 220px;">
            <span class="input-group-text bg-white border-end-0" style="border-color: var(--plp-line);">
              <i class="bi bi-search text-muted"></i>
            </span>
            <input type="search" id="storeSearchInput" class="form-control border-start-0 bg-white"
              style="border-color: var(--plp-line); box-shadow: none;"
              placeholder="Filter items..."
              value="<?php echo htmlspecialchars($initialQuery, ENT_QUOTES, 'UTF-8'); ?>">
          </div>

          <select id="storeSortSelect" class="form-select form-select-sm bg-white" style="width: auto; border-color: var(--plp-line); box-shadow: none;">
            <option value="newest">Newest</option>
            <option value="price-asc">Price: Low to High</option>
            <option value="price-desc">Price: High to Low</option>
            <option value="name">Name: A-Z</option>
          </select>
        </div>
      </div>

      <!-- Product Grid Container -->
      <div id="storeProductGrid" class="row g-4"></div>

      <!-- Empty State -->
      <div id="storeEmptyState" class="text-center py-5 d-none">
        <i class="bi bi-box2 text-muted" style="font-size: 2.5rem;"></i>
        <h3 class="h5 fw-normal mt-3 mb-1">No products found</h3>
        <p class="text-muted small mb-3">Try clearing your search filter or check back soon for new studio releases.</p>
        <button type="button" id="resetFiltersBtn" class="btn btn-outline-dark btn-sm rounded-pill px-4">Show All Products</button>
      </div>

      <!-- Architectural 3D Plaques Minimal Promo -->
      <div class="plp-custom-banner mt-5">
        <div class="row align-items-center g-3">
          <div class="col-lg-8">
            <span class="plp-eyebrow d-block mb-1">Interactive Studio Tool</span>
            <h3 class="h4 fw-light text-white mb-1">Need Custom 3D House Numbers?</h3>
            <p class="text-white-50 small mb-0">
              Preview CNC aluminum plates, raised 3D acrylic digits, and standoff hardware in real-time 3D before ordering.
            </p>
          </div>
          <div class="col-lg-4 text-lg-end">
            <button type="button" class="btn rounded-pill px-4 py-2 fw-semibold opacity-75" style="background: var(--plp-gold); color: #111; cursor: not-allowed;" title="3D Configurator is currently undergoing testing and updates" disabled>
              Open 3D Configurator <span class="badge bg-dark text-warning ms-1" style="font-size: 0.65rem;">Testing</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Product Detail Modal (supports multi-photo gallery & vertical slide preview) -->
<div class="modal fade" id="productDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
      <div class="modal-body p-0">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3 bg-white p-2 rounded-circle shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="row g-0">
          <div class="col-md-6 bg-light d-flex flex-column p-3">
            <div class="rounded-3 overflow-hidden bg-white border" style="aspect-ratio: 4 / 5;">
              <img id="modalMainImage" src="" alt="" class="w-100 h-100" style="object-fit: cover;">
            </div>
            <div id="modalThumbnails" class="d-flex gap-2 overflow-x-auto pt-2"></div>
          </div>
          <div class="col-md-6 p-4 d-flex flex-column justify-content-between">
            <div>
              <span id="modalCategory" class="plp-product-category d-block mb-1"></span>
              <h3 id="modalTitle" class="h4 fw-normal mb-2" style="color: var(--plp-ink);"></h3>
              <div id="modalPriceWrap" class="mb-3"></div>
              <div id="modalStockWrap" class="mb-3"></div>
              <p id="modalDescription" class="text-muted small mb-3" style="line-height: 1.65; white-space: pre-line;"></p>
              <div id="modalSku" class="text-muted" style="font-size: 0.74rem;"></div>
            </div>

            <div id="modalActionWrap" class="pt-4 border-top mt-4">
              <div class="d-flex align-items-center gap-2">
                <div class="input-group" style="width: 115px;">
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="modalQtyMinus">-</button>
                  <input type="number" class="form-control form-control-sm text-center" id="modalQtyInput" value="1" min="1" max="50" readonly>
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="modalQtyPlus">+</button>
                </div>
                <button type="button" id="modalAddToBagBtn" class="btn btn-dark flex-grow-1 py-2 rounded-3 fw-medium">
                  <i class="bi bi-bag-plus me-1"></i> Add to Bag
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Minimalist Shopping Bag & Checkout Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="storeBagOffcanvas" aria-labelledby="storeBagLabel" style="width: min(440px, 100vw);">
  <div class="offcanvas-header border-bottom">
    <div>
      <span class="plp-eyebrow d-block" style="font-size: 0.65rem; color: #9b7d1b;">Pixel Laser Prints</span>
      <h5 class="offcanvas-title fw-normal mb-0" id="storeBagLabel">Your Shopping Bag</h5>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body d-flex flex-column p-4">
    <!-- View 1: Bag Items -->
    <div id="bagItemsView" class="flex-grow-1 d-flex flex-column">
      <div id="bagEmptyMsg" class="text-center my-auto py-5 text-muted">
        <i class="bi bi-bag fs-1 opacity-50"></i>
        <p class="mt-2 mb-0 small">Your bag is currently empty.</p>
      </div>

      <div id="bagItemsList" class="flex-grow-1 overflow-y-auto pe-1"></div>

      <div id="bagSummaryWrap" class="border-top pt-3 mt-3 d-none">
        <div class="d-flex justify-content-between small text-muted mb-1">
          <span>Subtotal</span>
          <span id="bagSubtotal">$0.00 CAD</span>
        </div>
        <div class="d-flex justify-content-between small text-muted mb-2">
          <span>PEI HST (15%)</span>
          <span id="bagTax">$0.00 CAD</span>
        </div>
        <div class="d-flex justify-content-between fw-semibold fs-6 mb-3">
          <span>Estimated Total</span>
          <span id="bagTotal">$0.00 CAD</span>
        </div>
        <button type="button" id="proceedCheckoutBtn" class="btn btn-dark w-100 py-2 rounded-3 fw-medium">
          Proceed to Checkout <i class="bi bi-arrow-right ms-1"></i>
        </button>
      </div>
    </div>

    <!-- View 2: Checkout Form -->
    <form id="storeCheckoutForm" class="d-none flex-grow-1 flex-column">
      <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
        <button type="button" id="backToBagBtn" class="btn btn-link btn-sm text-dark text-decoration-none p-0">
          <i class="bi bi-arrow-left me-1"></i> Back to Bag
        </button>
        <span class="fw-semibold small" id="checkoutHeaderTotal">$0.00 CAD</span>
      </div>

      <div class="flex-grow-1 overflow-y-auto pe-1">
        <div id="checkoutError" class="alert alert-danger py-2 small d-none"></div>

        <div class="mb-2">
          <label class="form-label small fw-medium mb-1">Full Name <span class="text-danger">*</span></label>
          <input type="text" name="customer_name" class="form-control form-control-sm" required>
        </div>
        <div class="row g-2 mb-2">
          <div class="col-7">
            <label class="form-label small fw-medium mb-1">Email <span class="text-danger">*</span></label>
            <input type="email" name="customer_email" class="form-control form-control-sm" required>
          </div>
          <div class="col-5">
            <label class="form-label small fw-medium mb-1">Phone</label>
            <input type="tel" name="customer_phone" class="form-control form-control-sm">
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label small fw-medium mb-1">Fulfillment</label>
          <select name="delivery_type" id="checkoutDeliveryType" class="form-select form-select-sm">
            <option value="pickup">Local Pickup &mdash; 180 Belvedere Ave, Charlottetown (Free)</option>
            <option value="shipping">Shipping Address</option>
          </select>
        </div>

        <div id="shippingFieldsWrap" class="p-2 bg-light rounded-3 border mb-2 d-none">
          <input type="text" name="shipping_address" class="form-control form-control-sm mb-2" placeholder="Street address">
          <div class="row g-2">
            <div class="col-7">
              <input type="text" name="shipping_city" class="form-control form-control-sm" placeholder="City (e.g. Charlottetown)">
            </div>
            <div class="col-5">
              <input type="text" name="shipping_postal_code" class="form-control form-control-sm" placeholder="Postal code">
            </div>
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label small fw-medium mb-1">Payment Preference</label>
          <select name="payment_method" class="form-select form-select-sm">
            <option value="interac">Interac e-Transfer (<?php echo COMPANY_EMAIL; ?>)</option>
            <option value="pay_on_pickup">Pay on Pickup / Studio Terminal</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-medium mb-1">Order Notes</label>
          <textarea name="notes" rows="2" class="form-control form-control-sm" placeholder="Engraving text, color preference, or pickup timing..."></textarea>
        </div>
      </div>

      <button type="submit" id="submitOrderBtn" class="btn btn-dark w-100 py-2 rounded-3 fw-medium mt-2">
        Place Order
      </button>
    </form>

    <!-- View 3: Order Confirmed -->
    <div id="checkoutSuccessView" class="d-none text-center my-auto py-4">
      <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
        <i class="bi bi-check-lg fs-3"></i>
      </div>
      <h5 class="fw-semibold mb-1">Order Received</h5>
      <p class="text-muted small mb-3">Thank you! Your order has been sent to our Charlottetown studio.</p>
      <div class="p-3 bg-light rounded-3 border text-start small mb-3">
        <div class="d-flex justify-content-between mb-1">
          <span class="text-muted">Reference</span>
          <strong id="successTracking">-</strong>
        </div>
        <div class="d-flex justify-content-between mb-1">
          <span class="text-muted">Total (incl. HST)</span>
          <strong id="successTotal">$0.00 CAD</strong>
        </div>
        <div id="successInteracNote" class="text-muted mt-2 pt-2 border-top" style="font-size: 0.78rem;"></div>
      </div>
      <button type="button" id="continueShoppingBtn" class="btn btn-outline-dark btn-sm rounded-pill px-4" data-bs-dismiss="offcanvas">
        Continue Shopping
      </button>
    </div>
  </div>
</div>

<script>
  (function () {
    const PRODUCTS = <?php echo json_encode($products, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    const STORE_API_URL = <?php echo json_encode((BASE_URL ?: '') . '/includes/store_api.php', JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    const CART_STORAGE_KEY = 'plp_store_cart';

    const state = {
      category: 'all',
      search: <?php echo json_encode($initialQuery, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>,
      sort: 'newest',
      cart: [],
      activeProduct: null,
    };

    function escapeHtml(str) {
      return String(str ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
    }

    function money(val) {
      const num = Number(val) || 0;
      return '$' + num.toFixed(2) + ' CAD';
    }

    function loadCart() {
      try {
        const raw = localStorage.getItem(CART_STORAGE_KEY);
        const parsed = raw ? JSON.parse(raw) : [];
        state.cart = Array.isArray(parsed) ? parsed : [];
      } catch (e) {
        state.cart = [];
      }
      syncCartCounters();
    }

    function saveCart() {
      try {
        localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(state.cart));
      } catch (e) {
        // Ignore storage quota issues
      }
      syncCartCounters();
      renderBag();
    }

    function syncCartCounters() {
      const totalQty = state.cart.reduce((sum, item) => sum + (Number(item.quantity) || 0), 0);
      const heroCount = document.getElementById('heroBagCount');
      if (heroCount) {
        heroCount.textContent = String(totalQty);
      }
      if (typeof window.updateCartCount === 'function') {
        window.updateCartCount(totalQty);
      } else {
        const badge = document.getElementById('cart-count');
        if (badge) {
          badge.textContent = String(totalQty);
          badge.style.display = totalQty > 0 ? 'flex' : 'none';
        }
        try {
          localStorage.setItem('cart_count', String(totalQty));
        } catch (e) {}
      }
    }

    function addToCart(productId, qty) {
      const product = PRODUCTS.find((p) => Number(p.id) === Number(productId));
      if (!product || !product.in_stock) {
        return;
      }

      const amount = Math.max(1, Number(qty) || 1);
      const existing = state.cart.find((item) => Number(item.product_id) === Number(product.id));
      if (existing) {
        existing.quantity = Math.min(99, existing.quantity + amount);
      } else {
        state.cart.push({
          product_id: product.id,
          name: product.name,
          price: Number(product.display_price ?? product.price) || 0,
          image_url: product.image_url || '',
          category_name: product.category_name || '',
          quantity: amount,
        });
      }

      saveCart();
      openBagOffcanvas();
    }

    function openBagOffcanvas() {
      const el = document.getElementById('storeBagOffcanvas');
      if (!el || typeof bootstrap === 'undefined') return;
      showBagView('items');
      bootstrap.Offcanvas.getOrCreateInstance(el).show();
    }

    function showBagView(viewName) {
      const itemsView = document.getElementById('bagItemsView');
      const formView = document.getElementById('storeCheckoutForm');
      const successView = document.getElementById('checkoutSuccessView');
      itemsView.classList.toggle('d-none', viewName !== 'items');
      itemsView.classList.toggle('d-flex', viewName === 'items');
      formView.classList.toggle('d-none', viewName !== 'checkout');
      formView.classList.toggle('d-flex', viewName === 'checkout');
      successView.classList.toggle('d-none', viewName !== 'success');
    }

    function renderProducts() {
      const grid = document.getElementById('storeProductGrid');
      const empty = document.getElementById('storeEmptyState');
      if (!grid || !empty) return;

      const needle = state.search.trim().toLowerCase();
      let list = PRODUCTS.filter((p) => {
        if (state.category !== 'all' && p.category_name !== state.category) {
          return false;
        }
        if (needle !== '') {
          const hay = ((p.name || '') + ' ' + (p.category_name || '') + ' ' + (p.description || '')).toLowerCase();
          if (!hay.includes(needle)) return false;
        }
        return true;
      });

      if (state.sort === 'price-asc') {
        list.sort((a, b) => (a.display_price || 0) - (b.display_price || 0));
      } else if (state.sort === 'price-desc') {
        list.sort((a, b) => (b.display_price || 0) - (a.display_price || 0));
      } else if (state.sort === 'name') {
        list.sort((a, b) => String(a.name || '').localeCompare(String(b.name || '')));
      }

      if (list.length === 0) {
        grid.innerHTML = '';
        empty.classList.remove('d-none');
        return;
      }

      empty.classList.add('d-none');
      grid.innerHTML = list.map((p) => {
        const imgHtml = p.image_url
          ? `<img src="${escapeHtml(p.image_url)}" alt="${escapeHtml(p.name)}" loading="lazy">`
          : `<div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="bi bi-image fs-2"></i></div>`;

        const topBadge = !p.in_stock
          ? `<span class="badge bg-dark position-absolute top-0 start-0 m-2" style="font-size:0.65rem;letter-spacing:0.08em;">SOLD OUT</span>`
          : (p.is_on_sale
              ? `<span class="badge bg-danger position-absolute top-0 start-0 m-2" style="font-size:0.65rem;letter-spacing:0.08em;">SALE</span>`
              : (p.is_new_arrival
                  ? `<span class="badge bg-white text-dark border position-absolute top-0 start-0 m-2" style="font-size:0.65rem;letter-spacing:0.08em;">NEW</span>`
                  : ''));

        const photoBadge = Array.isArray(p.gallery_urls) && p.gallery_urls.length > 1
          ? `<span class="badge bg-white text-dark border position-absolute top-0 end-0 m-2" style="font-size:0.65rem;"><i class="bi bi-images me-1"></i>${p.gallery_urls.length}</span>`
          : '';

        const priceHtml = p.is_on_sale
          ? `<span class="fw-semibold text-dark">${money(p.display_price)}</span> <span class="text-muted text-decoration-line-through small">${money(p.price)}</span>`
          : `<span class="fw-semibold text-dark">${money(p.display_price)}</span>`;

        const quickAddBtn = p.in_stock
          ? `<button type="button" class="plp-quick-add" data-quick-add="${p.id}">+ Add to Bag</button>`
          : `<span class="plp-quick-add text-center opacity-75">Currently Unavailable</span>`;

        return `
          <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <article class="plp-product-card">
              <div class="plp-product-frame" data-open-product="${p.id}">
                ${imgHtml}
                ${topBadge}
                ${photoBadge}
                ${quickAddBtn}
              </div>
              <div class="pt-3 d-flex flex-column flex-grow-1">
                <span class="plp-product-category mb-1">${escapeHtml(p.category_name || 'Studio')}</span>
                <h3 class="plp-product-title mb-1" data-open-product="${p.id}" style="cursor:pointer;">${escapeHtml(p.name)}</h3>
                <div class="mt-auto pt-1 small">${priceHtml}</div>
              </div>
            </article>
          </div>
        `;
      }).join('');
    }

    function openProductModal(productId, fallbackSlide = null) {
      const product = PRODUCTS.find((p) => Number(p.id) === Number(productId)) || null;
      const modalEl = document.getElementById('productDetailModal');
      if (!modalEl || typeof bootstrap === 'undefined') return;

      const mainImg = document.getElementById('modalMainImage');
      const thumbsWrap = document.getElementById('modalThumbnails');
      const catEl = document.getElementById('modalCategory');
      const titleEl = document.getElementById('modalTitle');
      const priceWrap = document.getElementById('modalPriceWrap');
      const stockWrap = document.getElementById('modalStockWrap');
      const descEl = document.getElementById('modalDescription');
      const skuEl = document.getElementById('modalSku');
      const actionWrap = document.getElementById('modalActionWrap');
      const qtyInput = document.getElementById('modalQtyInput');

      qtyInput.value = '1';

      if (product) {
        state.activeProduct = product;
        const gallery = Array.isArray(product.gallery_urls) && product.gallery_urls.length > 0
          ? product.gallery_urls
          : (product.image_url ? [product.image_url] : []);

        mainImg.src = gallery[0] || '';
        mainImg.alt = product.name || '';
        thumbsWrap.innerHTML = gallery.length > 1
          ? gallery.map((url, i) => `
              <button type="button" class="plp-thumb-btn ${i === 0 ? 'active' : ''}" data-thumb-url="${escapeHtml(url)}">
                <img src="${escapeHtml(url)}" alt="Photo ${i + 1}">
              </button>
            `).join('')
          : '';

        catEl.textContent = product.category_name || 'Studio Release';
        titleEl.textContent = product.name || '';
        priceWrap.innerHTML = product.is_on_sale
          ? `<span class="fs-5 fw-semibold text-dark">${money(product.display_price)}</span> <span class="text-muted text-decoration-line-through ms-2">${money(product.price)}</span>`
          : `<span class="fs-5 fw-semibold text-dark">${money(product.display_price)}</span>`;
        stockWrap.innerHTML = product.in_stock
          ? `<span class="badge bg-success-subtle text-success border border-success-subtle">In Stock</span>`
          : `<span class="badge bg-secondary-subtle text-secondary">Out of Stock</span>`;
        descEl.textContent = product.description || 'Precision crafted at Pixel Laser Prints in Charlottetown, PEI.';
        skuEl.textContent = product.sku ? 'SKU: ' + product.sku : '';
        actionWrap.classList.toggle('d-none', !product.in_stock);
      } else if (fallbackSlide) {
        state.activeProduct = null;
        mainImg.src = fallbackSlide.image || '';
        mainImg.alt = fallbackSlide.title || '';
        thumbsWrap.innerHTML = '';
        catEl.textContent = fallbackSlide.badge || 'NEW ARRIVAL';
        titleEl.textContent = fallbackSlide.title || '';
        priceWrap.innerHTML = fallbackSlide.price !== ''
          ? `<span class="fs-5 fw-semibold text-dark">${money(fallbackSlide.price)}</span>`
          : '';
        stockWrap.innerHTML = '<span class="badge bg-dark">New Arrival Showcase</span>';
        descEl.textContent = fallbackSlide.subtitle || 'Available soon through Pixel Laser Prints Studio in Charlottetown, PEI.';
        skuEl.textContent = '';
        actionWrap.classList.add('d-none');
      } else {
        return;
      }

      bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }

    function renderBag() {
      const emptyMsg = document.getElementById('bagEmptyMsg');
      const listEl = document.getElementById('bagItemsList');
      const summaryWrap = document.getElementById('bagSummaryWrap');
      if (!emptyMsg || !listEl || !summaryWrap) return;

      if (state.cart.length === 0) {
        emptyMsg.classList.remove('d-none');
        listEl.innerHTML = '';
        summaryWrap.classList.add('d-none');
        return;
      }

      emptyMsg.classList.add('d-none');
      summaryWrap.classList.remove('d-none');

      let subtotal = 0;
      listEl.innerHTML = state.cart.map((item, idx) => {
        const lineTotal = (Number(item.price) || 0) * (Number(item.quantity) || 1);
        subtotal += lineTotal;
        const thumb = item.image_url
          ? `<img src="${escapeHtml(item.image_url)}" alt="${escapeHtml(item.name)}" class="rounded-2 border flex-shrink-0" style="width: 58px; height: 70px; object-fit: cover;">`
          : `<div class="rounded-2 border bg-light d-flex align-items-center justify-content-center flex-shrink-0" style="width: 58px; height: 70px;"><i class="bi bi-image text-muted"></i></div>`;

        return `
          <div class="d-flex gap-3 py-3 border-bottom align-items-center">
            ${thumb}
            <div class="flex-grow-1 min-w-0">
              <div class="fw-medium small text-truncate">${escapeHtml(item.name)}</div>
              <div class="text-muted" style="font-size: 0.78rem;">${money(item.price)}</div>
              <div class="d-flex align-items-center gap-2 mt-2">
                <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" data-bag-dec="${idx}">-</button>
                <span class="small fw-medium">${Number(item.quantity)}</span>
                <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" data-bag-inc="${idx}">+</button>
                <button type="button" class="btn btn-link btn-sm text-danger text-decoration-none ms-auto p-0" data-bag-del="${idx}">Remove</button>
              </div>
            </div>
          </div>
        `;
      }).join('');

      const tax = subtotal * 0.15;
      const total = subtotal + tax;
      document.getElementById('bagSubtotal').textContent = money(subtotal);
      document.getElementById('bagTax').textContent = money(tax);
      document.getElementById('bagTotal').textContent = money(total);
      document.getElementById('checkoutHeaderTotal').textContent = money(total);
    }

    function initCarousel() {
      const track = document.getElementById('verticalCarouselTrack');
      const prevBtn = document.getElementById('carouselPrev');
      const nextBtn = document.getElementById('carouselNext');
      if (!track) return;

      const stepPx = 300;
      if (prevBtn) {
        prevBtn.addEventListener('click', () => track.scrollBy({ left: -stepPx, behavior: 'smooth' }));
      }
      if (nextBtn) {
        nextBtn.addEventListener('click', () => track.scrollBy({ left: stepPx, behavior: 'smooth' }));
      }

      let isDown = false;
      let startX = 0;
      let startScroll = 0;
      let dragged = false;

      track.addEventListener('mousedown', (e) => {
        isDown = true;
        dragged = false;
        startX = e.pageX - track.offsetLeft;
        startScroll = track.scrollLeft;
        track.classList.add('is-dragging');
      });

      window.addEventListener('mouseup', () => {
        if (!isDown) return;
        isDown = false;
        track.classList.remove('is-dragging');
      });

      track.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - track.offsetLeft;
        if (Math.abs(x - startX) > 6) dragged = true;
        track.scrollLeft = startScroll - (x - startX) * 1.2;
      });

      track.addEventListener('click', (e) => {
        if (dragged) {
          dragged = false;
          return;
        }
        const card = e.target.closest('.plp-vertical-card');
        if (!card) return;
        const pid = Number(card.dataset.productId || 0);
        openProductModal(pid, {
          title: card.dataset.slideTitle || '',
          subtitle: card.dataset.slideSubtitle || '',
          badge: card.dataset.slideBadge || '',
          image: card.dataset.slideImage || '',
          price: card.dataset.slidePrice || '',
        });
      });
    }

    function initEvents() {
      // Category filter pills
      document.getElementById('categoryFilters')?.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-category]');
        if (!btn) return;
        document.querySelectorAll('#categoryFilters [data-category]').forEach((el) => el.classList.remove('active'));
        btn.classList.add('active');
        state.category = btn.dataset.category || 'all';
        renderProducts();
      });

      // Live search & sort
      const searchInput = document.getElementById('storeSearchInput');
      searchInput?.addEventListener('input', (e) => {
        state.search = e.target.value || '';
        renderProducts();
      });

      document.getElementById('storeSortSelect')?.addEventListener('change', (e) => {
        state.sort = e.target.value || 'newest';
        renderProducts();
      });

      document.getElementById('resetFiltersBtn')?.addEventListener('click', () => {
        state.category = 'all';
        state.search = '';
        if (searchInput) searchInput.value = '';
        document.querySelectorAll('#categoryFilters [data-category]').forEach((el) => {
          el.classList.toggle('active', el.dataset.category === 'all');
        });
        renderProducts();
      });

      // Grid actions
      document.getElementById('storeProductGrid')?.addEventListener('click', (e) => {
        const quickBtn = e.target.closest('[data-quick-add]');
        if (quickBtn) {
          e.stopPropagation();
          addToCart(Number(quickBtn.dataset.quickAdd), 1);
          return;
        }
        const openTrigger = e.target.closest('[data-open-product]');
        if (openTrigger) {
          openProductModal(Number(openTrigger.dataset.openProduct));
        }
      });

      // Modal gallery thumbnails & qty
      document.getElementById('modalThumbnails')?.addEventListener('click', (e) => {
        const thumb = e.target.closest('[data-thumb-url]');
        if (!thumb) return;
        document.getElementById('modalMainImage').src = thumb.dataset.thumbUrl || '';
        document.querySelectorAll('#modalThumbnails .plp-thumb-btn').forEach((b) => b.classList.remove('active'));
        thumb.classList.add('active');
      });

      document.getElementById('modalQtyMinus')?.addEventListener('click', () => {
        const inp = document.getElementById('modalQtyInput');
        inp.value = String(Math.max(1, Number(inp.value) - 1));
      });

      document.getElementById('modalQtyPlus')?.addEventListener('click', () => {
        const inp = document.getElementById('modalQtyInput');
        inp.value = String(Math.min(50, Number(inp.value) + 1));
      });

      document.getElementById('modalAddToBagBtn')?.addEventListener('click', () => {
        if (!state.activeProduct) return;
        const qty = Number(document.getElementById('modalQtyInput').value) || 1;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('productDetailModal')).hide();
        addToCart(state.activeProduct.id, qty);
      });

      // Header cart link opens drawer directly when already on /store
      document.getElementById('cartButton')?.addEventListener('click', (e) => {
        e.preventDefault();
        openBagOffcanvas();
      });

      // Bag item controls
      document.getElementById('bagItemsList')?.addEventListener('click', (e) => {
        const dec = e.target.closest('[data-bag-dec]');
        const inc = e.target.closest('[data-bag-inc]');
        const del = e.target.closest('[data-bag-del]');
        if (dec) {
          const i = Number(dec.dataset.bagDec);
          if (state.cart[i]) {
            if (state.cart[i].quantity > 1) state.cart[i].quantity--;
            else state.cart.splice(i, 1);
            saveCart();
          }
        } else if (inc) {
          const i = Number(inc.dataset.bagInc);
          if (state.cart[i]) {
            state.cart[i].quantity = Math.min(99, state.cart[i].quantity + 1);
            saveCart();
          }
        } else if (del) {
          const i = Number(del.dataset.bagDel);
          state.cart.splice(i, 1);
          saveCart();
        }
      });

      // Checkout flow
      document.getElementById('proceedCheckoutBtn')?.addEventListener('click', () => showBagView('checkout'));
      document.getElementById('backToBagBtn')?.addEventListener('click', () => showBagView('items'));

      document.getElementById('checkoutDeliveryType')?.addEventListener('change', (e) => {
        const wrap = document.getElementById('shippingFieldsWrap');
        wrap?.classList.toggle('d-none', e.target.value !== 'shipping');
      });

      document.getElementById('storeCheckoutForm')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const submitBtn = document.getElementById('submitOrderBtn');
        const errBox = document.getElementById('checkoutError');
        errBox.classList.add('d-none');

        const fd = new FormData(form);
        const payload = {
          customer_name: fd.get('customer_name'),
          customer_email: fd.get('customer_email'),
          customer_phone: fd.get('customer_phone'),
          delivery_type: fd.get('delivery_type'),
          shipping_address: fd.get('shipping_address'),
          shipping_city: fd.get('shipping_city'),
          shipping_postal_code: fd.get('shipping_postal_code'),
          payment_method: fd.get('payment_method'),
          notes: fd.get('notes'),
          idempotency_key: 'plp-store-' + Date.now() + '-' + Math.random().toString(36).slice(2, 8),
          items: state.cart.map((item) => ({
            product_id: item.product_id,
            name: item.name,
            quantity: item.quantity,
            price: item.price,
          })),
        };

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending Order...';

        try {
          const res = await fetch(STORE_API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(payload),
          });
          const data = await res.json();
          if (!res.ok || !data.success) {
            throw new Error(data.message || 'Unable to place your order.');
          }

          document.getElementById('successTracking').textContent = data.tracking_number || ('#' + data.order_id);
          document.getElementById('successTotal').textContent = money(data.total);
          const interacNote = document.getElementById('successInteracNote');
          interacNote.textContent = data.payment_method === 'pay_on_pickup'
            ? 'Payment will be completed at pickup (180 Belvedere Ave, Charlottetown).'
            : 'Please send your Interac e-Transfer to ' + (data.interac_email || 'sales@pixellaserprints.ca') + ' referencing ' + (data.tracking_number || '') + '.';

          state.cart = [];
          saveCart();
          form.reset();
          document.getElementById('shippingFieldsWrap')?.classList.add('d-none');
          showBagView('success');
        } catch (err) {
          errBox.textContent = err.message || 'Could not place order. Please try again.';
          errBox.classList.remove('d-none');
        } finally {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Place Order';
        }
      });
    }

    document.addEventListener('DOMContentLoaded', () => {
      loadCart();
      renderBag();
      renderProducts();
      initCarousel();
      initEvents();

      const params = new URLSearchParams(window.location.search);
      if (params.get('cart') === '1') {
        openBagOffcanvas();
      }
    });
  })();
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
