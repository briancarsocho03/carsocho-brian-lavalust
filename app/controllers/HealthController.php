<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class HealthController extends Controller
{
    public function info()
    {
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode([
            'success' => true,
            'name' => 'Product Management API',
            'description' => 'LavaLust REST API for product management with JWT authentication',
            'version' => '1.0.0',
            'frontend' => 'https://carsocho-brian-lavalust-static-site.onrender.com',
            'endpoints' => [
                'POST   /api/auth/login' => 'Authenticate and receive JWT tokens',
                'POST   /api/auth/logout' => 'Revoke the refresh token',
                'POST   /api/auth/refresh' => 'Refresh the access token',
                'GET    /api/health' => 'Check API and database health',
                'GET    /api/products' => 'List all products [Auth Required]',
                'POST   /api/products' => 'Create a product [Auth Required]',
                'PUT    /api/products/{id}' => 'Update a product [Auth Required]',
                'PATCH  /api/products/{id}' => 'Partially update a product [Auth Required]',
                'DELETE /api/products/{id}' => 'Delete a product [Auth Required]',
            ],
            'note' => 'Product endpoints require a valid JWT access token in the Authorization header.',
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

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
