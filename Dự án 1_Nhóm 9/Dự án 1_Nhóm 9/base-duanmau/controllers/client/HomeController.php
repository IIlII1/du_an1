<?php

class HomeController
{   
    private $productModel;

    public function __construct() {
        $this->productModel = new ProModel();
    }
public function productDetail()
{
    $id = $_GET['product_id'] ?? $_GET['id'] ?? 0;

    if (!$id) {
        header('Location: ?mode=client');
        exit;
    }

$product = $this->productModel->getProductById($id);
    $sizes = $this->productModel->getProductSizes($id);

    if (!$product) {
        header('Location: ?mode=client');
        exit;
    }

    // Ảnh phụ (gallery) của sản phẩm
    $productImages = $this->productModel->getProductImages($id);

    // Sản phẩm liên quan (cùng danh mục)
    $relatedProducts = $this->productModel->getRelatedProducts(
        (int) $product['product_id'],
        (int) $product['cate_id'],
        4
    );

    // Sản phẩm từng xem (recently viewed) lưu trong session
    $recentlyViewedIds = $_SESSION['recently_viewed'] ?? [];
    // Thêm sản phẩm hiện tại vào đầu danh sách đã xem
    $recentlyViewedIds = array_map('intval', $recentlyViewedIds);
    $recentlyViewedIds = array_filter($recentlyViewedIds, function ($pid) use ($id) {
        return (int) $pid !== (int) $id;
    });
    array_unshift($recentlyViewedIds, (int) $id);
    $recentlyViewedIds = array_slice(array_values($recentlyViewedIds), 0, 8);
    $_SESSION['recently_viewed'] = $recentlyViewedIds;

    $recentlyViewedProducts = $this->productModel->getProductsByIds($recentlyViewedIds);

    // Toàn bộ size (dùng cho fallback khi sản phẩm chưa có product_size)
    $allSizes = $this->productModel->getAllSizes();

    $cartCount = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $cartItem) {
            $cartCount += (int) ($cartItem['quantity'] ?? 0);
        }
    }

    $view = 'product-detail';

    require_once PATH_VIEW_MAIN_CLIENT;
}

    public function index()
    {
        $view = 'home';
        $query = trim($_GET['q'] ?? '');

$newArrivals = $this->productModel->getProductsByCategoryName('Invisible Fence');
        $data = $query !== '' ? $this->productModel->searchByName($query) : $this->productModel->getLatestProducts();

        $cartCount = 0;
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $cartCount += (int) ($cartItem['quantity'] ?? 0);
            }
        }

        require_once PATH_VIEW_CLIENT . 'main.php';
    }
}