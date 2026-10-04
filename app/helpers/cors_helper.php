<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

function handle_cors()
{
    $allowedOrigin = config_item('allow_origin') ?: '*';
    $requestOrigin = $_SERVER['HTTP_ORIGIN'] ?? '';

    if ($allowedOrigin === '*') {
        header('Access-Control-Allow-Origin: *');
    } elseif ($requestOrigin !== '' && hash_equals($allowedOrigin, $requestOrigin)) {
        header('Access-Control-Allow-Origin: ' . $allowedOrigin);
        header('Vary: Origin');
    }

    header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Access-Control-Max-Age: 86400');

    if (strtoupper($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
        http_response_code(204);
        exit;
    }
}
