<?php
// filepath: /home/gustavjakobsson/ImgsearchingAPI/public/api.php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . './loadenv.php';
loadEnv(__DIR__ . './.env');

$accessKey = $_ENV['API_KEY'] ?? getenv('API_KEY') ?: '';
$query = trim($_GET['q'] ?? '');

//Error handling if accessKey or the query is empty
if ($accessKey === '' || $query === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Missing API key or search query']);
    exit;
}

//Error handling if the curl_init extension is enabled
if (!function_exists('curl_init')) {
    http_response_code(503);
    echo json_encode(['error' => 'The server PHP cURL extension is not enabled']);
    exit;
}

//Api call with the key, search and how many we want
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

//Error handling if 
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

//Decode from JSON to text
$unsplashData = json_decode($response, true);

//Error handling for faulty array answer from unsplashed
if (!is_array($unsplashData)) {
    http_response_code(502);
    echo json_encode(['error' => 'Invalid Unsplash response']);
    exit;
}

$processedHits = [];

foreach ($unsplashData['results'] ?? [] as $image) {
    //Get the tags
    $tags = [];
    if (!empty($image['topic_submissions']) && is_array($image['topic_submissions'])) {
        $tags = array_keys($image['topic_submissions']);
    }

    //Extracts the location
    $location = $image['location']['name'] 
        ?? $image['user']['location'] 
        ?? null;

    //Skips imgs without tags or location
    if (empty($tags) || empty($location)) {
        continue;
    }

    $processedHits[] = [
        'webformatURL' => $image['urls']['regular'] ?? $image['urls']['small'] ?? '',
        'tags'         => implode(', ', $tags),
        'imageWidth'   => $image['width'] ?? 0,
        'imageHeight'  => $image['height'] ?? 0,
        'location'     => $location,
    ];
}

echo json_encode([
    'hits' => $processedHits
]);