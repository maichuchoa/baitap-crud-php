<?php
require_once 'includes/functions.php';
$id = $_GET['id'] ?? 0;
$product = getProductById($pdo, $id);

if (!$product) {
    die("Sản phẩm không tồn tại.");
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $description = trim($_POST['description']);

    if (empty($name)) $errors[] = "Tên không được để trống.";
    if (!is_numeric($price) || $price < 0) $errors[] = "Giá phải là số dương.";

    if (empty($errors)) {
        updateProduct($pdo, $id, $name, $price, $description);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><title>Sửa Sản Phẩm</title></head>
<body>
    <h2>Sửa Sản Phẩm</h2>
    <?php foreach ($errors as $e): ?>
        <p style="color:red;"><?= $e ?></p>
    <?php endforeach; ?>
    <form method="POST">
        <p>Tên: <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>"></p>
        <p>Giá: <input type="text" name="price" value="<?= htmlspecialchars($product['price']) ?>"></p>
        <p>Mô tả: <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea></p>
        <button type="submit">Cập nhật</button>
        <a href="index.php">Hủy</a>
    </form>
</body>
</html>