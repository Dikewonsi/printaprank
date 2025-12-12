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
             $certificate = \App\models\Certificate::find((int)$id);
            if (!$certificate) {
                echo "Certificate not found.";
                return;
            }
            include __DIR__ . '/../../views/certificates/show.php';
        } 

        public function download()
        {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                http_response_code(400);
                echo "Missing certificate ID.";
                exit;
            }

            // Find last order in session
            $items = $_SESSION['last_order']['items'] ?? [];
            $item = array_filter($items, fn($i) => $i['type'] === 'certificate' && $i['id'] == $id);
            $item = reset($item);

            if (!$item || empty($item['file_name'])) {
                http_response_code(404);
                echo "Certificate not found.";
                exit;
            }

            $filePath = __DIR__ . "/../../storage/certificates/" . $item['file_name'];
            if (!file_exists($filePath)) {
                http_response_code(404);
                echo "File not found.";
                exit;
            }

            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        }
    }
