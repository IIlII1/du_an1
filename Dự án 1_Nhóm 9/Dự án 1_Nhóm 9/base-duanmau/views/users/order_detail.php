<<<<<<< HEAD
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
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="p-3 bg-white rounded border">
                    <h6 class="text-muted">Phương thức thanh toán</h6>
                    <p class="mb-0"><?= htmlspecialchars($order['payment_method'] ?? 'Chưa chọn') ?></p>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="p-3 bg-white rounded border">
                    <h6 class="text-muted">Trạng thái thanh toán</h6>
                    <p class="mb-0"><?= htmlspecialchars($order['payment_status'] ?? 'Chưa thanh toán') ?></p>
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
=======
<h1 class="page-title">
    Chi tiết đơn hàng
</h1>

<p class="page-description">
    Mã đơn #<?= htmlspecialchars($order['order_id'] ?? '') ?>
</p>


<div class="user-card">

    <div class="card-title">
        THÔNG TIN ĐƠN HÀNG
>>>>>>> 8c12713984b5f03d5d97580439140bfe66b2086e
    </div>

    <div class="card-body">

        <div class="table-wrapper">

            <table class="user-table">

                <tbody>

                    <tr>
                        <td style="width:180px;color:#777;">
                            Mã đơn hàng
                        </td>

                        <td>
                            #<?= htmlspecialchars(
                                $order['order_id'] ?? ''
                            ) ?>
                        </td>
                    </tr>


                    <tr>

                        <td style="color:#777;">
                            Ngày đặt
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $order['order_date']
                                ?? $order['created_at']
                                ?? $order['created_date']
                                ?? '-'
                            ) ?>
                        </td>

                    </tr>


                    <tr>

                        <td style="color:#777;">
                            Trạng thái
                        </td>

                        <td>

                            <span
                                style="
                                    display:inline-block;
                                    padding:6px 12px;
                                    border:1px solid #444;
                                    border-radius:20px;
                                    font-size:8px;
                                    color:#ccc;
                                "
                            >
                                <?= htmlspecialchars(
                                    $order['status']
                                    ?? 'Chờ xử lý'
                                ) ?>
                            </span>

                        </td>

                    </tr>


                    <tr>

                        <td style="color:#777;">
                            Tổng tiền
                        </td>

                        <td>

                            <strong
                                style="
                                    font-size:14px;
                                    color:#fff;
                                "
                            >
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

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>


<div class="user-card">

    <div class="card-title">
        SẢN PHẨM TRONG ĐƠN
    </div>

    <div class="card-body">

        <?php if (empty($details)): ?>

            <div class="empty-data">
                Không có sản phẩm trong đơn hàng.
            </div>

        <?php else: ?>

            <div class="table-wrapper">

                <table class="user-table">

                    <thead>

                        <tr>

                            <th>
                                Sản phẩm
                            </th>

                            <th>
                                Size
                            </th>

                            <th>
                                Số lượng
                            </th>

                            <th>
                                Đơn giá
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($details as $item): ?>

                        <tr>

                            <td>

                                <?= htmlspecialchars(
                                    $item['product_name']
                                    ?? '-'
                                ) ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $item['size_name']
                                    ?? $item['size']
                                    ?? '-'
                                ) ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $item['quantity']
                                    ?? 1
                                ) ?>

                            </td>


                            <td>

                                <?= number_format(
                                    (float)(
                                        $item['price']
                                        ?? $item['unit_price']
                                        ?? 0
                                    ),
                                    0,
                                    ',',
                                    '.'
                                ) ?>₫

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>

</div>


<a
    href="?mode=users&action=orders"
    class="detail-btn"
>
    ← QUAY LẠI ĐƠN HÀNG
</a>