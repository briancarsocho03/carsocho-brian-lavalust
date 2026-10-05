<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiController extends Controller
{
    private $api;
    private $db;

    public function __construct()
    {
        parent::__construct();

        header('Content-Type: application/json; charset=utf-8');
        $this->call->library('api');
        $this->call->database();

        $lava = lava_instance();
        $this->api = $lava->properties['api'];
        $this->db = $lava->properties['db'];
    }

    public function options_preflight()
    {
        http_response_code(204);
        exit;
    }

    public function register()
    {
        $this->api->respond_error('Registration is disabled. Only the admin account can log in.', 403);
    }

    public function login()
    {
        $this->api->rate_limit('login', 10, 60);
        $body = $this->json_body();
        $username = trim((string) ($body['username'] ?? ''));
        $password = (string) ($body['password'] ?? '');

        if ($username === '' || $password === '') {
            $this->api->respond_error('Username and password are required.', 422);
        }

        $user = $this->db->raw(
            'SELECT id, username, email, password, role, is_active FROM users WHERE username = ? LIMIT 1',
            [$username]
        )->fetch(PDO::FETCH_ASSOC);

        if (!$user || strtolower((string) $user['username']) !== 'admin' || (int) $user['is_active'] !== 1 || !password_verify($password, $user['password'])) {
            $this->api->respond_error('Invalid username or password.', 401);
        }

        $tokens = $this->api->issue_tokens([
            'id' => $user['id'],
            'role' => $user['role'],
        ]);

        unset($user['password'], $user['is_active']);

        $this->api->respond([
            'message' => 'Login successful.',
            'user' => $user,
            'tokens' => $tokens,
        ]);
    }

    public function refresh()
    {
        $body = $this->json_body();
        $refreshToken = (string) ($body['refresh_token'] ?? '');

        if ($refreshToken === '') {
            $this->api->respond_error('Refresh token is required.', 422);
        }

        $this->api->refresh_access_token($refreshToken);
    }

    public function logout()
    {
        $body = $this->json_body();
        $refreshToken = (string) ($body['refresh_token'] ?? '');

        if ($refreshToken !== '') {
            $this->api->revoke_refresh_token($refreshToken);
        }

        $this->api->respond(['message' => 'Logged out successfully.']);
    }

    public function products()
    {
        $products = $this->db->raw(
            'SELECT id, product_name, description, price, quantity, created_at FROM products ORDER BY id DESC'
        )->fetchAll(PDO::FETCH_ASSOC);

        $this->api->respond(['products' => $products]);
    }

    public function create_product()
    {
        $product = $this->validated_product($this->json_body());

        $this->db->table('products')->insert($product);
        $id = $this->db->last_id();
        $created = $this->find_product($id);

        $this->api->respond(['product' => $created], 201);
    }

    public function update_product($id)
    {
        $id = $this->validated_id($id);
        $product = $this->validated_product($this->json_body());

        $existing = $this->find_product($id);

        if (!$existing) {
            $this->api->respond_error('Product not found.', 404);
        }

        $this->db->table('products')->where('id', $id)->update($product);

        $this->api->respond(['product' => $this->find_product($id)]);
    }

    public function delete_product($id)
    {
        $id = $this->validated_id($id);
        $deleted = $this->db->raw('DELETE FROM products WHERE id = ?', [$id])->rowCount();

        if ($deleted === 0) {
            $this->api->respond_error('Product not found.', 404);
        }

        $this->api->respond(['message' => 'Product deleted successfully.']);
    }

    private function json_body()
    {
        $body = json_decode(file_get_contents('php://input'), true);

        if (!is_array($body)) {
            $this->api->respond_error('Request body must be valid JSON.', 400);
        }

        return $body;
    }

    private function validated_product(array $body)
    {
        $name = trim((string) ($body['product_name'] ?? ''));
        $description = trim((string) ($body['description'] ?? ''));
        $price = $body['price'] ?? null;
        $quantity = $body['quantity'] ?? null;

        if ($name === '' || strlen($name) > 100) {
            $this->api->respond_error('Product name is required and must be at most 100 characters.', 422);
        }

        if (!is_numeric($price) || (float) $price < 0 || (float) $price > 99999999.99) {
            $this->api->respond_error('Price must be a number from 0 to 99999999.99.', 422);
        }

        if (filter_var($quantity, FILTER_VALIDATE_INT) === false || (int) $quantity < 0) {
            $this->api->respond_error('Quantity must be a non-negative whole number.', 422);
        }

        return [
            'product_name' => $name,
            'description' => $description,
            'price' => number_format((float) $price, 2, '.', ''),
            'quantity' => (int) $quantity,
        ];
    }

    private function validated_id($id)
    {
        if (filter_var($id, FILTER_VALIDATE_INT) === false || (int) $id < 1) {
            $this->api->respond_error('Product ID must be a positive integer.', 422);
        }

        return (int) $id;
    }

    private function find_product($id)
    {
        return $this->db->raw(
            'SELECT id, product_name, description, price, quantity, created_at FROM products WHERE id = ? LIMIT 1',
            [$id]
        )->fetch(PDO::FETCH_ASSOC);
    }
}
