<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><title>Sửa Sản Phẩm</title></head>
<body>
    <h2>Sửa Sản Phẩm</h2>

    <!-- Hiển thị lỗi nếu có -->
    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $e): ?>
            <p style="color:red;"><?= $e ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="POST" action="index.php?action=edit&id=<?= $id ?>">
        <p>Tên: <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>"></p>
        <p>Giá: <input type="text" name="price" value="<?= htmlspecialchars($product['price']) ?>"></p>
        <p>Mô tả: <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea></p>
        <button type="submit">Cập nhật</button>
        <a href="index.php">Hủy</a>
    </form>
</body>
</html>