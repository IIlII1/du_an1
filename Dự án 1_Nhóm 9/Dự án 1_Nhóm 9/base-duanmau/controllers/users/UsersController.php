<?php

class UsersController
{
    private $userModel;
    private $productModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->productModel = new ProModel();
    }

    private function ensureLoggedIn()
    {
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?mode=client&action=login');
            exit;
        }
    }

    private function render(string $view, array $data = [])
    {
        extract($data, EXTR_SKIP);
        require_once PATH_VIEW_USERS . 'layout.php';
    }

    public function dashboard()
    {
        $this->ensureLoggedIn();
        $user = $_SESSION['user'];
        $view = 'dashboard';
        $this->render($view, compact('user'));
    }

    public function addresses()
    {
        $this->ensureLoggedIn();
        $user = $_SESSION['user'];
        $addresses = $this->userModel->getAddressesByUser($user['user_id']);
        $view = 'addresses';
        $this->render($view, compact('user', 'addresses'));
    }

    public function saveAddress()
    {
        $this->ensureLoggedIn();
        $user = $_SESSION['user'];
        $receiverName = trim($_POST['receiver_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        if ($receiverName === '' || $phone === '' || $address === '') {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin địa chỉ.';
        } else {
            $this->userModel->addAddress($user['user_id'], $receiverName, $phone, $address);
            $_SESSION['success'] = 'Địa chỉ đã được lưu.';
        }

        header('Location: ' . BASE_URL . '?mode=users&action=addresses');
        exit;
    }

    public function removeAddress()
    {
        $this->ensureLoggedIn();
        $user = $_SESSION['user'];
        $addressId = (int) ($_GET['id'] ?? 0);
        if ($addressId > 0) {
            $this->userModel->deleteAddress($addressId, $user['user_id']);
            $_SESSION['success'] = 'Địa chỉ đã được xóa.';
        }
        header('Location: ' . BASE_URL . '?mode=users&action=addresses');
        exit;
    }

    public function orders()
    {
        $this->ensureLoggedIn();
        $user = $_SESSION['user'];
        $orders = $this->userModel->getOrdersByUser($user['user_id']);
        $view = 'orders';
        $this->render($view, compact('user', 'orders'));
    }

    public function orderDetail()
    {
        $this->ensureLoggedIn();
        $user = $_SESSION['user'];
        $orderId = (int) ($_GET['id'] ?? 0);
        $order = $this->userModel->getOrderById($orderId, $user['user_id']);
        if (!$order) {
            $_SESSION['error'] = 'Không tìm thấy đơn hàng.';
            header('Location: ' . BASE_URL . '?mode=users&action=orders');
            exit;
        }
        $details = $this->userModel->getOrderDetails($orderId);
        $view = 'order_detail';
        $this->render($view, compact('user', 'order', 'details'));
    }

    public function wishlist()
    {
        $this->ensureLoggedIn();
        $user = $_SESSION['user'];
        $wishlist = $this->userModel->getWishlistByUser($user['user_id']);
        $view = 'wishlist';
        $this->render($view, compact('user', 'wishlist'));
    }

    public function addWishlist()
    {
        $this->ensureLoggedIn();
        $user = $_SESSION['user'];
        $productId = (int) ($_POST['product_id'] ?? 0);
        if ($productId > 0) {
            $this->userModel->addWishlist($user['user_id'], $productId);
            $_SESSION['success'] = 'Đã thêm vào yêu thích.';
        }
        header('Location: ' . BASE_URL . '?mode=users&action=wishlist');
        exit;
    }

    public function removeWishlist()
    {
        $this->ensureLoggedIn();
        $user = $_SESSION['user'];
        $wishlistId = (int) ($_GET['id'] ?? 0);
        if ($wishlistId > 0) {
            $this->userModel->removeWishlist($wishlistId, $user['user_id']);
            $_SESSION['success'] = 'Đã xóa sản phẩm yêu thích.';
        }
        header('Location: ' . BASE_URL . '?mode=users&action=wishlist');
        exit;
    }

    public function comments()
    {
        $this->ensureLoggedIn();
        $user = $_SESSION['user'];
        $comments = $this->userModel->getCommentsByUser($user['user_id']);
        $view = 'comments';
        $this->render($view, compact('user', 'comments'));
    }

    public function addComment()
    {
        $this->ensureLoggedIn();
        $user = $_SESSION['user'];
        $productId = (int) ($_POST['product_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');
        if ($productId > 0 && $content !== '') {
            $this->userModel->addComment($user['user_id'], $productId, $content);
            $_SESSION['success'] = 'Bình luận đã được gửi.';
        }
        header('Location: ' . BASE_URL . '?mode=users&action=comments');
        exit;
    }

    public function removeComment()
    {
        $this->ensureLoggedIn();
        $user = $_SESSION['user'];
        $commentId = (int) ($_GET['id'] ?? 0);
        if ($commentId > 0) {
            $this->userModel->removeComment($commentId, $user['user_id']);
            $_SESSION['success'] = 'Bình luận đã được xóa.';
        }
        header('Location: ' . BASE_URL . '?mode=users&action=comments');
        exit;
    }
}
