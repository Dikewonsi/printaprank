<?php
    // app/controllers/DashboardController.php
    namespace App\controllers;

    use App\repositories\UserRepository;
    use App\repositories\MembershipRepository;

    class DashboardController
    {
        public function index()
        {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                header("Location: /login");
                exit;
            }

            $userRepo = new UserRepository();
            $membershipRepo = new MembershipRepository();

            $user = $userRepo->findById($_SESSION['user_id']);
            $membership = $membershipRepo->find($user->membership_id);

            require __DIR__ . '/../../views/dashboard/index.php';
        }
    }
