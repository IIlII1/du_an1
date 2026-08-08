<?php
$statusClassMap = [
    'Chờ xác nhận' => 'badge-warning',
    'Đã xác nhận' => 'badge-info',
    'Đang giao' => 'badge-primary',
    'Hoàn thành' => 'badge-success',
    'Đã hủy' => 'badge-danger',
];
?>
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0">
        <h3 class="mb-0">Đơn hàng của bạn</h3>
        <p class="text-muted mb-0">Kiểm tra trạng thái và xem chi tiết mỗi đơn hàng.</p>
    </div>
    <div class="card-body">
        <?php if (empty($orders)): ?>
            <div class="alert alert-info mb-0">Chưa có đơn hàng nào.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Ngày</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <?php $badgeClass = $statusClassMap[$order['status']] ?? 'badge-secondary'; ?>
                            <tr>
                                <td>#<?= htmlspecialchars($order['order_id']) ?></td>
                                <td><?= htmlspecialchars($order['order_date']) ?></td>
                                <td><?= number_format($order['total_money'], 0, ',', '.') ?>₫</td>
                                <td><span class="badge badge-pill <?= $badgeClass ?>"><?= htmlspecialchars($order['status']) ?></span></td>
                                <td>
                                    <a href="?mode=users&action=orderDetail&id=<?= $order['order_id'] ?>" class="btn btn-sm btn-info">Xem</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
