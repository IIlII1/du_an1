<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="?mode=client">Shop</a>
        <div class="navbar-nav ml-auto">
            <a class="nav-link" href="?mode=client">Trang chủ</a>
            <a class="nav-link" href="?mode=client&action=cart">Giỏ hàng</a>
            <a class="nav-link" href="?mode=client&action=checkout">Thanh toán</a>
        </div>
    </div>
</nav>

<?php
if (!empty($view)) {
    require_once PATH_VIEW_CLIENT . $view . '.php';
}
?>
</body>
</html>
