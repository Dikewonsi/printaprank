<?php
    // app/controllers/MembershipController.php
    namespace App\controllers;
    
    use App\models\Membership;

    class MembershipController
    {
        public function index()
        {
            // session_start();
            if (!isset($_SESSION['user_id'])) {
                header("Location: /login");
                exit;
            }

            $memberships = Membership::all();
            include __DIR__ . '/../../views/memberships/index.php';
        }
    }
