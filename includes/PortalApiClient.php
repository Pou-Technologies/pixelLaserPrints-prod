<?php

class PortalApiClient {
    private static $apiUrl = null;
    private static $apiKey = null;

    /**
     * Load environment variables from .env file
     */
    public static function loadEnv() {
        if (self::$apiUrl !== null && self::$apiKey !== null) {
            return;
        }

        $envFile = dirname(__DIR__) . '/.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line) || strpos($line, '#') === 0) {
                    continue;
                }
                if (strpos($line, '=') !== false) {
                    list($name, $value) = explode('=', $line, 2);
                    $name = trim($name);
                    $value = trim($value, " \t\n\r\0\x0B\"'");
                    $_ENV[$name] = $value;
                    putenv("{$name}={$value}");
                }
            }
        }

        self::$apiUrl = $_ENV['CLIENT_PORTAL_API_URL'] ?? getenv('CLIENT_PORTAL_API_URL') ?: 'https://www.poutechnologies.com/api/v1';
        self::$apiKey = $_ENV['CLIENT_PORTAL_API_KEY'] ?? getenv('CLIENT_PORTAL_API_KEY') ?: '';
    }

    /**
     * Perform HTTP Request to Client Portal API
     *
     * @param string $method GET, POST, etc.
     * @param string $endpoint e.g. /content/hero or /blog/posts
     * @param array|null $data
     * @return array
     */
    public static function request($method, $endpoint, $data = null) {
        self::loadEnv();

        if (empty(self::$apiUrl) || empty(self::$apiKey)) {
            return [
                'success' => false,
                'error' => 'API URL or API Key is missing in environment configuration.'
            ];
        }

        // Normalize endpoint path
        $cleanEndpoint = preg_replace('/^\/?(api\/v1\/)?/', '', $endpoint);
        $baseUrl = rtrim(self::$apiUrl, '/');
        $url = $baseUrl . '/' . $cleanEndpoint;

        $ch = curl_init();

        $headers = [
            'X-API-Key: ' . self::$apiKey,
            'Accept: application/json',
            'Content-Type: application/json'
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // For local development on WAMP, disable SSL verification if self-signed
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        } elseif (strtoupper($method) === 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
            curl_setopt($ch, CURLOPT_URL, $url);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            return [
                'success' => false,
                'error' => 'cURL Error: ' . $curlError
            ];
        }

        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'http_code' => $httpCode,
                'raw_response' => $response,
                'error' => 'Invalid JSON response from Portal API.'
            ];
        }

        return [
            'success' => ($httpCode >= 200 && $httpCode < 300),
            'http_code' => $httpCode,
            'data' => $decoded
        ];
    }

    /**
     * GET /content/hero
     */
    public static function getHeroContent() {
        return self::request('GET', '/content/hero');
    }

    /**
     * GET /blog/posts
     */
    public static function getBlogPosts() {
        return self::request('GET', '/blog/posts');
    }

    /**
     * GET /blog/posts/{slug}
     */
    public static function getBlogPostBySlug($slug) {
        return self::request('GET', '/blog/posts/' . urlencode($slug));
    }

    public static function subscribeNewsletter($email) {
        return self::request('POST', '/subscribers/add', [
            'email' => $email,
            'name' => 'Subscriber'
        ]);
    }

    /**
     * POST /orders/create
     */
    public static function createOrder($orderData) {
        return self::request('POST', '/orders/create', $orderData);
    }
}
