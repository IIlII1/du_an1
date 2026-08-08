<?php
$statusClassMap = [
    'Chờ xác nhận' => 'badge-warning',
    'Đã xác nhận' => 'badge-info',
    'Đang giao' => 'badge-primary',
    'Hoàn thành' => 'badge-success',
    'Đã hủy' => 'badge-danger',
];
?>
<div class="content-header mb-4">
    <h1 class="h3 font-weight-bold">Quản lý đơn hàng</h1>
    <p class="text-muted">Danh sách đơn hàng mới nhất và thao tác duyệt đơn.</p>
</div>
<div class="content">
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success shadow-sm"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['admin_error'])): ?>
        <div class="alert alert-danger shadow-sm"><?php echo htmlspecialchars($_SESSION['admin_error']); unset($_SESSION['admin_error']); ?></div>
    <?php endif; ?>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Email</th>
                            <th>Ngày</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <?php $badgeClass = $statusClassMap[$order['status']] ?? 'badge-secondary'; ?>
                            <tr>
                                <td>#<?= htmlspecialchars($order['order_id']) ?></td>
                                <td><?= htmlspecialchars($order['user_name']) ?></td>
                                <td><?= htmlspecialchars($order['user_email']) ?></td>
                                <td><?= htmlspecialchars($order['order_date']) ?></td>
                                <td><?= number_format($order['total_money'], 0, ',', '.') ?>₫</td>
                                <td><span class="badge badge-pill <?= $badgeClass ?>"><?= htmlspecialchars($order['status']) ?></span></td>
                                <td>
                                    <a class="btn btn-sm btn-info" href="?mode=admin&action=orderDetail&id=<?= $order['order_id'] ?>">Xem</a>
                                    <a class="btn btn-sm btn-success" href="?mode=admin&action=approveOrder&id=<?= $order['order_id'] ?>">Xác nhận</a>
                                    <a class="btn btn-sm btn-danger" href="?mode=admin&action=cancelOrder&id=<?= $order['order_id'] ?>" onclick="return confirm('Xác nhận hủy đơn hàng này?');">Hủy</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
