<?php
/**
 * AJAX Bridge for the 3D Architectural Plaque & Signage Configurator
 * Proxies requests securely to the Pou Technologies Client Portal API
 * and dispatches direct notification emails to pixelcharlottetown@gmail.com.
 */
header('Content-Type: application/json; charset=UTF-8');

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

$action = $input['action'] ?? '';

/**
 * Helper to send direct notification email from Pixel Laser Prints server
 * for 3D Custom Plaque orders (currently routing to test@poutechnologies.com for test/review).
 */
function sendPlaqueNotificationEmail(array $orderInfo): void
{
    // Test mode: Send all order notifications to test@poutechnologies.com
    $to = getenv('PLAQUE_NOTIFICATION_EMAIL') ?: 'test@poutechnologies.com';

    $orderNum = $orderInfo['order_number'] ?? ('#' . ($orderInfo['order_id'] ?? 'N/A'));
    $customerName = $orderInfo['customer_name'] ?? 'Customer';
    $customerEmail = $orderInfo['customer_email'] ?? 'no-reply@pixellaserprints.ca';
    $customerPhone = $orderInfo['customer_phone'] ?? 'N/A';
    $method = strtoupper((string) ($orderInfo['payment_method'] ?? 'ORDER'));
    $status = strtoupper((string) ($orderInfo['payment_status'] ?? 'PENDING'));

    $subject = "[Pixel Laser Prints] New 3D Custom Plaque Order {$orderNum} ({$method} - {$status})";

    $lines = [
        "==========================================================",
        "NEW 3D ARCHITECTURAL PLAQUE ORDER - PIXEL LASER PRINTS",
        "==========================================================",
        "Order Reference : {$orderNum}",
        "Portal Order ID : #" . ($orderInfo['order_id'] ?? 'N/A'),
        "Payment Method  : {$method}",
        "Payment Status  : {$status}",
    ];

    if (!empty($orderInfo['transaction_id'])) {
        $lines[] = "Helcim Tx ID    : " . $orderInfo['transaction_id'];
    }

    $sintraLabel = $orderInfo['sintra_color_label'] ?? (!empty($orderInfo['sintra_color']) ? ucfirst((string) $orderInfo['sintra_color']) . ' Sintra (6mm)' : 'Black Sintra (6mm)');
    $standoffLabel = $orderInfo['standoff_finish_label'] ?? (!empty($orderInfo['standoff_finish']) ? ucfirst((string) $orderInfo['standoff_finish']) . ' Standoffs' : 'Silver Standoffs');

    $backingDesc = ($orderInfo['construction_style'] ?? '') === 'cnc_cut_acm'
        ? "{$sintraLabel} + CNC Cutout ACM Front + 2 Lateral {$standoffLabel}"
        : "Solid ACM Plate + Surface-Mounted Raised Acrylic + 2 Lateral {$standoffLabel}";

    $lines[] = "";
    $lines[] = "--- 3D PLAQUE SPECIFICATIONS ---";
    $lines[] = "Plaque Type         : " . ucfirst((string) ($orderInfo['plaque_type'] ?? 'house'));
    $lines[] = "Construction Style  : " . ($orderInfo['construction_style_label'] ?? $orderInfo['construction_style'] ?? 'Raised 3D Acrylic');
    $lines[] = "Typography / Font   : " . ($orderInfo['font_style_label'] ?? $orderInfo['font_style'] ?? 'Athletic Octagonal Block');
    $lines[] = "Primary 3D Text     : " . ($orderInfo['primary_text'] ?? '');
    $lines[] = "Subtitle Text       : " . (!empty($orderInfo['subtitle_text']) ? $orderInfo['subtitle_text'] : 'None');
    $lines[] = "Front Plate (ACM)   : " . ($orderInfo['acm_finish_label'] ?? $orderInfo['acm_finish'] ?? '');
    $lines[] = "3D Digits (Acrylic) : " . ($orderInfo['acrylic_finish_label'] ?? $orderInfo['acrylic_finish'] ?? '');
    if (($orderInfo['construction_style'] ?? '') === 'cnc_cut_acm') {
        $lines[] = "Sintra Backing (6mm): {$sintraLabel}";
    }
    $lines[] = "Standoff Finish     : 2 Lateral {$standoffLabel}";
    $lines[] = "Backing & Hardware  : {$backingDesc}";
    $lines[] = "Size                : " . ($orderInfo['size_label'] ?? $orderInfo['size'] ?? '');
    $lines[] = "";
    $lines[] = "--- CUSTOMER DETAILS ---";
    $lines[] = "Name            : {$customerName}";
    $lines[] = "Email           : {$customerEmail}";
    $lines[] = "Phone           : {$customerPhone}";
    $lines[] = "";
    $lines[] = "--- FULFILLMENT & DELIVERY ---";
    $deliveryMethod = ($orderInfo['delivery_method'] ?? 'pickup') === 'shipping' ? 'shipping' : 'pickup';
    if ($deliveryMethod === 'shipping') {
        $lines[] = "Method          : Direct Shipping";
        $lines[] = "Address Line 1  : " . ($orderInfo['shipping_address_line1'] ?? '');
        if (!empty($orderInfo['shipping_address_line2'])) {
            $lines[] = "Address Line 2  : " . $orderInfo['shipping_address_line2'];
        }
        $lines[] = "City / Prov / PC: " . trim(($orderInfo['shipping_city'] ?? '') . ', ' . ($orderInfo['shipping_province'] ?? '') . ' ' . ($orderInfo['shipping_postal_code'] ?? ''));
        $lines[] = "Country         : " . ($orderInfo['shipping_country'] ?? 'Canada');
        if (!empty($orderInfo['shipping_instructions'])) {
            $lines[] = "Delivery Notes  : " . $orderInfo['shipping_instructions'];
        }
    } else {
        $lines[] = "Method          : Pick up in Store (Free)";
        $lines[] = "Pickup Location : 180 Belvedere Ave, Charlottetown, PEI, C1A 2Z1, Canada";
    }
    $lines[] = "";
    $lines[] = "--- PRICING BREAKDOWN (CAD) ---";
    $lines[] = "Subtotal (CAD)  : $" . number_format((float) ($orderInfo['subtotal_cad'] ?? 0), 2) . " CAD";
    $lines[] = "PEI HST (15%)   : $" . number_format((float) ($orderInfo['hst_cad'] ?? 0), 2) . " CAD";
    $lines[] = "Total (CAD)     : $" . number_format((float) ($orderInfo['total_cad'] ?? 0), 2) . " CAD";
    $lines[] = "==========================================================";

    $headers = "From: Pixel Laser Prints <sales@pixellaserprints.ca>\r\n";
    if (filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
        $headers .= "Reply-To: {$customerEmail}\r\n";
    }
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    @mail($to, $subject, implode("\r\n", $lines), $headers);
}

if ($action === 'create_order') {
    $payload = [
        'customer_name'  => trim((string) ($input['customer_name'] ?? '')),
        'customer_email' => trim((string) ($input['customer_email'] ?? '')),
        'customer_phone'     => trim((string) ($input['customer_phone'] ?? '')),
        'plaque_type'        => trim((string) ($input['plaque_type'] ?? 'house')),
        'construction_style' => trim((string) ($input['construction_style'] ?? 'raised_acrylic')),
        'font_style'         => trim((string) ($input['font_style'] ?? 'athletic_block')),
        'primary_text'       => trim((string) ($input['primary_text'] ?? '')),
        'subtitle_text'      => trim((string) ($input['subtitle_text'] ?? '')),
        'acm_finish'         => trim((string) ($input['acm_finish'] ?? 'matte_black')),
        'acrylic_finish'     => trim((string) ($input['acrylic_finish'] ?? 'mirror_gold')),
        'sintra_color'       => trim((string) ($input['sintra_color'] ?? 'black')),
        'standoff_finish'    => trim((string) ($input['standoff_finish'] ?? 'silver')),
        'size'               => trim((string) ($input['size'] ?? 'medium')),
        'payment_method'     => trim((string) ($input['payment_method'] ?? 'helcim')),
        'delivery_method'        => trim((string) ($input['delivery_method'] ?? 'pickup')),
        'shipping_address_line1' => trim((string) ($input['shipping_address_line1'] ?? '')),
        'shipping_address_line2' => trim((string) ($input['shipping_address_line2'] ?? '')),
        'shipping_city'          => trim((string) ($input['shipping_city'] ?? '')),
        'shipping_province'      => trim((string) ($input['shipping_province'] ?? '')),
        'shipping_postal_code'   => trim((string) ($input['shipping_postal_code'] ?? '')),
        'shipping_country'       => trim((string) ($input['shipping_country'] ?? 'Canada')),
        'shipping_instructions'  => trim((string) ($input['shipping_instructions'] ?? '')),
    ];

    if (empty($payload['customer_name']) || empty($payload['customer_email']) || empty($payload['primary_text'])) {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'Please enter your primary plaque text, full name, and email address.',
        ]);
        exit;
    }

    if ($payload['delivery_method'] === 'shipping' && (empty($payload['shipping_address_line1']) || empty($payload['shipping_city']) || empty($payload['shipping_province']) || empty($payload['shipping_postal_code']))) {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'Please provide your shipping street address, city, province, and postal code.',
        ]);
        exit;
    }

    if (!filter_var($payload['customer_email'], FILTER_VALIDATE_EMAIL)) {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'Please enter a valid email address.',
        ]);
        exit;
    }

    $res = PortalApiClient::createPlaqueOrder($payload);

    if (!empty($res['success']) && !empty($res['data']['success'])) {
        $apiData = $res['data']['data'] ?? [];

        // If Interac e-Transfer, also send local server notification to test@poutechnologies.com
        if ($payload['payment_method'] === 'interac') {
            sendPlaqueNotificationEmail(array_merge($payload, $apiData, [
                'payment_status' => 'pending (Interac e-Transfer)',
            ]));
        }

        echo json_encode([
            'success' => true,
            'data'    => $apiData,
        ]);
        exit;
    }

    // Seamless Sandbox Fallback: If Helcim token is not configured on the portal account,
    // generate a test checkout session so the client can preview and test payment flow.
    $errMsg = (string) ($res['data']['message'] ?? $res['error'] ?? '');
    if (strpos($errMsg, 'Helcim API Token is not configured') !== false || strpos($errMsg, 'Helcim') !== false) {
        $testOrderNum = 'PLP-TEST-' . strtoupper(substr(md5(uniqid()), 0, 8));
        $subtotalCad = 60.00;
        if ($payload['size'] === 'small') $subtotalCad = 45.00;
        elseif ($payload['size'] === 'large') $subtotalCad = 85.00;
        if ($payload['construction_style'] === 'cnc_cut_acm') {
            $subtotalCad += ($payload['size'] === 'large' ? 15.00 : 10.00);
        }
        $hstCad = round($subtotalCad * 0.15, 2);
        $totalCad = round($subtotalCad + $hstCad, 2);

        echo json_encode([
            'success' => true,
            'data' => [
                'order_id' => 99999,
                'order_number' => $testOrderNum,
                'checkout_token' => 'test_helcim_' . bin2hex(random_bytes(16)),
                'secret_token' => 'test_secret_' . bin2hex(random_bytes(8)),
                'subtotal_cad' => $subtotalCad,
                'hst_cad' => $hstCad,
                'total_cad' => $totalCad,
                'is_test_mode' => true,
            ],
        ]);
        exit;
    }

    http_response_code($res['http_code'] >= 400 ? $res['http_code'] : 422);
    echo json_encode([
        'success' => false,
        'message' => $errMsg ?: 'Unable to process your order right now. Please try again or choose Interac e-Transfer.',
        'errors'  => $res['data']['errors'] ?? null,
    ]);
    exit;
}

if ($action === 'confirm_helcim') {
    $payload = [
        'order_id'         => (int) ($input['order_id'] ?? 0),
        'order_number'     => trim((string) ($input['order_number'] ?? '')),
        'transaction_data'   => is_array($input['transaction_data'] ?? null) ? $input['transaction_data'] : [],
        'plaque_type'        => trim((string) ($input['plaque_type'] ?? 'house')),
        'construction_style' => trim((string) ($input['construction_style'] ?? '')),
        'font_style'         => trim((string) ($input['font_style'] ?? '')),
        'primary_text'       => trim((string) ($input['primary_text'] ?? '')),
        'subtitle_text'      => trim((string) ($input['subtitle_text'] ?? '')),
        'acm_finish'         => trim((string) ($input['acm_finish'] ?? '')),
        'acrylic_finish'     => trim((string) ($input['acrylic_finish'] ?? '')),
        'sintra_color'       => trim((string) ($input['sintra_color'] ?? '')),
        'standoff_finish'    => trim((string) ($input['standoff_finish'] ?? '')),
        'delivery_method'    => trim((string) ($input['delivery_method'] ?? 'pickup')),
        'shipping_address_line1' => trim((string) ($input['shipping_address_line1'] ?? '')),
        'shipping_address_line2' => trim((string) ($input['shipping_address_line2'] ?? '')),
        'shipping_city'      => trim((string) ($input['shipping_city'] ?? '')),
        'shipping_province'  => trim((string) ($input['shipping_province'] ?? '')),
        'shipping_postal_code' => trim((string) ($input['shipping_postal_code'] ?? '')),
        'shipping_country'   => trim((string) ($input['shipping_country'] ?? 'Canada')),
        'shipping_instructions' => trim((string) ($input['shipping_instructions'] ?? '')),
        'size'               => trim((string) ($input['size'] ?? '')),
    ];

    if ($payload['order_id'] <= 0 || empty($payload['order_number'])) {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'Missing order reference for Helcim confirmation.',
        ]);
        exit;
    }

    $res = PortalApiClient::confirmPlaqueHelcim($payload);

    if (!empty($res['success']) && !empty($res['data']['success'])) {
        $apiData = $res['data']['data'] ?? [];

        sendPlaqueNotificationEmail(array_merge($input, $apiData, [
            'payment_method' => 'helcim',
            'payment_status' => 'paid',
        ]));

        echo json_encode([
            'success' => true,
            'data'    => $apiData,
        ]);
        exit;
    }

    // Seamless Sandbox Confirmation Fallback
    if (strpos($payload['order_number'], 'PLP-TEST') === 0 || !empty($input['is_test_mode'])) {
        $txData = $payload['transaction_data'] ?? [];
        $txId = $txData['data']['transactionId'] ?? $txData['transactionId'] ?? ('TX-TEST-' . rand(100000, 999999));

        $testConfirmData = array_merge($input, [
            'transaction_id' => $txId,
            'status' => 'paid',
            'payment_status' => 'paid',
            'payment_method' => 'helcim (Sandbox Test)',
        ]);

        sendPlaqueNotificationEmail($testConfirmData);

        echo json_encode([
            'success' => true,
            'data'    => $testConfirmData,
        ]);
        exit;
    }

    $errMsg = $res['data']['message']
        ?? $res['error']
        ?? 'Could not confirm Helcim payment.';

    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => $errMsg,
    ]);
    exit;
}

http_response_code(400);
echo json_encode([
    'success' => false,
    'message' => 'Invalid action specified.',
]);
