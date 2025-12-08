<?php
// public/index.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\core\Env;
use App\core\Router;
use App\controllers\AuthController;
use App\controllers\CertificateController;
use App\controllers\DashboardController;

require __DIR__ . '/../vendor/autoload.php';

// Load environment
Env::load(__DIR__ . '/../.env.php');

// // Test DB connection
// $pdo = \App\core\Database::connection();
// echo "DB OK"; // uncomment to see


// Simple router
$router = new Router();

// Web pages
$router->get('/', [CertificateController::class, 'index']);        // product listing
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/dashboard', [DashboardController::class, 'index']);

// Minimal API test endpoint (for React editor later)
$router->get('/api/ping', function () {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'API is working']);
});

// Dispatch
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
