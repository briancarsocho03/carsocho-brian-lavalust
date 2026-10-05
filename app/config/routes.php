<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/
/** @var object $router **/

$router->get('/', 'AuthController::login');

$router->get('/student', 'StudentController::index');

$router->get('/student/profile', 'StudentController::profile')
    ->middleware('StudentMiddleware');

$router->get('/users', 'UsersController::index');

$router->get('/login', 'AuthController::login');

$router->post('/login/authenticate', 'AuthController::authenticate');

$router->get('/logout', 'AuthController::logout');

$router->post('/api/auth/register', 'ApiController::register');
$router->post('/api/auth/login', 'ApiController::login');
$router->post('/api/auth/refresh', 'ApiController::refresh');
$router->post('/api/auth/logout', 'ApiController::logout');

$router->get('/api/health', 'HealthController::index');
$router->options('/api/health', 'HealthController::index');

$router->options('/api/auth/register', 'ApiController::options_preflight');
$router->options('/api/auth/login', 'ApiController::options_preflight');
$router->options('/api/auth/refresh', 'ApiController::options_preflight');
$router->options('/api/auth/logout', 'ApiController::options_preflight');

$router->get('/api/products', 'ApiController::products')
       ->middleware('jwt');

$router->post('/api/products', 'ApiController::create_product')
       ->middleware('jwt');

$router->options('/api/products', 'ApiController::options_preflight');

$router->put('/api/products/{id}', 'ApiController::update_product')
       ->middleware('jwt');

$router->patch('/api/products/{id}', 'ApiController::update_product')
       ->middleware('jwt');

$router->delete('/api/products/{id}', 'ApiController::delete_product')
       ->middleware('jwt');

$router->options('/api/products/{id}', 'ApiController::options_preflight');

$router->get('/products', 'ProductController::index')
       ->middleware('auth');

$router->get('/products/create', 'ProductController::create')
       ->middleware('auth');

$router->post('/products/store', 'ProductController::store')
       ->middleware('auth');

$router->get('/products/edit/{id}', 'ProductController::edit')
       ->middleware('auth');

$router->post('/products/update/{id}', 'ProductController::update')
       ->middleware('auth');

$router->get('/products/delete/{id}', 'ProductController::delete')
       ->middleware('auth');

if (PHP_SAPI === 'cli' || getenv('APP_ENV') !== 'production') {
    $router->get('create-migration/{migration_class}', 'MigrationController::create_migration');
    $router->get('migrate', 'MigrationController::migrate');
    $router->get('rollback', 'MigrationController::rollback');
    $router->get('rollback-all', 'MigrationController::rollback_all');
    $router->get('refresh', 'MigrationController::refresh');
    $router->get('status', 'MigrationController::status');
}
