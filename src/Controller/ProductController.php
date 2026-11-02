<?php
class ProductController {
    public function __construct(private ProductRepository $repo) {}

    public function index() {
        $keyword = $_GET['search'] ?? '';
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        
        $products = $this->repo->getAll($keyword, $page, $limit);
        $totalProducts = $this->repo->countAll($keyword);
        $totalPages = ceil($totalProducts / $limit);

        require __DIR__ . '/../View/product/index.php';
    }

    public function create() {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $price = $_POST['price'];
            $description = trim($_POST['description']);

            if (empty($name)) $errors[] = "Tên không được để trống.";
            if (!is_numeric($price) || $price < 0) $errors[] = "Giá phải là số dương.";

            if (empty($errors)) {
                $this->repo->create($name, $price, $description);
                header("Location: index.php");
                exit;
            }
        }
        require __DIR__ . '/../View/product/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $product = $this->repo->findById($id);
        if (!$product) die("Sản phẩm không tồn tại.");
        
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $price = $_POST['price'];
            $description = trim($_POST['description']);

            if (empty($name)) $errors[] = "Tên không được để trống.";
            if (!is_numeric($price) || $price < 0) $errors[] = "Giá phải là số dương.";

            if (empty($errors)) {
                $this->repo->update($id, $name, $price, $description);
                header("Location: index.php");
                exit;
            }
        }
        require __DIR__ . '/../View/product/edit.php';
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['csrf']) {
                http_response_code(419);
                exit('419 - CSRF token không hợp lệ.');
            }
            $id = $_POST['id'] ?? 0;
            if ($id > 0) $this->repo->delete($id);
        }
        header("Location: index.php");
        exit;
    }
}
