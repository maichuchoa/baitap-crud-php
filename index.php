<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$host = '127.0.0.1';
$db   = 'shop_canhan'; 
$user = 'root';        
$pass = '';            
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (\PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}

// Gọi các file class
require_once __DIR__ . '/src/Core/Auth.php'; // Thêm Auth
require_once __DIR__ . '/src/Repository/ProductRepository.php';
require_once __DIR__ . '/src/Controller/ProductController.php';
require_once __DIR__ . '/src/Controller/AuthController.php'; // Thêm AuthController

if (empty($_SESSION['csrf'])) { 
    $_SESSION['csrf'] = bin2hex(random_bytes(32)); 
}

$productRepo = new ProductRepository($pdo);
$productController = new ProductController($productRepo);
$authController = new AuthController($pdo); // Khởi tạo AuthController

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'login': $authController->login(); break;
    case 'logout': $authController->logout(); break;
    
    case 'create': 
        Auth::requireAdmin(); // Chặn nếu không phải admin
        $productController->create(); 
        break;
    case 'edit': 
        Auth::requireAdmin(); 
        $productController->edit(); 
        break;
    case 'delete': 
        Auth::requireAdmin(); 
        $productController->delete(); 
        break;
        
    default: $productController->index(); break;
}