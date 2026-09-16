<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/loadenv.php';
loadEnv(__DIR__ . '/.env');

$accessKey = $_ENV['API_KEY'] ?? getenv('API_KEY') ?: '';
$query = trim($_GET['q'] ?? '');
$page = trim($_GET['page'] ?? 1);

// The image ID is only used for follow-up requests after a card is clicked.
$imageId = trim($_GET['id'] ?? '');
$getStats = filter_var($_GET['stats'] ?? false, FILTER_VALIDATE_BOOLEAN);
$getRandom = filter_var($_GET['random'] ?? false, FILTER_VALIDATE_BOOLEAN);

//Error handling if accessKey or the query is empty
if ($accessKey === '' || ($query === '' && $imageId === '' && !$getRandom)) {
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

//Use the search endpoint for the grid and detail/statistics endpoints for clicked images.
if ($imageId !== '') {
    $endpoint = $getStats ? '/statistics' : '';
    $url = 'https://api.unsplash.com/photos/' . rawurlencode($imageId) . $endpoint . '?' . http_build_query([
        'client_id' => $accessKey,
    ]);
} elseif ($getRandom) {
    $url = 'https://api.unsplash.com/photos/random?' . http_build_query([
        'client_id' => $accessKey,
        'count' => 30,
    ]);
} else {
    $url = 'https://api.unsplash.com/search/photos?' . http_build_query([
        'client_id' => $accessKey,
        'query' => $query,
        'page' => $page,
        'per_page' => 30,
    ]);
}

$ch = curl_init($url); //_init to start a new curl session

curl_setopt_array($ch, [ // setopt_array Curl options
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 15,
    CURLOPT_HTTPHEADER => ['Accept-Version: v1'],
]);

$response = curl_exec($ch); //Exec used to execute configured curl session
$curlError = curl_error($ch); //Returns a text string latest error from the curl session
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE); //Reads status codes from server 200 if success for example
curl_close($ch); //Close the curl session

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

if ($getStats) {
    //Return stats
    echo json_encode(['stats' => $unsplashData]);
    exit;
}

//List for imgs
$processedHits = [];

$images = $imageId !== ''
    ? [$unsplashData]
    : ($getRandom ? $unsplashData : ($unsplashData['results'] ?? []));

foreach ($images as $image) {
    //Get the tags
    $tags = [];
    if (!empty($image['topic_submissions']) && is_array($image['topic_submissions'])) {
        $tags = array_keys($image['topic_submissions']);
    }

    //Prefer the photo location, then use the photographer's profile location as a fallback.
    $photoLocation = $image['location'] ?? [];
    $location = trim($photoLocation['name'] ?? '') ?: trim(implode(', ', array_filter([
        $photoLocation['city'] ?? null,
        $photoLocation['country'] ?? null, 
    ]))) ?: trim($image['user']['location'] ?? '');

    //Skip images without tags or any usable location.
    if (empty($tags) || $location === '') {
        continue;
    }
    $processedHits[] = [
        'ID'           => $image['id'] ?? 0,
        'webformatURL' => $image['urls']['regular'] ?? $image['urls']['small'] ?? '',
        'tags'         => implode(', ', $tags),
        'imageWidth'   => $image['width'] ?? 0,
        'imageHeight'  => $image['height'] ?? 0,
        'location'     => $location,
        //Unsplash return lat and long in 2 different strings so needed 2 "varaibles"
        'latitude'     => $image['location']['position']['latitude'] ?? null,
        'longitude'    => $image['location']['position']['longitude'] ?? null,
    ];
}

echo json_encode([
    'hits' => $processedHits
]);