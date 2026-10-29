<?php
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? 0;
    if ($id > 0) {
        deleteProduct($pdo, $id);
    }
}
// Chuyển hướng về trang chủ dù xóa thành công hay bị lỗi
header("Location: index.php");
exit;
?>