<?php
$statusClassMap = [
    'Chờ xác nhận' => 'badge-warning',
    'Đã xác nhận' => 'badge-info',
    'Đang giao' => 'badge-primary',
    'Hoàn thành' => 'badge-success',
    'Đã hủy' => 'badge-danger',
];
$badgeClass = $statusClassMap[$order['status']] ?? 'badge-secondary';
?>
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0">
        <h3 class="mb-0">Chi tiết đơn hàng #<?= htmlspecialchars($order['order_id']) ?></h3>
        <span class="badge badge-pill <?= $badgeClass ?> py-2 px-3"><?= htmlspecialchars($order['status']) ?></span>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="bg-light rounded p-3 h-100">
                    <h6 class="text-muted">Ngày đặt</h6>
                    <p class="mb-0"><?= htmlspecialchars($order['order_date']) ?></p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="bg-light rounded p-3 h-100">
                    <h6 class="text-muted">Tổng tiền</h6>
                    <p class="mb-0 font-weight-bold"><?= number_format($order['total_money'], 0, ',', '.') ?>₫</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="bg-light rounded p-3 h-100">
                    <h6 class="text-muted">Người mua</h6>
                    <p class="mb-0"><?= htmlspecialchars($order['user_name'] ?? 'N/A') ?></p>
                </div>
            </div>
        </div>
        <h5 class="mb-3">Chi tiết sản phẩm</h5>
        <?php if (empty($details)): ?>
            <div class="alert alert-info">Không có chi tiết đơn hàng.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Size</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($details as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['product_name']) ?></td>
                                <td><?= htmlspecialchars($item['size_name']) ?></td>
                                <td><?= htmlspecialchars($item['quantity']) ?></td>
                                <td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <a href="?mode=users&action=orders" class="btn btn-secondary mt-4">Quay lại đơn hàng</a>
    </div>
</div>
