<?php
if (empty($_SESSION['user'])) {
    header('Location: ' . BASE_URL . '?mode=client&action=login');
    exit;
}

$user = $_SESSION['user'];
$currentAction = $_GET['action'] ?? 'dashboard';

$defaultAvatar = BASE_URL . 'dist/img/user1-128x128.jpg';

if (!empty($user['avatar'])) {
    $avatarPath = PATH_ASSETS_UPLOADS . 'avatars/' . $user['avatar'];

    if (file_exists($avatarPath)) {
        $avatar = BASE_ASSETS_UPLOADS . 'avatars/' . rawurlencode($user['avatar']);
    } else {
        $avatar = $defaultAvatar;
    }
} else {
    $avatar = $defaultAvatar;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Account - KEEP:SILENT</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background: #0d0d0d;
            color: #f5f5f5;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* =========================
           WRAPPER
        ========================= */

        .user-wrapper {
            width: 1180px;
            max-width: calc(100% - 40px);
            margin: 45px auto 70px;

            display: grid;
            grid-template-columns: 260px 1fr;

            gap: 45px;

            align-items: start;
        }


        /* =========================
           SIDEBAR
        ========================= */

        .user-sidebar {
            background: #111;
            border: 1px solid #292929;
            border-radius: 15px;

            padding: 16px;

            position: sticky;
            top: 25px;
        }


        /* BRAND */

        .brand-box {
            padding: 5px 8px 17px;

            border-bottom: 1px solid #292929;
        }

        .brand-name {
            font-size: 24px;
            font-weight: 900;

            letter-spacing: 1px;

            color: #fff;

            margin-bottom: 5px;
        }

        .brand-url {
            font-size: 7px;
            letter-spacing: 1.5px;

            color: #777;
        }


        /* VISIT SHOP */

        .visit-shop {
            display: inline-block;

            margin-top: 13px;

            padding: 7px 13px;

            border: 1px solid #777;
            border-radius: 20px;

            font-size: 8px;
            font-weight: 700;

            letter-spacing: 1px;

            transition: .2s;
        }

        .visit-shop:hover {
            background: #fff;
            color: #000;
            border-color: #fff;
        }


        /* MENU TITLE */

        .menu-title {
            margin: 20px 8px 8px;

            color: #888;

            font-size: 8px;
            font-weight: 700;

            letter-spacing: 1.5px;

            text-transform: uppercase;
        }


        /* MENU */

        .account-menu {
            background: #171717;

            border: 1px solid #292929;
            border-radius: 12px;

            padding: 7px;
        }

        .account-menu a {
            display: block;

            padding: 10px;

            margin: 2px 0;

            border-radius: 7px;

            color: #bbb;

            font-size: 10px;

            transition: .2s;
        }

        .account-menu a:hover {
            background: #242424;
            color: #fff;
        }

        .account-menu a.active {
            background: #292929;

            color: #fff;

            border: 1px solid #3b3b3b;
        }


        /* =========================
           ACCOUNT INFO
        ========================= */

        .account-info {
            margin-top: 10px;

            background: #171717;

            border: 1px solid #292929;
            border-radius: 12px;

            padding: 13px 12px;
        }

        .account-info-title {
            color: #888;

            font-size: 8px;
            font-weight: 700;

            letter-spacing: 1.5px;

            margin-bottom: 11px;
        }

        .info-row {
            display: flex;

            justify-content: space-between;

            gap: 10px;

            padding: 4px 0;

            font-size: 9px;
        }

        .info-label {
            color: #777;
        }

        .info-value {
            color: #ddd;

            text-align: right;

            max-width: 145px;

            overflow: hidden;

            text-overflow: ellipsis;

            white-space: nowrap;
        }


        /* =========================
           CONTENT
        ========================= */

        .user-content {
            min-width: 0;
        }

        .page-title {
            margin: 0;

            font-size: 28px;
            font-weight: 600;

            color: #fff;
        }

        .page-description {
            margin: 6px 0 25px;

            color: #777;

            font-size: 10px;
        }


        /* =========================
           CARD
        ========================= */

        .user-card {
            background: #171717;

            border: 1px solid #292929;

            border-radius: 15px;

            overflow: hidden;

            margin-bottom: 22px;
        }

        .card-title {
            padding: 14px 18px;

            border-bottom: 1px solid #292929;

            color: #ddd;

            font-size: 10px;

            font-weight: 600;
        }

        .card-body {
            padding: 18px;
        }


        /* =========================
           TABLE
        ========================= */

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .user-table {
            width: 100%;

            border-collapse: collapse;
        }

        .user-table th {
            padding: 12px 10px;

            text-align: left;

            color: #777;

            font-size: 8px;

            font-weight: 600;

            letter-spacing: 1px;

            text-transform: uppercase;

            border-bottom: 1px solid #303030;
        }

        .user-table td {
            padding: 14px 10px;

            color: #ccc;

            font-size: 10px;

            border-bottom: 1px solid #252525;

            vertical-align: middle;
        }

        .user-table tr:last-child td {
            border-bottom: none;
        }

        .user-table tr:hover td {
            background: #1b1b1b;
        }


        /* =========================
           FORM
        ========================= */

        .profile-form {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 18px;
        }

        .form-group {
            margin: 0;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;

            margin-bottom: 7px;

            color: #aaa;

            font-size: 9px;
        }

        .form-control {
            width: 100%;

            height: 39px;

            padding: 0 12px;

            background: #101010;

            border: 1px solid #363636;

            border-radius: 7px;

            color: #fff;

            outline: none;

            font-size: 10px;
        }

        textarea.form-control {
            height: 80px;

            padding-top: 10px;

            resize: vertical;
        }

        select.form-control {
            cursor: pointer;
        }

        .form-control:focus {
            border-color: #777;
        }

        .form-control::placeholder {
            color: #555;
        }


        /* =========================
           AVATAR
        ========================= */

        .profile-avatar-area {
            display: flex;

            align-items: center;

            gap: 20px;

            margin-bottom: 22px;

            padding-bottom: 20px;

            border-bottom: 1px solid #292929;
        }

        .profile-avatar {
            width: 85px;
            height: 85px;

            border-radius: 50%;

            object-fit: cover;

            border: 1px solid #444;

            background: #222;
        }

        .avatar-note {
            color: #777;

            font-size: 9px;

            line-height: 1.5;
        }

        .avatar-input {
            margin-top: 8px;

            color: #aaa;

            font-size: 9px;
        }


        /* =========================
           BUTTON
        ========================= */

        .save-btn {
            margin-top: 3px;

            padding: 10px 18px;

            border: none;

            border-radius: 7px;

            background: #fff;

            color: #000;

            font-size: 9px;

            font-weight: 700;

            cursor: pointer;

            transition: .2s;
        }

        .save-btn:hover {
            background: #ddd;
        }

        .delete-btn,
        .detail-btn {
            display: inline-block;

            padding: 6px 11px;

            border: 1px solid #444;

            border-radius: 6px;

            color: #aaa;

            font-size: 9px;

            transition: .2s;
        }

        .delete-btn:hover,
        .detail-btn:hover {
            background: #fff;

            color: #000;

            border-color: #fff;
        }


        /* =========================
           EMPTY
        ========================= */

        .empty-data {
            padding: 30px 10px;

            text-align: center;

            color: #666;

            font-size: 10px;
        }


        /* =========================
           ALERT
        ========================= */

        .alert {
            padding: 11px 13px;

            border-radius: 7px;

            margin-bottom: 15px;

            font-size: 9px;
        }

        .alert-success {
            background: #162316;

            border: 1px solid #294329;

            color: #9bd39b;
        }

        .alert-danger {
            background: #291616;

            border: 1px solid #4a2929;

            color: #e49a9a;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 800px) {

            .user-wrapper {
                grid-template-columns: 1fr;

                gap: 20px;
            }

            .user-sidebar {
                position: static;
            }

            .profile-form {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

        }

    </style>

</head>


<body>


<div class="user-wrapper">


    <aside class="user-sidebar">


        <div class="brand-box">

            <div class="brand-name">
                <img src="https://inwfile.com/s-gn/_webp_max_images/600/600/ni/yw/w6.webp" width="150px">
            </div>

            <div class="brand-url">
                WWW.KEEPSILENT.COM
            </div>

            <a href="?mode=client" class="visit-shop">
                VISIT SHOP
            </a>

        </div>


        <div class="menu-title">
            MY ORDERS
        </div>


        <div class="account-menu">

            <a
                href="?mode=users&action=dashboard"
                class="<?= $currentAction === 'dashboard' ? 'active' : '' ?>"
            >
                Trang cá nhân
            </a>

            <a
                href="?mode=users&action=addresses"
                class="<?= $currentAction === 'addresses' ? 'active' : '' ?>"
            >
                Địa chỉ nhận hàng
            </a>

            <a
                href="?mode=users&action=orders"
                class="<?= in_array($currentAction, ['orders', 'orderDetail']) ? 'active' : '' ?>"
            >
                Đơn hàng
            </a>

            <a
                href="?mode=users&action=wishlist"
                class="<?= $currentAction === 'wishlist' ? 'active' : '' ?>"
            >
                Sản phẩm yêu thích
            </a>

            <a
                href="?mode=users&action=comments"
                class="<?= $currentAction === 'comments' ? 'active' : '' ?>"
            >
                Đánh giá
            </a>

        </div>


        <!-- ACCOUNT INFO -->

        <div class="account-info">

            <div class="account-info-title">
                ACCOUNT INFO
            </div>

            <div class="info-row">
                <span class="info-label">
                    Name
                </span>

                <span class="info-value">
                    <?= htmlspecialchars($user['name'] ?? '') ?>
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">
                    Email
                </span>

                <span class="info-value">
                    <?= htmlspecialchars($user['email'] ?? '') ?>
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">
                    Phone
                </span>

                <span class="info-value">
                    <?= htmlspecialchars($user['phone'] ?? '') ?>
                </span>
            </div>

        </div>


    </aside>


    <!-- =========================
         CONTENT
    ========================== -->

    <main class="user-content">

        <?php

        if (!empty($view)) {

            require_once PATH_VIEW_USERS . $view . '.php';

        }

        ?>

    </main>


</div>


</body>

</html>