<?php
// public/index.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

use App\core\Env;
use App\core\Router;
use App\controllers\AuthController;
use App\controllers\CertificateController;
use App\controllers\DashboardController;
use App\controllers\CheckoutController;
use App\controllers\ProductController;
use App\controllers\CartController;
use App\controllers\AdminController;

require __DIR__ . '/../vendor/autoload.php';

// Load environment
Env::load(__DIR__ . '/../.env.php');


// Simple router
$router = new Router();

// Web pages
$router->get('/', [CertificateController::class, 'index']);        // product listings
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->post('/checkout', [CheckoutController::class, 'startCheckout']);
$router->post('/webhook/shopify', [CheckoutController::class, 'webhook']);

// Product listing
$router->get('/products', [ProductController::class, 'index']);

// Edit Certificate
$router->get('/editor/{id}', [CertificateController::class, 'show']);

// Cart
$router->post('/cart/add', [CartController::class, 'add']);
$router->get('/cart', [CartController::class, 'index']);

// Checkout (already exists from Phase 4, but now triggered from cart)
$router->post('/checkout', [CheckoutController::class, 'startCheckout']);


// --- ADMIN ROUTES (NEW SECTION) ---
// Note: These routes will use the AdminController's security gate.

// Admin Login Form (GET request) - Bypasses the security check
$router->get('/admin/login', [AdminController::class, 'showAdminLogin']);

// Admin Login Submission (POST request)
$router->post('/admin/login', [AdminController::class, 'adminLogin']);

// Admin Logout
$router->get('/admin/logout', [AuthController::class, 'logout']);

// Admin Dashboard (Protected Route)
$router->get('/admin/dashboard', [AdminController::class, 'showDashboard']);

// View All Users (Protected Route)
$router->get('/admin/users', [AdminController::class, 'viewUsers']);

// View All Products (Protected Route)
$router->get('/admin/products', [AdminController::class, 'viewProducts']);

// View All Memberships (Protected Route)
$router->get('/admin/memberships', [AdminController::class, 'viewMemberships']);

// View All Orders/Transactions (Protected Route)
$router->get('/admin/orders', [AdminController::class, 'viewOrders']);


// Dispatch
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
