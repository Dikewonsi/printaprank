<?php
// app/controllers/AdminController.php
namespace App\controllers;

use App\repositories\UserRepository;
use App\repositories\CertificateRepository; // Assuming you have or will create this
use App\repositories\MembershipRepository;
use App\repositories\TransactionRepository; // Assuming this handles orders

class AdminController
{
    private UserRepository $userRepository;
    private CertificateRepository $certificateRepository;
    private MembershipRepository $membershipRepository;
    private TransactionRepository $transactionRepository;

    public function __construct($method = null)
    {
        // Initialize repositories
        $this->userRepository = new UserRepository();
        $this->certificateRepository = new CertificateRepository();
        $this->membershipRepository = new MembershipRepository();
        $this->transactionRepository = new TransactionRepository();
        
        // ALLOW the login functions to run without the check
        if ($method === 'showAdminLogin' || $method === 'adminLogin') {
            return; // Skip the security check
        }

        if (!isset($_SESSION['user_id']) || 
        (isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin')) 
        {   
            // 1. Stop execution immediately.
            echo "403 Forbidden: You do not have permission to access this page.";
            
            // 2. Redirect them to the main page or login page.
            // header('Location: /login'); 
            
            exit(); // Crucial: Stop all code execution!
        }
    }

    // --- Admin Dashboard (Main Page) ---

    public function showDashboard()
    {
        // Example: Fetch summary stats for the dashboard view
        // $totalUsers = $this->userRepository->countAll();
        // $recentOrders = $this->transactionRepository->getRecentOrders(10);
        
        // require the view
        require __DIR__ . '/../../views/admin/dashboard.php';
    }

    // --- User Management ---

    public function viewUsers()
    {
        // Fetch all user objects from the database
        $users = $this->userRepository->findAll();
        require __DIR__ . '/../../views/admin/users.php';
    }

    // --- Product Management ---

    public function viewProducts()
    {
        // 1. Fetch all certificates using the repository's 'all()' method
        $certificates = $this->certificateRepository->all(); 
        
        // 2. We will use the variable name $products in the view
        $products = $certificates;
        
        require __DIR__ . '/../../views/admin/products.php';
    }

    // --- Membership Management ---

    public function viewMemberships()
    {
        $memberships = $this->membershipRepository->all();
        require __DIR__ . '/../../views/admin/memberships.php';
    }

    // --- Order/Transaction Management ---

    public function viewOrders()
    {
        $orders = $this->transactionRepository->findAllOrders();
        require __DIR__ . '/../../views/admin/orders.php';
    }

    // --- Admin Login (Optional but Recommended) ---

    public function showAdminLogin()
    {
        require __DIR__ . '/../../views/admin/login.php';
    }

    public function adminLogin()
    {
        $email = $_POST['email'] ?? '';
        $pass  = $_POST['password'] ?? '';

        $user = $this->userRepository->findByEmail($email);
        
        // 1. Check credentials
        if (!$user || !password_verify($pass, $user->password)) {
            // In a real application, redirect back with an error message
            echo "Invalid credentials for Admin."; 
            return;
        }

        // 2. CRITICAL ACCESS CONTROL CHECK (A01:2021)
        if ($user->role !== 'admin') {
            echo "Access Denied: Account is not an administrator.";
            return;
        }

        // 3. Success: Set session and redirect
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_role'] = $user->role;
        
        header("Location: /admin/dashboard"); // Redirect to the new dashboard
        exit();
    }

}