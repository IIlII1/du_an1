<?php

class CartController
{
    private $productModel;
    private $userModel;

    public function __construct()
    {
        $this->productModel = new ProModel();
        $this->userModel = new UserModel();
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

    private function getCartCount(): int
    {
        $count = 0;
        $cart = $this->getCart();
        foreach ($cart as $item) {
            $count += (int) ($item['quantity'] ?? 0);
        }
        return $count;
    }

    private function buildCartItems(array $cart): array
    {
        $items = [];
        $total = 0;

        foreach ($cart as $key => $item) {
            $productId = (int) ($item['product_id'] ?? $key);
            $product = $this->productModel->getById($productId);
            if (!$product) {
                continue;
            }

            $quantity = max(1, (int) ($item['quantity'] ?? 1));
            $lineTotal = (float) $product['price'] * $quantity;
            $total += $lineTotal;

            $sizeId = (int) ($item['size_id'] ?? 0);
            if ($sizeId <= 0 && !empty($product['size_id'])) {
                $sizeId = (int) $product['size_id'];
            }
            if ($sizeId <= 0) {
                $allSizes = $this->productModel->getAllSizes();
                if (!empty($allSizes)) {
                    $sizeId = (int) $allSizes[0]['size_id'];
                } else {
                    $sizeId = 1;
                }
            }

            $items[] = [
                'key' => $key,
                'product_id' => (int) $product['product_id'],
                'product_name' => $product['product_name'],
                'price' => (float) $product['price'],
                'img' => $product['img'],
                'size_id' => $sizeId,
                'size_name' => $this->getSizeName($sizeId),
                'quantity' => $quantity,
                'line_total' => $lineTotal,
            ];
        }

        return ['items' => $items, 'total' => $total];
    }

    private function getSizeName(int $sizeId): string
    {
        if ($sizeId <= 0) {
            return '';
        }
        foreach ($this->productModel->getAllSizes() as $size) {
            if ((int) $size['size_id'] === $sizeId) {
                return (string) $size['size_name'];
            }
        }
        return '';
    }

    public function index()
    {
        $cart = $this->getCart();
        $cartData = $this->buildCartItems($cart);
        $cartItems = $cartData['items'];
        $total = $cartData['total'];
        $view = 'cart';

        $cartCount = $this->getCartCount();

        require_once PATH_VIEW_CLIENT . 'main.php';
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?mode=client&action=cart');
            exit;
        }

        $productId = (int) ($_POST['product_id'] ?? 0);
        $sizeId = (int) ($_POST['size_id'] ?? 0);
        $quantity = max(1, (int) ($_POST['quantity'] ?? 1));
        $product = $this->productModel->getById($productId);

        if (!$product) {
            $_SESSION['error'] = 'Sản phẩm không tồn tại.';
            header('Location: ' . BASE_URL . '?mode=client');
            exit;
        }

        // Nếu sản phẩm có size trong bảng product_size, bắt buộc chọn size hợp lệ
        $productSizes = $this->productModel->getProductSizes($productId);
        if (!empty($productSizes) && ($sizeId <= 0 || !in_array($sizeId, array_map('intval', array_column($productSizes, 'size_id'))))) {
            $_SESSION['error'] = 'Vui lòng chọn size sản phẩm.';
            header('Location: ' . BASE_URL . '?mode=client&action=productDetail&product_id=' . $productId);
            exit;
        }

        // Composite key: phân biệt cùng sản phẩm nhưng khác size
        $key = $productId . ':' . $sizeId;

        $cart = $this->getCart();
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'product_id' => $productId,
                'size_id' => $sizeId,
                'quantity' => $quantity,
            ];
        }

        $this->saveCart($cart);

        // AJAX request: return JSON instead of redirect
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng.',
                'cartCount' => $this->getCartCount(),
            ]);
            exit;
        }

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

        foreach ($quantities as $key => $quantity) {
            $quantity = max(1, (int) $quantity);

            if (isset($cart[$key])) {
                $cart[$key]['quantity'] = $quantity;
            }
        }

        $this->saveCart($cart);

        // AJAX request: return updated totals as JSON
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $cartData = $this->buildCartItems($cart);
            $requestedKey = (string) key($quantities);
            $lineTotal = 0;
            foreach ($cartData['items'] as $item) {
                if ($item['key'] === $requestedKey) {
                    $lineTotal = $item['line_total'];
                    break;
                }
            }
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Giỏ hàng đã được cập nhật.',
                'cartCount' => $this->getCartCount(),
                'total' => $cartData['total'],
                'lineTotal' => $lineTotal,
            ]);
            exit;
        }

        $_SESSION['success'] = 'Giỏ hàng đã được cập nhật.';
        header('Location: ' . BASE_URL . '?mode=client&action=cart');
        exit;
    }

    public function remove()
    {
        $key = $_GET['key'] ?? $_GET['id'] ?? '';
        $cart = $this->getCart();

        if ($key !== '' && $key !== null && isset($cart[$key])) {
            unset($cart[$key]);
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
        $addresses = [];
        if (!empty($_SESSION['user'])) {
            $addresses = $this->userModel->getAddressesByUser((int) $_SESSION['user']['user_id']);
        }
$view = 'checkout';
        $success = isset($_GET['success']) && $_GET['success'] == '1';
        $cartCount = $this->getCartCount();

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

        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập trước khi đặt hàng.';
            header('Location: ' . BASE_URL . '?mode=client&action=login');
            exit;
        }

        $addressId = (int) ($_POST['address_id'] ?? 0);
        $customerName = trim($_POST['customer_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $note = trim($_POST['note'] ?? '');
        $paymentMethod = trim($_POST['payment_method'] ?? 'Thanh toán khi nhận hàng');

        if ($addressId > 0) {
            $savedAddress = $this->userModel->getAddressById($addressId, (int) $_SESSION['user']['user_id']);
            if (!$savedAddress) {
                $_SESSION['error'] = 'Địa chỉ không hợp lệ.';
                header('Location: ' . BASE_URL . '?mode=client&action=checkout');
                exit;
            }
            $customerName = $savedAddress['receiver_name'];
            $phone = $savedAddress['phone'];
            $address = $savedAddress['address'];
        }

        if ($customerName === '' || $phone === '' || $address === '') {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin người nhận.';
            header('Location: ' . BASE_URL . '?mode=client&action=checkout');
            exit;
        }

        $cartData = $this->buildCartItems($cart);
        $userId = (int) $_SESSION['user']['user_id'];
        $paymentStatus = in_array($paymentMethod, ['Chuyển khoản ngân hàng', 'Chuyển khoản QR'], true)
            ? 'Đã thanh toán'
            : 'Chưa thanh toán';

        try {
            $orderId = $this->userModel->createOrderWithDetails($userId, $cartData['total'], $cartData['items'], $paymentMethod, $paymentStatus);
        } catch (Throwable $e) {
            $_SESSION['error'] = 'Không thể tạo đơn hàng. Vui lòng thử lại sau. (' . $e->getMessage() . ')';
            header('Location: ' . BASE_URL . '?mode=client&action=checkout');
            exit;
        }

        $_SESSION['order_success'] = [
            'order_id' => $orderId,
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
