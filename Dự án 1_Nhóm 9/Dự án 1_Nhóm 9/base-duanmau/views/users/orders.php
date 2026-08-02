<?php
?>
<div class="card shadow-sm">
    <div class="card-header">Đơn hàng của bạn</div>
    <div class="card-body">
        <?php if (empty($orders)): ?>
            <p>Chưa có đơn hàng nào.</p>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
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
                        <tr>
                            <td><?= htmlspecialchars($order['order_id']) ?></td>
                            <td><?= htmlspecialchars($order['order_date']) ?></td>
                            <td><?= number_format($order['total_money'], 0, ',', '.') ?>₫</td>
                            <td><?= htmlspecialchars($order['status']) ?></td>
                            <td>
                                <a href="?mode=users&action=orderDetail&id=<?= $order['order_id'] ?>" class="btn btn-sm btn-info">Xem</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
