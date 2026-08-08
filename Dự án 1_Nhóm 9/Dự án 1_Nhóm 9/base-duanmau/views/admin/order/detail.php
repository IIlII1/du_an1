<?php
?>
<div class="content-header">
    <h1>Chi tiết đơn hàng #<?= htmlspecialchars($order['order_id']) ?></h1>
</div>
<div class="content">
    <div class="card">
        <div class="card-body">
            <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['user_name']) ?> (<?= htmlspecialchars($order['user_email']) ?>)</p>
            <p><strong>Ngày đặt:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
            <p><strong>Tổng tiền:</strong> <?= number_format($order['total_money'], 0, ',', '.') ?>₫</p>
            <p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['status']) ?></p>
            <hr>
            <h5>Chi tiết sản phẩm</h5>
            <table class="table table-bordered table-striped">
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
            <a href="?mode=admin&action=orders" class="btn btn-secondary">Quay lại</a>
            <a class="btn btn-success" href="?mode=admin&action=approveOrder&id=<?= $order['order_id'] ?>">Xác nhận</a>
            <a class="btn btn-danger" href="?mode=admin&action=cancelOrder&id=<?= $order['order_id'] ?>" onclick="return confirm('Xác nhận hủy đơn hàng này?');">Hủy</a>
        </div>
    </div>
</div>
