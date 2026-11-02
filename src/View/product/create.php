<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><title>Thêm Sản Phẩm</title></head>
<body>
    <h2>Thêm Sản Phẩm</h2>
    
    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $e): ?>
            <p style="color:red;"><?= $e ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="POST" action="index.php?action=create">
        <p>Tên: <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"></p>
        <p>Giá: <input type="text" name="price" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>"></p>
        <p>Mô tả: <textarea name="description"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea></p>
        <button type="submit">Lưu</button>
        <a href="index.php">Hủy</a>
    </form>
</body>
</html>
