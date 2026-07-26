<?php
header('Content-Type: application/json');
require_once __DIR__ . '/PortalApiClient.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and validate it
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            "status" => "error",
            "message" => "Please enter a valid email address."
        ]);
        exit();
    }

    // Call Client Portal API (POST /api/v1/subscribers/add)
    $apiResult = PortalApiClient::subscribeNewsletter($email);

    // Also send email notification as backup/notification
    $to = "sales@pixellaserprints.ca";
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (strpos($host, 'qa404') !== false || strpos(__FILE__, 'pixelLaserPrints-qa') !== false) {
        $to = "test@poutechnologies.com";
    }

    $subject = "New Newsletter Subscription - Pixel Laser Prints";
    $headers = "From: no-reply@pixellaserprints.ca\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $messageBody = "You have a new subscriber to your newsletter!\n\n";
    $messageBody .= "Subscriber Email: $email\n";
    $messageBody .= "Date: " . date("Y-m-d H:i:s") . "\n";
    @mail($to, $subject, $messageBody, $headers);

    if ($apiResult['success']) {
        $msg = $apiResult['data']['message'] ?? "Thank you for subscribing to our newsletter!";
        echo json_encode([
            "status" => "success",
            "message" => $msg,
            "api_data" => $apiResult['data'] ?? null
        ]);
    } else {
        // If API fails but email sent, or return error description
        $errorMsg = $apiResult['data']['message'] ?? $apiResult['error'] ?? "Failed to submit subscription. Please try again later.";
        if (isset($apiResult['raw_response'])) {
            $errorMsg .= " (HTTP: " . ($apiResult['http_code'] ?? 'N/A') . ") | Raw Response: " . substr(strip_tags($apiResult['raw_response']), 0, 300);
        }
        echo json_encode([
            "status" => "error",
            "message" => $errorMsg
        ]);
    }
    exit();
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode([
        "status" => "error",
        "message" => "Method Not Allowed"
    ]);
    exit();
}
