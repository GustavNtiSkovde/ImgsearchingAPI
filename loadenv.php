<?php
function loadEnv($path) { //Function to parse the env bc php dosnt have access to it without using a pacakge
    if (!file_exists($path)) return; //Stops if there is no file path
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) { //Parse through each line of the file
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}