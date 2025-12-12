<?php
    // app/controllers/DashboardController.php
    namespace App\controllers;

    use App\repositories\UserRepository;
    use App\repositories\MembershipRepository;
    use App\repositories\CertificateOrderRepository;

    class DashboardController
    {
        public function index()
        {
            // session_start();
            if (!isset($_SESSION['user_id'])) {
                header("Location: /login");
                exit;
            }

            $userRepo = new UserRepository();
            $membershipRepo = new MembershipRepository();
            $certificateRepo = new CertificateOrderRepository();

            $user = $userRepo->findById($_SESSION['user_id']);
            $membership = $membershipRepo->find($user->membership_id);

            // Fetch all certificates for this user
            $certificates = $certificateRepo->getByUserId($_SESSION['user_id']);

            // Sort newest first (assuming each order has created_at or id)
            usort($certificates, function($a, $b) {
                return $b['id'] <=> $a['id'];
            });

            require __DIR__ . '/../../views/dashboard/index.php';
        }
    }
