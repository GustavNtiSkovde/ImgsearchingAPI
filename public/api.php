<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../loadenv.php';
loadEnv(__DIR__ . '/../.env');

$apiKey = $_ENV['API_KEY'] ?? '';
$query = urlencode($_GET['q'] ?? 'flower');

$url = "https://pixabay.com/api/?key={$apiKey}&q={$query}&image_type=photo";

$response = file_get_contents($url);

if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Pixabay request failed']);
    exit;
}

echo $response;