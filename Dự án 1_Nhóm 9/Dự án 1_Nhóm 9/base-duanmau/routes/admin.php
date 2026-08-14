<?php

if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? 'user') !== 'admin') {
    $_SESSION['error'] = 'Bạn cần đăng nhập bằng tài khoản quản trị để truy cập phần chỉnh sửa.';
    header('Location: ' . BASE_URL . '?mode=client&action=login');
    exit;
}

$action = $_GET['action'] ?? '/';

match ($action) {
    '/' => (new ProController())->index(),
    'deletePro' => (new ProController())->deletePro(),
    'showAddForm' => (new AddController())->showForm(),
    'addPro' => (new AddController())->addPro(),
    'showEditForm' => (new UpdateController())->showForm(),
    'editPro' => (new UpdateController())->updatePro(),
    'users' => (new UserController())->index(),
    'orders' => (new OrderController())->index(),
    'orderDetail' => (new OrderController())->detail(),
    'approveOrder' => (new OrderController())->approve(),
    'cancelOrder' => (new OrderController())->cancel(),
    'listComments' => (new CommentController())->index(), 
    'removeComment' => (new CommentController())->remove(), 
    default => (new ProController())->index(),
};