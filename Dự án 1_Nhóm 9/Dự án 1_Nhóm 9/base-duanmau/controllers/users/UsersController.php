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
    public function updateProfile()
{
    $this->ensureLoggedIn();

    $userId = (int) $_SESSION['user']['user_id'];

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($name === '' || $email === '' || $phone === '') {

        $_SESSION['error'] = 'Vui lòng nhập đầy đủ họ tên, email và số điện thoại.';

        header('Location: ' . BASE_URL . '?mode=users&action=dashboard');
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Kiểm tra email
    |--------------------------------------------------------------------------
    */

    $oldUser = $this->userModel->getByEmail($email);

    if ($oldUser && (int)$oldUser['user_id'] !== $userId) {

        $_SESSION['error'] = 'Email này đã được sử dụng bởi tài khoản khác.';

        header('Location: ' . BASE_URL . '?mode=users&action=dashboard');
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Avatar
    |--------------------------------------------------------------------------
    */

    $avatarName = $_SESSION['user']['avatar'] ?? null;


    if (
        isset($_FILES['avatar']) &&
        $_FILES['avatar']['error'] === UPLOAD_ERR_OK
    ) {

        $file = $_FILES['avatar'];

        $allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!in_array($file['type'], $allowedTypes)) {

            $_SESSION['error'] = 'Avatar chỉ được là JPG, PNG hoặc WEBP.';

            header('Location: ' . BASE_URL . '?mode=users&action=dashboard');
            exit;
        }


        if ($file['size'] > 5 * 1024 * 1024) {

            $_SESSION['error'] = 'Avatar không được vượt quá 5MB.';

            header('Location: ' . BASE_URL . '?mode=users&action=dashboard');
            exit;
        }


        $avatarFolder = PATH_ASSETS_UPLOADS . 'avatars/';


        if (!is_dir($avatarFolder)) {

            mkdir($avatarFolder, 0777, true);

        }


        $extension = strtolower(
            pathinfo($file['name'], PATHINFO_EXTENSION)
        );


        $avatarName = 'avatar_' . $userId . '_' . time() . '.' . $extension;


        move_uploaded_file(
            $file['tmp_name'],
            $avatarFolder . $avatarName
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Update database
    |--------------------------------------------------------------------------
    */

    $updated = $this->userModel->updateProfile(
        $userId,
        $name,
        $email,
        $phone,
        $avatarName
    );


    if ($updated) {

        /*
        |--------------------------------------------------------------------------
        | Cập nhật session
        |--------------------------------------------------------------------------
        */

        $newUser = $this->userModel->getById($userId);

        $_SESSION['user'] = [
            'user_id' => $newUser['user_id'],
            'name' => $newUser['name'],
            'email' => $newUser['email'],
            'phone' => $newUser['phone'],
            'avatar' => $newUser['avatar'] ?? null,
            'role' => $newUser['role']
        ];

        $_SESSION['success'] = 'Thông tin cá nhân đã được cập nhật.';

    } else {

        $_SESSION['error'] = 'Không thể cập nhật thông tin.';

    }


    header('Location: ' . BASE_URL . '?mode=users&action=dashboard');
    exit;
}
}
