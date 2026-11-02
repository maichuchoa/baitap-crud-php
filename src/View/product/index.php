<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>MiniShop MVC</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .pagination a { padding: 5px 10px; margin: 0 2px; border: 1px solid #ccc; text-decoration: none; }
        .pagination .active { background-color: #4CAF50; color: white; }
    </style>
</head>
<body>
    <h2>Danh sách Sản phẩm (Chuẩn MVC)</h2>
    <a href="index.php?action=create">+ Thêm sản phẩm mới</a>

        <!-- Form Tìm kiếm Ajax -->
    <div style="margin-top: 15px;">
        <input type="text" id="live-search" placeholder="Gõ để tìm kiếm Ajax..." autocomplete="off">
        <div id="live-results" style="margin: 10px 0; color: blue;"></div>
    </div>

    <!-- Nhúng file JS -->
    <script src="app.js"></script> 
    <!-- Nếu bạn để app.js trong thư mục src/View/product/ thì dùng: src="src/View/product/app.js" -->

    <!-- Bảng Sản phẩm -->
    <table>
        <tr>
            <th>ID</th><th>Tên</th><th>Giá</th><th>Mô tả</th><th>Hành động</th>
        </tr>
        <?php if (empty($products)): ?>
            <tr><td colspan="5">Không có dữ liệu.</td></tr>
        <?php else: ?>
            <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= number_format($p['price']) ?> VNĐ</td>
                <td><?= htmlspecialchars($p['description']) ?></td>
                <td>
                    <a href="index.php?action=edit&id=<?= $p['id'] ?>">Sửa</a> | 
                    <!-- Form Xóa (Bảo mật CSRF) -->
                    <form action="index.php?action=delete" method="POST" style="display:inline;" onsubmit="return confirm('Xóa?');">
                        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <button type="submit" style="background:none; border:none; color:red; cursor:pointer; text-decoration:underline;">Xóa</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <!-- Phân trang -->
    <div class="pagination" style="margin-top: 20px;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?action=index&page=<?= $i ?>&search=<?= urlencode($keyword) ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</body>
     <!-- Thanh trạng thái đăng nhập -->
    <div style="background: #eef4fb; padding: 12px; margin-bottom: 20px; border: 1px solid #cce5ff; border-radius: 5px;">
        <?php if (Auth::check()): ?>
            Xin chào! Bạn đang đăng nhập với quyền: <b><?= $_SESSION['role'] ?></b>. 
            <a href="index.php?action=logout" style="color: red; margin-left: 10px;">Đăng xuất</a>
        <?php else: ?>
            <a href="index.php?action=login" style="font-weight: bold; color: blue;">👉 Bấm vào đây để Đăng nhập</a>
        <?php endif; ?>
    </div>

    <h2>Danh sách Sản phẩm (Chuẩn MVC)</h2>
    <!-- Ẩn nút thêm/sửa/xóa nếu không phải admin -->
    <?php if (Auth::isAdmin()): ?>
        <a href="index.php?action=create">+ Thêm sản phẩm mới</a>
    <?php endif; ?>
</html>