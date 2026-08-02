<?php
if (empty($_SESSION['user'])) {
    header('Location: ' . BASE_URL . '?mode=client&action=login');
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang cá nhân</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="?mode=client">Shop</a>
        <div class="navbar-nav ml-auto">
            <span class="nav-link text-white">Xin chào, <?= htmlspecialchars($user['name']) ?></span>
            <a class="nav-link" href="?mode=client&action=logout">Đăng xuất</a>
        </div>
    </div>
</nav>
<div class="container py-4">
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">Menu tài khoản</div>
                <div class="list-group list-group-flush">
                    <a href="?mode=users&action=dashboard" class="list-group-item list-group-item-action active">Trang cá nhân</a>
                    <a href="?mode=users&action=addresses" class="list-group-item list-group-item-action">Địa chỉ nhận hàng</a>
                    <a href="?mode=users&action=orders" class="list-group-item list-group-item-action">Đơn hàng</a>
                    <a href="?mode=users&action=wishlist" class="list-group-item list-group-item-action">Sản phẩm yêu thích</a>
                    <a href="?mode=users&action=comments" class="list-group-item list-group-item-action">Bình luận</a>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <?php if (!empty($view)) {
                require_once PATH_VIEW_USERS . $view . '.php';
            } ?>
        </div>
    </div>
</div>
</body>
</html>
