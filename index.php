<?php
require_once 'includes/functions.php';

$keyword = $_GET['search'] ?? '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;

$products = getProducts($pdo, $keyword, $page, $limit);
$totalProducts = countProducts($pdo, $keyword);
$totalPages = ceil($totalProducts / $limit);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>MiniShop CRUD</title>
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
    <h2>Danh sách Sản phẩm</h2>
    <a href="create.php">+ Thêm sản phẩm mới</a>

    <!-- Form Tìm kiếm -->
    <form method="GET" style="margin-top: 15px;">
        <input type="text" name="search" placeholder="Tìm theo tên..." value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit">Tìm</button>
        <a href="index.php">Reset</a>
    </form>

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
                    <a href="edit.php?id=<?= $p['id'] ?>">Sửa</a> | 
                    <!-- Xóa dùng POST (Yêu cầu bắt buộc) -->
                    <form action="delete.php" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
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
            <a href="?page=<?= $i ?>&search=<?= urlencode($keyword) ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</body>
</html>