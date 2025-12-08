<?php
namespace App\controllers;

use App\repositories\CertificateRepository;

class ProductController
{
    private CertificateRepository $certificates;

    public function __construct()
    {
        $this->certificates = new CertificateRepository();
    }

    public function index()
    {
        $certificates = $this->certificates->all();
        include __DIR__ . '/../../views/products/index.php';
    }
}
