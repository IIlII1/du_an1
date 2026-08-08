<?php
$cartItems = $cartItems ?? [];
$total = $total ?? 0;
$success = $success ?? false;
?>
<div class="container py-5">
    <h2 class="mb-4">Thanh toán</h2>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if ($success && !empty($_SESSION['order_success'])): ?>
        <div class="alert alert-success">
            <h5>Đặt hàng thành công!</h5>
            <p>Chúng tôi đã nhận đơn hàng của bạn. Vui lòng giữ lại thông tin bên dưới.</p>
            <p><strong>Mã đơn hàng:</strong> #<?= htmlspecialchars($_SESSION['order_success']['order_id']) ?></p>
            <p><strong>Người nhận:</strong> <?= htmlspecialchars($_SESSION['order_success']['customer_name']) ?></p>
            <p><strong>SĐT:</strong> <?= htmlspecialchars($_SESSION['order_success']['phone']) ?></p>
            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($_SESSION['order_success']['address']) ?></p>
            <p><strong>Ghi chú:</strong> <?= !empty($_SESSION['order_success']['note']) ? htmlspecialchars($_SESSION['order_success']['note']) : 'Không có' ?></p>
            <p><strong>Tổng tiền:</strong> <?= number_format($_SESSION['order_success']['total'], 0, ',', '.') ?>₫</p>
        </div>
        <?php unset($_SESSION['order_success']); ?>
    <?php endif; ?>

    <?php if (!$success): ?>
        <div class="row">
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin người nhận</h5>
                        <form action="?mode=client&action=placeOrder" method="post">
                            <div class="form-group">
                                <label>Họ tên</label>
                                <input type="text" name="customer_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ nhận hàng</label>
                                <textarea name="address" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Ghi chú</label>
                                <textarea name="note" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Đặt hàng</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Đơn hàng</h5>
                        <?php foreach ($cartItems as $item): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span><?= htmlspecialchars($item['product_name']) ?> x<?= $item['quantity'] ?></span>
                                <span><?= number_format($item['line_total'], 0, ',', '.') ?>₫</span>
                            </div>
                        <?php endforeach; ?>
                        <hr>
                        <div class="d-flex justify-content-between font-weight-bold">
                            <span>Tổng cộng</span>
                            <span><?= number_format($total, 0, ',', '.') ?>₫</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
