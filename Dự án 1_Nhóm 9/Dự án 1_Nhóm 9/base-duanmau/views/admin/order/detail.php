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
<div class="content-header mb-4">
    <h1 class="h3 font-weight-bold">Chi tiết đơn hàng #<?= htmlspecialchars($order['order_id']) ?></h1>
    <span class="badge badge-pill <?= $badgeClass ?> py-2 px-3"><?= htmlspecialchars($order['status']) ?></span>
</div>
<div class="content">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="p-3 bg-light rounded">
                        <h6 class="text-muted">Khách hàng</h6>
                        <p class="mb-0"><?= htmlspecialchars($order['user_name']) ?> <br><small><?= htmlspecialchars($order['user_email']) ?></small></p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-3 bg-light rounded">
                        <h6 class="text-muted">Ngày đặt</h6>
                        <p class="mb-0"><?= htmlspecialchars($order['order_date']) ?></p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-3 bg-light rounded">
                        <h6 class="text-muted">Tổng tiền</h6>
                        <p class="mb-0 font-weight-bold"><?= number_format($order['total_money'], 0, ',', '.') ?>₫</p>
                    </div>
                </div>
            </div>
            <h5 class="mb-3">Chi tiết sản phẩm</h5>
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
            <div class="mt-4">
                <a href="?mode=admin&action=orders" class="btn btn-secondary">Quay lại</a>
                <a class="btn btn-success" href="?mode=admin&action=approveOrder&id=<?= $order['order_id'] ?>">Xác nhận</a>
                <a class="btn btn-danger" href="?mode=admin&action=cancelOrder&id=<?= $order['order_id'] ?>" onclick="return confirm('Xác nhận hủy đơn hàng này?');">Hủy</a>
            </div>
        </div>
    </div>
</div>
