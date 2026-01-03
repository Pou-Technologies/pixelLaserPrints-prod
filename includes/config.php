<?php
// Contact Information
define('COMPANY_NAME', 'Pixel Laser Prints');
define('COMPANY_PHONE', '902-388-0416');
define('COMPANY_PHONE_TEL', '+19023880416'); // Formato para enlaces tel:
define('COMPANY_EMAIL', 'sales@pixellaserprints.ca');

// Address
define('COMPANY_ADDRESS', '180 Belvedere Ave');
define('COMPANY_CITY', 'Charlottetown');
define('COMPANY_PROVINCE', 'PEI');
define('COMPANY_POSTAL_CODE', 'C1A 2Z1');
define('COMPANY_COUNTRY', 'Canada');
define('COMPANY_FULL_ADDRESS', COMPANY_ADDRESS . ', ' . COMPANY_CITY . ', ' . COMPANY_PROVINCE . ', ' . COMPANY_POSTAL_CODE . ', ' . COMPANY_COUNTRY);

// Social Media URLs
define('SOCIAL_FACEBOOK', 'https://www.facebook.com/people/Pixel-Laser-Prints/61571892844993/?mibextid=wwXIfr');
define('SOCIAL_TIKTOK', 'https://www.tiktok.com/@pixel.laser.print?_t=ZS-90TZTOkr3zz&_r=1');
define('SOCIAL_INSTAGRAM', 'https://www.instagram.com/pixelcharlottetown/');

// Base URL configuration
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];

// Detect Environment
if (strpos($host, 'localhost') !== false) {
    // Local Development
    define('BASE_URL', '/Pou-Technologies-Projects/Pixel%20Laser%20Prints/pixelLaserPrints-qa');
} else {
    // Production / QA (Subdomain or Root)
    define('BASE_URL', '');
}
?>