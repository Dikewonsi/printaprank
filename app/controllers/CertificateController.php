<?php
    // app/controllers/AuthController.php
    namespace App\controllers;
    
    use App\models\Certificate;

    class CertificateController
    {
        public function index()
        {
            $templates = Certificate::all();
            include __DIR__ . '/../../views/certificates/index.php';
        }

        public function show($id)
        {
            $template = Certificate::find((int)$id);
            if (!$template) {
                http_response_code(404);
                echo "Certificate not found";
                return;
            }
            include __DIR__ . '/../../views/certificates/show.php';
        } 
    }
