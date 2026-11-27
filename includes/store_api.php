<?php
/**
 * AJAX Checkout Bridge for Pixel Laser Prints Minimalist Online Store.
 * Verifies product prices against the Client Portal catalog and submits orders
 * directly into the Client Portal Orders dashboard.
 */
header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/PortalApiClient.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

$rawBody = file_get_contents('php://input');
$input = json_decode($rawBody, true);
if (!is_array($input)) {
    $input = $_POST;
}

$customerName = trim((string) ($input['customer_name'] ?? ''));
$customerEmail = trim((string) ($input['customer_email'] ?? ''));
$customerPhone = trim((string) ($input['customer_phone'] ?? ''));
$deliveryType = ($input['delivery_type'] ?? 'pickup') === 'shipping' ? 'shipping' : 'pickup';
$shippingAddress = trim((string) ($input['shipping_address'] ?? ''));
$shippingCity = trim((string) ($input['shipping_city'] ?? ''));
$shippingPostalCode = trim((string) ($input['shipping_postal_code'] ?? ''));
$paymentMethod = in_array(($input['payment_method'] ?? ''), ['interac', 'pay_on_pickup'], true)
    ? $input['payment_method']
    : 'interac';
$notes = trim((string) ($input['notes'] ?? ''));
$idempotencyKey = trim((string) ($input['idempotency_key'] ?? ''));
$rawItems = is_array($input['items'] ?? null) ? $input['items'] : [];

if ($customerName === '' || !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Please enter your full name and a valid email address.',
    ]);
    exit;
}

if ($deliveryType === 'shipping' && ($shippingAddress === '' || $shippingCity === '' || $shippingPostalCode === '')) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Please complete your shipping street address, city, and postal code.',
    ]);
    exit;
}

if (empty($rawItems)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Your shopping bag is empty.',
    ]);
    exit;
}

$catalogRes = PortalApiClient::getStoreProducts(90);
$catalogProducts = [];
if (!empty($catalogRes['success']) && !empty($catalogRes['data']['data']['products'])) {
    foreach ($catalogRes['data']['data']['products'] as $p) {
        if (!empty($p['id'])) {
            $catalogProducts[(int) $p['id']] = $p;
        }
    }
}

$verifiedItems = [];
$subtotal = 0.0;

foreach ($rawItems as $row) {
    $qty = max(1, min(99, (int) ($row['quantity'] ?? 1)));
    $pid = !empty($row['product_id']) ? (int) $row['product_id'] : null;

    if ($pid && isset($catalogProducts[$pid])) {
        $product = $catalogProducts[$pid];
        if (empty($product['in_stock'])) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => '"' . ($product['name'] ?? 'Product') . '" is currently out of stock.',
            ]);
            exit;
        }

        $unitPrice = round((float) ($product['display_price'] ?? $product['price'] ?? 0), 2);
        $name = (string) ($product['name'] ?? ($row['name'] ?? 'Product'));
    } else {
        $unitPrice = round(max(0, (float) ($row['price'] ?? 0)), 2);
        $name = trim((string) ($row['name'] ?? 'Custom Store Item'));
        $pid = null;
    }

    if ($unitPrice <= 0) {
        continue;
    }

    $verifiedItems[] = [
        'product_id' => $pid,
        'name' => $name,
        'quantity' => $qty,
        'price' => $unitPrice,
    ];
    $subtotal += $unitPrice * $qty;
}

if (empty($verifiedItems)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'No valid purchasable items were found in your bag.',
    ]);
    exit;
}

$subtotal = round($subtotal, 2);
$taxAmount = round($subtotal * 0.15, 2);
$total = round($subtotal + $taxAmount, 2);

$noteLines = [
    'Source: Pixel Laser Prints Minimalist Online Store',
    'Fulfillment: ' . ($deliveryType === 'shipping' ? 'Shipping' : 'Local Pickup (' . COMPANY_FULL_ADDRESS . ')'),
    'Payment Method: ' . ($paymentMethod === 'pay_on_pickup' ? 'Pay on Pickup' : 'Interac e-Transfer (' . COMPANY_EMAIL . ')'),
];
if ($notes !== '') {
    $noteLines[] = 'Customer Note: ' . $notes;
}

$portalPayload = [
    'customer_name' => $customerName,
    'customer_email' => $customerEmail,
    'customer_phone' => $customerPhone !== '' ? $customerPhone : null,
    'subtotal' => $subtotal,
    'tax_amount' => $taxAmount,
    'total' => $total,
    'delivery_type' => $deliveryType,
    'shipping_address' => $deliveryType === 'shipping' ? $shippingAddress : null,
    'shipping_city' => $deliveryType === 'shipping' ? $shippingCity : null,
    'shipping_postal_code' => $deliveryType === 'shipping' ? $shippingPostalCode : null,
    'payment_method' => $paymentMethod,
    'sale_origin' => 'online_store',
    'notes' => implode("\n", $noteLines),
    'idempotency_key' => $idempotencyKey !== '' ? $idempotencyKey : null,
    'items' => $verifiedItems,
];

$portalRes = PortalApiClient::createOrder($portalPayload);
if (empty($portalRes['success']) || empty($portalRes['data']['success'])) {
    $errMsg = $portalRes['data']['message'] ?? ($portalRes['error'] ?? 'Could not place order right now. Please try again.');
    http_response_code(502);
    echo json_encode([
        'success' => false,
        'message' => $errMsg,
    ]);
    exit;
}

$orderData = $portalRes['data']['data'] ?? [];
echo json_encode([
    'success' => true,
    'order_id' => $orderData['order_id'] ?? null,
    'order_number' => $orderData['order_number'] ?? null,
    'tracking_number' => $orderData['tracking_number'] ?? ('PLP-' . ($orderData['order_id'] ?? '')),
    'subtotal' => $subtotal,
    'tax_amount' => $taxAmount,
    'total' => $total,
    'payment_method' => $paymentMethod,
    'interac_email' => COMPANY_EMAIL,
]);
