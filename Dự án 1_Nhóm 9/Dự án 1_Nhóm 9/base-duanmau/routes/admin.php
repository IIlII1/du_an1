<?php

$action = $_GET['action'] ?? '/';

if ($action === 'doAdminLogin') {
    (new AuthController())->loginAdmin();
    exit;
}

if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? 'user') !== 'admin') {
    $adminError = $_SESSION['admin_error'] ?? '';
    unset($_SESSION['admin_error']);

    echo '<!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <style>
            * { box-sizing: border-box; }
            body {
                margin: 0;
                font-family: Arial, sans-serif;
                background: linear-gradient(135deg, #0b1020, #121b2d);
                color: #fff;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .admin-login-overlay {
                width: min(92vw, 420px);
                background: rgba(18, 24, 36, 0.94);
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 18px;
                padding: 28px 24px;
                box-shadow: 0 30px 80px rgba(0,0,0,0.42);
            }
            .admin-login-title {
                text-align: center;
                font-size: 24px;
                font-weight: 700;
                margin-bottom: 8px;
            }
            .admin-login-subtitle {
                text-align: center;
                color: #b0b8c9;
                font-size: 13px;
                margin-bottom: 22px;
            }
            .admin-login-form {
                display: flex;
                flex-direction: column;
                gap: 14px;
            }
            .admin-login-form label {
                display: block;
                font-size: 12px;
                color: #dfe7ff;
                margin-bottom: 6px;
            }
            .admin-login-form input {
                width: 100%;
                background: #0c1424;
                border: 1px solid #2a394f;
                border-radius: 10px;
                padding: 12px 14px;
                color: #fff;
                font-size: 14px;
            }
            .admin-login-form input:focus {
                outline: none;
                border-color: #4ea3ff;
            }
            .admin-login-btn {
                margin-top: 10px;
                background: linear-gradient(135deg, #1b9dff, #4e7cff);
                color: #fff;
                border: none;
                border-radius: 10px;
                padding: 12px 16px;
                font-weight: 700;
                cursor: pointer;
            }
            .admin-login-alert {
                background: rgba(255, 80, 80, 0.12);
                border: 1px solid rgba(255, 110, 110, 0.4);
                color: #ffd5d5;
                padding: 10px 12px;
                border-radius: 10px;
                margin-bottom: 18px;
                font-size: 12px;
            }
            .admin-login-note {
                margin-top: 18px;
                text-align: center;
                font-size: 12px;
                color: #aab8d3;
            }
            .admin-login-note strong { color: #fff; }
        </style>
    </head>
    <body>
        <div class="admin-login-overlay">
            <div class="admin-login-title">Đăng nhập Admin</div>
            <div class="admin-login-subtitle">Chỉ tài khoản quản trị mới được truy cập phần chỉnh sửa.</div>

            ' . (!empty($adminError) ? '<div class="admin-login-alert">' . htmlspecialchars($adminError) . '</div>' : '') . '

            <form method="post" action="?mode=admin&action=doAdminLogin" class="admin-login-form">
                <div>
                    <label for="admin-email">Email</label>
                    <input id="admin-email" type="email" name="email" value="admin@keepsilent.com" required>
                </div>
                <div>
                    <label for="admin-password">Mật khẩu</label>
                    <input id="admin-password" type="password" name="password" value="admin123" required>
                </div>
                <button type="submit" class="admin-login-btn">Đăng nhập quản trị</button>
            </form>

            <div class="admin-login-note">
                Tài khoản mặc định: <strong>admin@keepsilent.com</strong> / <strong>admin123</strong>
            </div>
        </div>
    </body>
    </html>';
    exit;
}

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