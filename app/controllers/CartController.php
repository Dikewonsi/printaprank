<?php
namespace App\controllers;

use App\models\Certificate;

class CartController
{

    public function add()
    {
        // Ensure session cart exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Get product ID and awardee name from POST
        $productId   = $_POST['product_id'] ?? null;
        $awardeeName = $_POST['awardee_name'] ?? null;

        if ($productId && $awardeeName) {
            $_SESSION['cart'][] = [
                'product_id'   => $productId,
                'awardee_name' => $awardeeName,
            ];
        }

        // Redirect to cart page
        header("Location: /cart");
        exit;
    }

    public function index()
    {
        // unset($_SESSION['cart']);
        
        $cart = $_SESSION['cart'] ?? [];

        // Fetch product details for each cart item
        $cartWithDetails = [];
        foreach ($cart as $item) {
            $product = Certificate::find($item['product_id']);
            if ($product) {
                $cartWithDetails[] = [
                    'id'           => $product['id'],
                    'title'        => $product['title'],
                    'description'  => $product['description'],
                    'price'        => $product['price'],
                    'image'        => $product['image'],
                    'awardee_name' => $item['awardee_name'],
                ];
            }
        }
        include __DIR__ . '/../../views/cart/index.php';
    }
}
