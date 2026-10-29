<?php
require_once 'includes/functions.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $description = trim($_POST['description']);

    // Validate (Test case)
    if (empty($name)) $errors[] = "Tên không được để trống.";
    if (!is_numeric($price) || $price < 0) $errors[] = "Giá phải là số dương.";

    if (empty($errors)) {
        createProduct($pdo, $name, $price, $description);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><title>Thêm Sản Phẩm</title></head>
<body>
    <h2>Thêm Sản Phẩm</h2>
    <?php foreach ($errors as $e): ?>
        <p style="color:red;"><?= $e ?></p>
    <?php endforeach; ?>
    <form method="POST">
        <p>Tên: <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"></p>
        <p>Giá: <input type="text" name="price" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>"></p>
        <p>Mô tả: <textarea name="description"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea></p>
        <button type="submit">Lưu</button>
        <a href="index.php">Hủy</a>
    </form>
</body>
</html>