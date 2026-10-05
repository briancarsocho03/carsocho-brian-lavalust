<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

function handle_cors()
{
    $allowedOrigins = config_item('allow_origin') ?: '*';
    if (!is_array($allowedOrigins)) {
        $allowedOrigins = array_map('trim', explode(',', $allowedOrigins));
    }
    $requestOrigin = $_SERVER['HTTP_ORIGIN'] ?? '';

    if (in_array('*', $allowedOrigins, true)) {
        header('Access-Control-Allow-Origin: *');
    } elseif ($requestOrigin !== '' && in_array($requestOrigin, $allowedOrigins, true)) {
        header('Access-Control-Allow-Origin: ' . $requestOrigin);
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
