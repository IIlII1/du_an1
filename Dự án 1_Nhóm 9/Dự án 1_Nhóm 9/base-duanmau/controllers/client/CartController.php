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
                'size_id' => (int) ($product['size_id'] ?? 0),
                'quantity' => $quantity,
                'line_total' => $lineTotal,
                'added_at' => $item['added_at'] ?? null,
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
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
                exit;
            }

            $_SESSION['error'] = 'Sản phẩm không tồn tại.';
            header('Location: ' . BASE_URL . '?mode=client');
            exit;
        }

        $cart = $this->getCart();
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
            if (empty($cart[$productId]['added_at'])) {
                $cart[$productId]['added_at'] = date('Y-m-d H:i:s');
            }
        } else {
            $cart[$productId] = [
                'quantity' => $quantity,
                'added_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->saveCart($cart);

        $cartQuantity = array_sum(array_column($cart, 'quantity'));
        $successMessage = 'Đã thêm sản phẩm vào giỏ hàng.';

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => $successMessage,
                'cartQuantity' => $cartQuantity,
            ]);
            exit;
        }

        $_SESSION['success'] = $successMessage;
        $redirect = $_SERVER['HTTP_REFERER'] ?? BASE_URL . '?mode=client';
        header('Location: ' . $redirect);
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
        $addresses = [];
        if (!empty($_SESSION['user'])) {
            $addresses = $this->userModel->getAddressesByUser((int) $_SESSION['user']['user_id']);
        }
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
        } else {
            $userId = (int) $_SESSION['user']['user_id'];
            if ($customerName !== '' && $phone !== '' && $address !== '') {
                $existingAddress = $this->userModel->findAddress($userId, $customerName, $phone, $address);
                if (!$existingAddress) {
                    $this->userModel->addAddress($userId, $customerName, $phone, $address);
                }
            }
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
            $_SESSION['error'] = 'Không thể tạo đơn hàng. Vui lòng thử lại sau.';
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
