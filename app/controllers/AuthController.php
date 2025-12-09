<?php
    // app/controllers/AuthController.php
    namespace App\controllers;

    use App\repositories\UserRepository;
    use App\models\User;

    class AuthController
    {
        private UserRepository $users;

        public function __construct()
        {
            $this->users = new UserRepository();
            // session_start();
        }

        public function showRegister()
        {
            require __DIR__ . '/../../views/auth/register.php';
        }

        public function register()
        {
            $name  = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $pass  = $_POST['password'] ?? '';

            if ($this->users->findByEmail($email)) {
                echo "Email already exists!";
                return;
            }

            $user = new User([
                'name'     => $name,
                'email'    => $email,
                'password' => password_hash($pass, PASSWORD_DEFAULT),
                'membership_id' => null,
                'role'     => 'user',
            ]);

            $id = $this->users->create($user);
            $_SESSION['user_id'] = $id;

            header("Location: /");
        }

        public function showLogin()
        {
            require __DIR__ . '/../../views/auth/login.php';
        }

        public function login()
        {
            $email = $_POST['email'] ?? '';
            $pass  = $_POST['password'] ?? '';

            $user = $this->users->findByEmail($email);
            if (!$user || !password_verify($pass, $user->password)) {
                echo "Invalid credentials!";
                return;
            }

            $_SESSION['user_id'] = $user->id;
            header("Location: /");
        }

        public function logout()
        {
            session_destroy();
            header("Location: /login");
        }
    }
