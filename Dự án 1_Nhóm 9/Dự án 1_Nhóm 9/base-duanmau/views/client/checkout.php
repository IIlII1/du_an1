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
                <div class="alert alert-success d-none" id="order-success-inline">
                        <h5>Đặt hàng thành công!</h5>
                        <p>Chúng tôi đã nhận đơn hàng của bạn. Vui lòng giữ lại thông tin bên dưới.</p>
                        <p><strong>Mã đơn hàng:</strong> #<?= htmlspecialchars($_SESSION['order_success']['order_id']) ?></p>
                        <p><strong>Người nhận:</strong> <?= htmlspecialchars($_SESSION['order_success']['customer_name']) ?></p>
                        <p><strong>SĐT:</strong> <?= htmlspecialchars($_SESSION['order_success']['phone']) ?></p>
                        <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($_SESSION['order_success']['address']) ?></p>
                        <p><strong>Ghi chú:</strong> <?= !empty($_SESSION['order_success']['note']) ? htmlspecialchars($_SESSION['order_success']['note']) : 'Không có' ?></p>
                        <p><strong>Tổng tiền:</strong> <?= number_format($_SESSION['order_success']['total'], 0, ',', '.') ?>₫</p>
                </div>

                <!-- Modal fallback / visual confirmation -->
                <div class="modal fade" id="orderSuccessModal" tabindex="-1" role="dialog" aria-labelledby="orderSuccessModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="orderSuccessModalLabel">Đặt hàng thành công</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Chúng tôi đã nhận đơn hàng của bạn. Thông tin đơn hàng:</p>
                                <ul>
                                    <li><strong>Mã đơn:</strong> #<?= htmlspecialchars($_SESSION['order_success']['order_id']) ?></li>
                                    <li><strong>Người nhận:</strong> <?= htmlspecialchars($_SESSION['order_success']['customer_name']) ?></li>
                                    <li><strong>SĐT:</strong> <?= htmlspecialchars($_SESSION['order_success']['phone']) ?></li>
                                    <li><strong>Địa chỉ:</strong> <?= htmlspecialchars($_SESSION['order_success']['address']) ?></li>
                                    <li><strong>Tổng:</strong> <?= number_format($_SESSION['order_success']['total'], 0, ',', '.') ?>₫</li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <a href="?mode=client&action=cart" class="btn btn-outline-secondary">Quay lại giỏ hàng</a>
                                <a href="?mode=client" class="btn btn-primary">Tiếp tục mua sắm</a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php unset($_SESSION['order_success']); ?>
    <?php endif; ?>

<?php if ($success): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            try {
                // show modal (requires bootstrap js loaded by main.php)
                setTimeout(function () {
                    var $ = window.jQuery || null;
                    if ($ && typeof $.fn.modal === 'function') {
                        $('#orderSuccessModal').modal('show');
                    } else {
                        var el = document.getElementById('order-success-inline');
                        if (el) el.classList.remove('d-none');
                    }
                }, 150);
            } catch (e) {
                var el = document.getElementById('order-success-inline');
                if (el) el.classList.remove('d-none');
            }
        });
    </script>
<?php endif; ?>

    <?php if (!$success): ?>
        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin người nhận</h5>
                        <form action="?mode=client&action=placeOrder" method="post">
                            <?php if (!empty($addresses)): ?>
                                <div class="form-group">
                                    <label>Chọn địa chỉ đã lưu</label>
                                    <select name="address_id" class="form-control">
                                        <option value="0">-- Sử dụng địa chỉ mới --</option>
                                        <?php foreach ($addresses as $savedAddress): ?>
                                            <option value="<?= $savedAddress['address_id'] ?>"><?= htmlspecialchars($savedAddress['receiver_name']) ?> - <?= htmlspecialchars($savedAddress['address']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
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
                            <div class="form-group">
                                <label>Phương thức thanh toán</label>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="payment_cod" name="payment_method" value="Thanh toán khi nhận hàng" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="payment_cod">Thanh toán khi nhận hàng</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="payment_bank" name="payment_method" value="Chuyển khoản ngân hàng" class="custom-control-input">
                                    <label class="custom-control-label" for="payment_bank">Chuyển khoản ngân hàng</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="payment_qr" name="payment_method" value="Chuyển khoản QR" class="custom-control-input">
                                    <label class="custom-control-label" for="payment_qr">Chuyển khoản QR</label>
                                </div>
                            </div>
                            <div class="card bg-light p-3 mb-3">
                                <strong>Thông tin thanh toán</strong>
                                <p class="mb-1"><strong>Ngân hàng:</strong> Vietcombank</p>
                                <p class="mb-1"><strong>Chủ tài khoản:</strong> Nguyễn Văn A</p>
                                <p class="mb-1"><strong>Số tài khoản:</strong> 0123456789</p>
                                <p class="mb-0"><strong>QR:</strong> Quét mã QR để thanh toán nhanh.</p>
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
