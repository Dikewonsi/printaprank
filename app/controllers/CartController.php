<?php
namespace App\controllers;

use App\repositories\CertificateRepository;

class CartController
{
    private CertificateRepository $certificates;

    public function __construct()
    {
        $this->certificates = new CertificateRepository();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function add()
    {
        $id = (int)$_POST['certificate_id'];
        $customName = $_POST['custom_name'] ?? '';

        $certificate = $this->certificates->find($id);
        if ($certificate) {
            $_SESSION['cart'][] = [
                'id'          => $certificate->id,
                'title'       => $certificate->title,
                'price'       => $certificate->price,
                'custom_name' => $customName,
            ];
        }

        header("Location: /cart");
    }

    public function index()
    {
        // unset($_SESSION['cart']);

        $cart = $_SESSION['cart'];
        include __DIR__ . '/../../views/cart/index.php';
    }
}
