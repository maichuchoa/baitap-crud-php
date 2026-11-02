<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><title>Đăng nhập</title></head>
<body>
    <h2>Đăng nhập</h2>
    <?php if (isset($error)): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>
    
    <form method="POST" action="index.php?action=login">
        <p>Email: <input type="email" name="email" required></p>
        <p>Mật khẩu: <input type="password" name="password" required></p>
        <button type="submit">Đăng nhập</button>
        <a href="index.php">Về trang chủ</a>
    </form>
</body>
</html>