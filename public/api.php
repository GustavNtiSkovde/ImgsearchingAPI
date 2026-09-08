<?php
// filepath: /home/gustavjakobsson/ImgsearchingAPI/public/api.php

header('Content-Type: application/json');

require_once __DIR__ . '/../loadenv.php';
loadEnv(__DIR__ . '/../.env');

$accessKey = $_ENV['API_KEY'] ?? '';
$query = trim($_GET['q'] ?? '');

if (!$accessKey || !$query) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing API key or search query']);
    exit;
}

$params = http_build_query([
    'client_id' => $accessKey,
    'query' => $query,
    'per_page' => 20
]);

$url = "https://api.unsplash.com/search/photos?{$params}";

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ['Accept-Version: v1']
]);

$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false || $status >= 400) {
    http_response_code(500);
    echo json_encode(['error' => 'Unsplash request failed']);
    exit;
}

$unsplashData = json_decode($response, true);

$data = [
    'hits' => array_map(
        fn ($image) => [
            'webformatURL' => $image['urls']['regular'],
            'tags' => $image['alt_description'] ?? 'Unsplash image',
            'imageWidth' => $image['width'],
            'imageHeight' => $image['height'],
            'user' => $image['user']['name'] ?? 'Unknown'
        ],
        $unsplashData['results'] ?? []
    )
];

echo json_encode($data);