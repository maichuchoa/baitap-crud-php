<?php
class AuthController {
    public function __construct(private PDO $pdo) {}

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                Auth::login($user);
                header("Location: index.php");
                exit;
            } else {
                $error = "Sai email hoặc mật khẩu.";
            }
        }
        require __DIR__ . '/../View/auth/login.php';
    }
    
    public function logout() {
        session_destroy();
        header("Location: index.php");
        exit;
    }
}