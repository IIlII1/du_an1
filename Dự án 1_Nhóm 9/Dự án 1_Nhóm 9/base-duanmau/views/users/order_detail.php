<?php
?>
<div class="card shadow-sm">
    <div class="card-header">Chi tiết đơn hàng #<?= htmlspecialchars($order['order_id']) ?></div>
    <div class="card-body">
        <p><strong>Ngày:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
        <p><strong>Tổng tiền:</strong> <?= number_format($order['total_money'], 0, ',', '.') ?>₫</p>
        <p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['status']) ?></p>
        <hr>
        <h5>Chi tiết sản phẩm</h5>
        <?php if (empty($details)): ?>
            <p>Không có chi tiết đơn hàng.</p>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
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
        <?php endif; ?>
    </div>
</div>
