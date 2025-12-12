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

        if (isset($_POST['product_id'])) {
            $_SESSION['cart'][] = [
                'type' => 'certificate',
                'product_id' => $_POST['product_id'],
                'awardee_name' => $_POST['awardee_name'] ?? '',
            ];
        }

        if (isset($_POST['membership_id'])) {
            $_SESSION['cart'][] = [
                'type' => 'membership',
                'membership_id' => $_POST['membership_id'],
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
            $type = $item['type'] ?? null;

            if ($type === 'certificate') {
                $certificate = \App\models\Certificate::find((int)$item['product_id']);
                if ($certificate) {
                    $cartWithDetails[] = [
                        'type'         => 'certificate',
                        'title'        => $certificate->title,
                        'description'  => $certificate->description,
                        'image'        => $certificate->image,
                        'price'        => $certificate->price,
                        'awardee_name' => $item['awardee_name'] ?? '',
                    ];
                }
            } elseif ($type === 'membership') {
                $membership = \App\models\Membership::find((int)$item['membership_id']);
                if ($membership) {
                    $cartWithDetails[] = [
                        'type'        => 'membership',
                        'title'       => $membership->name,
                        'description' => $membership->description,
                        'price'       => $membership->price,
                        'download_limit' => $membership->download_limit,
                        'priority_support' => $membership->priority_support,
                    ];
                }
            }
        }

        include __DIR__ . '/../../views/cart/index.php';
    }

    public function remove()
    {
        $index = $_POST['index'] ?? null;

        if ($index !== null && isset($_SESSION['cart'][$index])) {
            unset($_SESSION['cart'][$index]);
            // Reindex the array so keys are sequential again
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }

        header("Location: /cart");
        exit;
    }

}
