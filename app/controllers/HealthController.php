<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class HealthController extends Controller
{
    public function index()
    {
        handle_cors();
        header('Content-Type: application/json; charset=utf-8');

        try {
            $db = $this->call->database();
            $db->raw('SELECT 1')->fetchColumn();

            http_response_code(200);
            echo json_encode([
                'status' => 'ok',
                'service' => 'LavaLust API',
                'database' => 'connected',
            ]);
        } catch (Throwable $exception) {
            error_log('API health check failed: ' . $exception->getMessage());
            http_response_code(503);
            echo json_encode([
                'status' => 'error',
                'service' => 'LavaLust API',
                'database' => 'unavailable',
                'message' => 'Check the backend service logs.',
            ]);
        }
    }
}
