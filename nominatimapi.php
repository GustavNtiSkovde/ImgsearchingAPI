<?php
header('Content-Type: application/json');

function getLocationFromCoordinates(float $lat, float $lng): array { //Use float for lat and lang to allow decimals
    //Builds the Nominatim endpoint URL
    $endpoint = sprintf(
        'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=%f&lon=%f',
        $lat,
        $lng
    );

    //Initializes cURL session
    $ch = curl_init();

    //Set cURL options
    curl_setopt_array($ch, [
        CURLOPT_URL            => $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT      => 'MySchoolLeafletMapApp/1.0 (gustav.jakobsson@elev.ntig.se)', //Needed to not get blocked by nominatima
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_HTTPHEADER     => [
            'Accept-Language: en' //Requested lang to english
        ]
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); //getinfo func used to get data from the last URL data 

    if (curl_errno($ch)) {
        $errorMsg = curl_error($ch);
        curl_close($ch);
        return ['error' => 'cURL Error: ' . $errorMsg];
    }

    curl_close($ch);

    if ($httpCode !== 200) {
        return ['error' => 'API Error HTTP Status: ' . $httpCode];
    }

    // 4. Parse the JSON response
    $data = json_decode($response, true);
    $address = $data['address'] ?? [];

    // 5. Extract city name with fallback logic for smaller towns/villages
    $city = $address['city'] 
         ?? $address['town'] 
         ?? $address['village'] 
         ?? $address['municipality'] 
         ?? $address['county'] 
         ?? null;

    $country = $address['country'] ?? null;

    return [
        'success'      => true,
        'city'         => $city,
        'country'      => $country,
        'full_name'    => $data['display_name'] ?? '',
        'search_query' => trim(($city ?? '') . ' ' . ($country ?? ''))
    ];
}

$lat = filter_input(INPUT_GET, 'lat', FILTER_VALIDATE_FLOAT);
$lng = filter_input(INPUT_GET, 'lng', FILTER_VALIDATE_FLOAT);

//If the coords is right call function to get the city and country
if ($lat !== false && $lng !== false && $lat !== null && $lng !== null) {
    $result = getLocationFromCoordinates($lat, $lng);
    echo json_encode($result);
}