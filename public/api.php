<?php
// filepath: /home/gustavjakobsson/ImgsearchingAPI/public/api.php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../loadenv.php';
loadEnv(__DIR__ . '/../.env');

$accessKey = $_ENV['API_KEY'] ?? getenv('API_KEY') ?: '';
$query = trim($_GET['q'] ?? '');

if ($accessKey === '' || $query === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Missing API key or search query']);
    exit;
}

if (!function_exists('curl_init')) {
    http_response_code(503);
    echo json_encode(['error' => 'The server PHP cURL extension is not enabled']);
    exit;
}

$url = 'https://api.unsplash.com/search/photos?' . http_build_query([
    'client_id' => $accessKey,
    'query' => $query,
    'per_page' => 20,
]);

$ch = curl_init($url);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 15,
    CURLOPT_HTTPHEADER => ['Accept-Version: v1'],
]);

$response = curl_exec($ch);
$curlError = curl_error($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false) {
    http_response_code(502);
    echo json_encode(['error' => $curlError]);
    exit;
}

if ($status >= 400) {
    http_response_code($status);
    echo json_encode([
        'error' => 'Unsplash request failed',
        'status' => $status,
    ]);
    exit;
}

$unsplashData = json_decode($response, true);

if (!is_array($unsplashData)) {
    http_response_code(502);
    echo json_encode(['error' => 'Invalid Unsplash response']);
    exit;
}

echo json_encode([
    'hits' => array_map(
        function ($image) {
            return [
                'webformatURL' => $image['urls']['regular'],
                'tags' => $image['alt_description'] ?? 'Unsplash image',
                'imageWidth' => $image['width'],
                'imageHeight' => $image['height'],
            ];
        },
        $unsplashData['results'] ?? []
    ),
]);