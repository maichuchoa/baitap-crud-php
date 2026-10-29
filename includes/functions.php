<?php
require_once __DIR__ . '/../config/db.php';

// Lấy danh sách có Tìm kiếm và Phân trang
function getProducts($pdo, $keyword = '', $page = 1, $limit = 5) {
    $offset = ($page - 1) * $limit;
    $sql = "SELECT * FROM products WHERE name LIKE :keyword ORDER BY id DESC LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Đếm tổng số sản phẩm (để phân trang)
function countProducts($pdo, $keyword = '') {
    $sql = "SELECT COUNT(*) FROM products WHERE name LIKE :keyword";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn();
}

// Lấy 1 sản phẩm theo ID
function getProductById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// Thêm sản phẩm
function createProduct($pdo, $name, $price, $description) {
    $stmt = $pdo->prepare("INSERT INTO products (name, price, description) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $price, $description]);
}

// Cập nhật sản phẩm
function updateProduct($pdo, $id, $name, $price, $description) {
    $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
    return $stmt->execute([$name, $price, $description, $id]);
}

// Xóa sản phẩm
function deleteProduct($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    return $stmt->execute([$id]);
}
?>