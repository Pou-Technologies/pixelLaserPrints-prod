<?php
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

    // Set recipient
    $to = "sales@pixellaserprints.ca";

    // Check if we are in a QA environment (based on directory name OR subdomain)
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (strpos($host, 'qa404') !== false || strpos(__FILE__, 'pixelLaserPrints-qa') !== false) {
        $to = "test@poutechnologies.com";
    }

    $subject = "New Newsletter Subscription - Pixel Laser Prints";
    
    // Headers
    $headers = "From: no-reply@pixellaserprints.ca\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Message body
    $messageBody = "You have a new subscriber to your newsletter!\n\n";
    $messageBody .= "Subscriber Email: $email\n";
    $messageBody .= "Date: " . date("Y-m-d H:i:s") . "\n";

    // Send the email
    if (mail($to, $subject, $messageBody, $headers)) {
        echo json_encode([
            "status" => "success",
            "message" => "Thank you for subscribing to our newsletter!"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to submit subscription. Please try again later."
        ]);
    }
    exit();
} else {
    // If not POST, deny access
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode([
        "status" => "error",
        "message" => "Method Not Allowed"
    ]);
    exit();
}
?>
