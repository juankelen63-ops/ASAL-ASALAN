<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new User($db);
    }

    public function login() {
        if (isset($_SESSION['user_id'])) {
            $this->redirectByRole();
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByUsername($username);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nama']    = $user['nama'];
                $_SESSION['role']    = $user['role'];

                $this->redirectByRole();
            } else {
                $error = "Username atau password salah!";
            }
        }
        require __DIR__ . '/../views/auth/login.php';
    }

    private function redirectByRole() {
        if ($_SESSION['role'] === 'admin') {
            header("Location: index.php?action=dashboard");
        } else {
            header("Location: index.php?action=track");
        }
        exit;
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}