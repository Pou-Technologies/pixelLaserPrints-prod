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
 * to pixelcharlottetown@gmail.com as an immediate notification backup.
 */
function sendPlaqueNotificationEmail(array $orderInfo): void
{
    $to = 'pixelcharlottetown@gmail.com';
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (strpos($host, 'qa404') !== false || strpos(__FILE__, 'pixelLaserPrints-qa') !== false) {
        $to = 'test@poutechnologies.com';
    }

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

    $lines[] = "";
    $lines[] = "--- 3D PLAQUE SPECIFICATIONS ---";
    $lines[] = "Plaque Type     : " . ucfirst((string) ($orderInfo['plaque_type'] ?? 'house'));
    $lines[] = "Primary 3D Text : " . ($orderInfo['primary_text'] ?? '');
    $lines[] = "Subtitle Text   : " . (!empty($orderInfo['subtitle_text']) ? $orderInfo['subtitle_text'] : 'None');
    $lines[] = "Material Finish : " . ($orderInfo['finish_label'] ?? $orderInfo['finish'] ?? '');
    $lines[] = "Size            : " . ($orderInfo['size_label'] ?? $orderInfo['size'] ?? '');
    $lines[] = "";
    $lines[] = "--- CUSTOMER DETAILS ---";
    $lines[] = "Name            : {$customerName}";
    $lines[] = "Email           : {$customerEmail}";
    $lines[] = "Phone           : {$customerPhone}";
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
        'customer_phone' => trim((string) ($input['customer_phone'] ?? '')),
        'plaque_type'    => trim((string) ($input['plaque_type'] ?? 'house')),
        'primary_text'   => trim((string) ($input['primary_text'] ?? '')),
        'subtitle_text'  => trim((string) ($input['subtitle_text'] ?? '')),
        'finish'         => trim((string) ($input['finish'] ?? 'matte_black_aluminum')),
        'size'           => trim((string) ($input['size'] ?? 'medium')),
        'payment_method' => trim((string) ($input['payment_method'] ?? 'helcim')),
    ];

    if (empty($payload['customer_name']) || empty($payload['customer_email']) || empty($payload['primary_text'])) {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'Please enter your primary plaque text, full name, and email address.',
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

        // If Interac e-Transfer, also send local server notification to pixelcharlottetown@gmail.com
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

    $errMsg = $res['data']['message']
        ?? $res['error']
        ?? 'Unable to process your order right now. Please try again or choose Interac e-Transfer.';

    http_response_code($res['http_code'] >= 400 ? $res['http_code'] : 422);
    echo json_encode([
        'success' => false,
        'message' => $errMsg,
        'errors'  => $res['data']['errors'] ?? null,
    ]);
    exit;
}

if ($action === 'confirm_helcim') {
    $payload = [
        'order_id'         => (int) ($input['order_id'] ?? 0),
        'order_number'     => trim((string) ($input['order_number'] ?? '')),
        'transaction_data' => is_array($input['transaction_data'] ?? null) ? $input['transaction_data'] : [],
        'plaque_type'      => trim((string) ($input['plaque_type'] ?? 'house')),
        'primary_text'     => trim((string) ($input['primary_text'] ?? '')),
        'subtitle_text'    => trim((string) ($input['subtitle_text'] ?? '')),
        'finish'           => trim((string) ($input['finish'] ?? '')),
        'size'             => trim((string) ($input['size'] ?? '')),
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
