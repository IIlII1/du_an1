<?php
?>
<div class="content-header">
    <h1>Quản lý đơn hàng</h1>
</div>
<div class="content">
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['admin_error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['admin_error']); unset($_SESSION['admin_error']); ?></div>
    <?php endif; ?>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
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
                        <tr>
                            <td>#<?= htmlspecialchars($order['order_id']) ?></td>
                            <td><?= htmlspecialchars($order['user_name']) ?></td>
                            <td><?= htmlspecialchars($order['user_email']) ?></td>
                            <td><?= htmlspecialchars($order['order_date']) ?></td>
                            <td><?= number_format($order['total_money'], 0, ',', '.') ?>₫</td>
                            <td><?= htmlspecialchars($order['status']) ?></td>
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
