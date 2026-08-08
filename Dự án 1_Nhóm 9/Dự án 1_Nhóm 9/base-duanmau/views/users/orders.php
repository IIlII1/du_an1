<<<<<<< HEAD
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
                                <td>
                                    <span class="badge badge-pill <?= $badgeClass ?>"><?= htmlspecialchars($order['status']) ?></span>
                                    <span class="badge badge-pill badge-light text-dark ml-2"><?= htmlspecialchars($order['payment_status'] ?? 'Chưa thanh toán') ?></span>
                                </td>
                                <td>
                                    <a href="?mode=users&action=orderDetail&id=<?= $order['order_id'] ?>" class="btn btn-sm btn-info">Xem</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
=======
<h1 class="page-title">
    Đơn hàng
</h1>

<p class="page-description">
    Theo dõi lịch sử mua hàng của bạn.
</p>

<?php if (!empty($_SESSION['success'])): ?>

    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']) ?>
>>>>>>> 8c12713984b5f03d5d97580439140bfe66b2086e
    </div>

    <?php unset($_SESSION['success']); ?>

<?php endif; ?>

<?php if (!empty($_SESSION['error'])): ?>

    <div class="alert alert-danger">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>

    <?php unset($_SESSION['error']); ?>

<?php endif; ?>


<div class="user-card">

    <div class="card-title">
        LỊCH SỬ ĐƠN HÀNG
    </div>

    <div class="card-body">

        <?php if (empty($orders)): ?>

            <div class="empty-data">
                Bạn chưa có đơn hàng nào.
            </div>

        <?php else: ?>

            <div class="table-wrapper">

                <table class="user-table">

                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($orders as $order): ?>

                        <tr>

                            <td>
                                <strong>
                                    #<?= htmlspecialchars(
                                        $order['order_id'] ?? ''
                                    ) ?>
                                </strong>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $order['order_date']
                                    ?? $order['created_at']
                                    ?? $order['created_date']
                                    ?? '-'
                                ) ?>
                            </td>

                            <td>
                                <strong>
                                    <?= number_format(
                                        (float)(
                                            $order['total_money']
                                            ?? $order['total']
                                            ?? $order['total_amount']
                                            ?? 0
                                        ),
                                        0,
                                        ',',
                                        '.'
                                    ) ?>₫
                                </strong>
                            </td>

                            <td>

                                <?php
                                $status =
                                    $order['status']
                                    ?? 'Chờ xử lý';
                                ?>

                                <span
                                    style="
                                        display:inline-block;
                                        padding:6px 10px;
                                        border:1px solid #444;
                                        border-radius:20px;
                                        font-size:8px;
                                        color:#ccc;
                                    "
                                >
                                    <?= htmlspecialchars($status) ?>
                                </span>

                            </td>

                            <td>

                                <a
                                    href="?mode=users&action=orderDetail&id=<?= (int)$order['order_id'] ?>"
                                    class="detail-btn"
                                >
                                    XEM
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>

</div>