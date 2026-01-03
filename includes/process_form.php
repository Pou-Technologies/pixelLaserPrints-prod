<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recolecta los datos del formulario
    $firstName = isset($_POST['firstName']) ? htmlspecialchars(trim($_POST['firstName'])) : '';
    $lastName = isset($_POST['lastName']) ? htmlspecialchars(trim($_POST['lastName'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
    $service = isset($_POST['service']) ? htmlspecialchars(trim($_POST['service'])) : '';
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

    // ------------------------------------------------------------------
    // NUEVO: Recolectar el campo ID condicional
    // ------------------------------------------------------------------
    $projectID = '';
    if ($service === "Quote") {
        $projectID = isset($_POST['projectID']) ? htmlspecialchars(trim($_POST['projectID'])) : '';
    }
    // ------------------------------------------------------------------

    // Verifica que los campos obligatorios no estén vacíos
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($service) || empty($message)) {
        header("Location: ../views/contact.php?form_status=missing_fields");
        exit();
    }

    // Validar reCAPTCHA
    $captcha = $_POST['g-recaptcha-response'] ?? '';
    if (empty($captcha)) {
        header("Location: ../views/contact.php?form_status=captcha_missing");
        exit();
    }

    // Validar el token con la API de Google (código omitido por ser boilerplate)
    $secretKey = '6Lf2feQrAAAAANtR2l5amDaAyv6yYj7yJ9jGqCNs';
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        'secret' => $secretKey,
        'response' => $captcha,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        header("Location: ../views/contact.php?form_status=captcha_connection_error");
        exit();
    }

    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        header("Location: ../views/contact.php?form_status=captcha_error");
        exit();
    }

    // Procesar el formulario (enviar correo)
    $to = "sales@pixellaserprints.ca";

    // Check if we are in a QA environment (based on directory name OR subdomain)
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (strpos($host, 'qa404') !== false || strpos(__FILE__, 'pixelLaserPrints-qa') !== false) {
        $to = "test@poutechnologies.com";
    }

    $subject = "New message from the form";

    // Generar un boundary único
    $boundary = md5(time());

    // Headers generales
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    // Construir el cuerpo del mensaje de texto
    $messageBody = "First Name: $firstName\n";
    $messageBody .= "Last Name: $lastName\n";
    $messageBody .= "Email: $email\n";
    $messageBody .= "Phone: $phone\n";
    $messageBody .= "Service: $service\n";

    if ($service === "Quote" && !empty($projectID)) {
        $messageBody .= "Reference ID: $projectID\n";
    }

    $messageBody .= "Message:\n$message\n";

    // Parte texto del email
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= $messageBody . "\r\n";

    // Manejo del archivo adjunto
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $fileTmpName = $_FILES['attachment']['tmp_name'];
        $fileName = $_FILES['attachment']['name'];
        $fileType = $_FILES['attachment']['type'];

        // Leer el archivo y codificarlo
        $fileContent = file_get_contents($fileTmpName);
        $encodedContent = chunk_split(base64_encode($fileContent));

        // Parte adjunta del email
        $body .= "--$boundary\r\n";
        $body .= "Content-Type: $fileType; name=\"$fileName\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= $encodedContent . "\r\n";
    }

    // Cerrar el boundary
    $body .= "--$boundary--";

    // Enviar el correo
    if (mail($to, $subject, $body, $headers)) {
        header("Location: ../views/contact.php?form_status=success");
    } else {
        header("Location: ../views/contact.php?form_status=mail_error");
    }
    exit();
} else {
    // Si no es una solicitud POST, redirige al formulario
    header("Location: ../views/contact.php");
    exit();
}
?>