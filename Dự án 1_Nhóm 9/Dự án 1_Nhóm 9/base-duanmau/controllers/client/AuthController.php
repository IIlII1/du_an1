<?php

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function showForm($type = 'login')
    {
        if (!empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?mode=users');
            exit;
        }

        $view = 'auth';
        $authType = $type;
        require_once PATH_VIEW_CLIENT . 'main.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?mode=client&action=register');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');

        if ($name === '' || $email === '' || $phone === '' || $password === '' || $confirmPassword === '') {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin.';
            header('Location: ' . BASE_URL . '?mode=client&action=register');
            exit;
        }

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Mật khẩu xác nhận không khớp.';
            header('Location: ' . BASE_URL . '?mode=client&action=register');
            exit;
        }

        if ($this->userModel->getByEmail($email)) {
            $_SESSION['error'] = 'Email này đã được sử dụng.';
            header('Location: ' . BASE_URL . '?mode=client&action=register');
            exit;
        }

        $userId = $this->userModel->register([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'user',
        ]);

        $_SESSION['success'] = 'Đăng ký thành công. Bạn có thể đăng nhập ngay bây giờ.';
        header('Location: ' . BASE_URL . '?mode=client&action=login');
        exit;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?mode=client&action=login');
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            $_SESSION['error'] = 'Vui lòng nhập email và mật khẩu.';
            header('Location: ' . BASE_URL . '?mode=client&action=login');
            exit;
        }

        $user = $this->userModel->getByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'user_id' => $user['user_id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'role' => $user['role'],
            ];
            $_SESSION['success'] = 'Đăng nhập thành công.';
            header('Location: ' . BASE_URL . '?mode=users');
            exit;
        }

        $_SESSION['error'] = 'Email hoặc mật khẩu không đúng.';
        header('Location: ' . BASE_URL . '?mode=client&action=login');
        exit;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['success'] = 'Bạn đã đăng xuất.';
        header('Location: ' . BASE_URL . '?mode=client');
        exit;
    }
}
