<?php


class ProductRepository {
    public function __construct(private PDO $pdo) {}

    public function getAll($keyword = '', $page = 1, $limit = 5) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM products WHERE name LIKE :keyword ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countAll($keyword = '') {
        $sql = "SELECT COUNT(*) FROM products WHERE name LIKE :keyword";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($name, $price, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO products (name, price, description) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $price, $description]);
    }

    public function update($id, $name, $price, $description) {
        $stmt = $this->pdo->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
        return $stmt->execute([$name, $price, $description, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}