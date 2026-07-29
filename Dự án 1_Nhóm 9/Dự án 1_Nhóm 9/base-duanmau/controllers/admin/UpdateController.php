<?php
class UpdateController
{
    private $proModel;

    public function __construct()
    {
        $this->proModel = new ProModel();
    }

    public function showForm()
    {
        $id = $_GET['id'] ?? 0;
        $product = $this->proModel->getById($id);

        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm.';
            header('Location: ' . BASE_URL . '?mode=admin');
            exit;
        }

        $pdo = new PDO(sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME), DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
        $stmt = $pdo->query('SELECT cate_id, cate_name FROM categories ORDER BY cate_id');
        $categories = $stmt->fetchAll();

        require_once PATH_VIEW_ADMIN . 'product/edit.php';
    }

    public function updatePro()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?mode=admin');
            exit;
        }

        $id = (int) ($_POST['product_id'] ?? 0);
        $productName = trim($_POST['product_name'] ?? '');
        $cateId = trim($_POST['cate_id'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = (float) ($_POST['price'] ?? 0);
        $stock = (int) ($_POST['stock'] ?? 0);
        $createdAtInput = trim($_POST['created_at'] ?? '');
        $createdAt = $createdAtInput !== '' ? date('Y-m-d H:i:s', strtotime($createdAtInput)) : date('Y-m-d H:i:s');

        if ($id <= 0 || $productName === '' || $cateId === '' || $price <= 0 || $stock < 0) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin sản phẩm.';
            header('Location: ' . BASE_URL . '?mode=admin&action=showEditForm&id=' . $id);
            exit;
        }

        $pdo = new PDO(sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME), DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
        $stmt = $pdo->prepare('SELECT cate_id FROM categories WHERE cate_id = :cate_id');
        $stmt->execute([':cate_id' => $cateId]);

        if (!$stmt->fetch()) {
            $_SESSION['error'] = 'Danh mục không tồn tại.';
            header('Location: ' . BASE_URL . '?mode=admin&action=showEditForm&id=' . $id);
            exit;
        }

        $imgPath = '';
        if (!empty($_FILES['img']['name'])) {
            $imgPath = upload_file('products', $_FILES['img']);
        }

        $this->proModel->updatePro($id, [
            'cate_id' => $cateId,
            'product_name' => $productName,
            'description' => $description,
            'price' => $price,
            'img' => $imgPath,
            'stock' => $stock,
            'created_at' => $createdAt,
        ]);

        $_SESSION['success'] = 'Cập nhật sản phẩm thành công.';
        header('Location: ' . BASE_URL . '?mode=admin');
        exit;
    }
}
?>