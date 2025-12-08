<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

use App\core\Env;
use App\controllers\CheckoutController;

Env::load(__DIR__ . '/../.env.php');

// Fake webhook payload
$data = json_encode([
    "id" => 987654321,
    "email" => "testuser@example.com",
    "customer" => [
        "id" => 5,
        "first_name" => "Test",
        "last_name" => "User",
        "email" => "testuser@example.com"
    ],
    "line_items" => [
        [
            "id" => 111,
            "variant_id" => 2,
            "title" => "Pro Membership",
            "quantity" => 1,
            "price" => "9.99"
        ]
    ],
    "total_price" => "9.99",
    "financial_status" => "paid"
]);

// Use dummy secret
$secret = Env::get('SHOPIFY_API_SECRET');
$signature = base64_encode(hash_hmac('sha256', $data, $secret, true));

// Simulate webhook header
$_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'] = $signature;

// Pass payload directly for CLI testing
$GLOBALS['TEST_WEBHOOK_DATA'] = $data;

$controller = new CheckoutController();
$controller->webhook();

echo "Webhook test completed.\n";
