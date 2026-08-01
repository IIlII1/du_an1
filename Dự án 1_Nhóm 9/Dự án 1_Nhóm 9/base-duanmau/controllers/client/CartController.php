<?php

class CartController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProModel();
    }

    private function getCart()
    {
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        return $_SESSION['cart'];
    }

    private function saveCart(array $cart): void
    {
        $_SESSION['cart'] = $cart;
    }

    private function buildCartItems(array $cart): array
    {
        $items = [];
        $total = 0;

        foreach ($cart as $productId => $item) {
            $product = $this->productModel->getById((int) $productId);
            if (!$product) {
                continue;
            }

            $quantity = max(1, (int) ($item['quantity'] ?? 1));
            $lineTotal = (float) $product['price'] * $quantity;
            $total += $lineTotal;

            $items[] = [
                'product_id' => (int) $product['product_id'],
                'product_name' => $product['product_name'],
                'price' => (float) $product['price'],
                'img' => $product['img'],
                'quantity' => $quantity,
                'line_total' => $lineTotal,
            ];
        }

        return ['items' => $items, 'total' => $total];
    }

    public function index()
    {
        $cart = $this->getCart();
        $cartData = $this->buildCartItems($cart);
        $cartItems = $cartData['items'];
        $total = $cartData['total'];
        $view = 'cart';

        require_once PATH_VIEW_CLIENT . 'main.php';
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?mode=client&action=cart');
            exit;
        }

        $productId = (int) ($_POST['product_id'] ?? 0);
        $quantity = max(1, (int) ($_POST['quantity'] ?? 1));
        $product = $this->productModel->getById($productId);

        if (!$product) {
            $_SESSION['error'] = 'Sản phẩm không tồn tại.';
            header('Location: ' . BASE_URL . '?mode=client');
            exit;
        }

        $cart = $this->getCart();
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = ['quantity' => $quantity];
        }

        $this->saveCart($cart);
        $_SESSION['success'] = 'Đã thêm sản phẩm vào giỏ hàng.';
        header('Location: ' . BASE_URL . '?mode=client&action=cart');
        exit;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?mode=client&action=cart');
            exit;
        }

        $cart = $this->getCart();
        $quantities = $_POST['quantity'] ?? [];

        foreach ($quantities as $productId => $quantity) {
            $productId = (int) $productId;
            $quantity = max(1, (int) $quantity);

            if ($productId > 0 && isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
            }
        }

        $this->saveCart($cart);
        $_SESSION['success'] = 'Giỏ hàng đã được cập nhật.';
        header('Location: ' . BASE_URL . '?mode=client&action=cart');
        exit;
    }

    public function remove()
    {
        $productId = (int) ($_GET['id'] ?? 0);
        $cart = $this->getCart();

        if ($productId > 0) {
            unset($cart[$productId]);
            $this->saveCart($cart);
        }

        header('Location: ' . BASE_URL . '?mode=client&action=cart');
        exit;
    }

    public function checkout()
    {
        $cart = $this->getCart();
        if (empty($cart)) {
            $_SESSION['error'] = 'Giỏ hàng đang trống.';
            header('Location: ' . BASE_URL . '?mode=client&action=cart');
            exit;
        }

        $cartData = $this->buildCartItems($cart);
        $cartItems = $cartData['items'];
        $total = $cartData['total'];
        $view = 'checkout';
        $success = isset($_GET['success']) && $_GET['success'] == '1';

        require_once PATH_VIEW_CLIENT . 'main.php';
    }

    public function placeOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?mode=client&action=checkout');
            exit;
        }

        $cart = $this->getCart();
        if (empty($cart)) {
            $_SESSION['error'] = 'Giỏ hàng đang trống.';
            header('Location: ' . BASE_URL . '?mode=client&action=cart');
            exit;
        }

        $customerName = trim($_POST['customer_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $note = trim($_POST['note'] ?? '');

        if ($customerName === '' || $phone === '' || $address === '') {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin người nhận.';
            header('Location: ' . BASE_URL . '?mode=client&action=checkout');
            exit;
        }

        $cartData = $this->buildCartItems($cart);
        $_SESSION['order_success'] = [
            'customer_name' => $customerName,
            'phone' => $phone,
            'address' => $address,
            'note' => $note,
            'items' => $cartData['items'],
            'total' => $cartData['total'],
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $_SESSION['cart'] = [];
        header('Location: ' . BASE_URL . '?mode=client&action=checkout&success=1');
        exit;
    }
}
