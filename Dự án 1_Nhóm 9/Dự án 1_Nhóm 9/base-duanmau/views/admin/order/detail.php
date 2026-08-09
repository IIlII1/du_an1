<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .admin-order-detail .info-card {
            min-height: 135px;
        }
        .admin-order-detail .order-summary {
            gap: 1rem;
        }
        .admin-order-detail .order-actions .btn {
            margin-right: 0.75rem;
            margin-bottom: 0.5rem;
        }
        .admin-order-detail .payment-info {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-4">
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
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Size</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($details as $item): ?>
                            <?php
                            $img = !empty($item['img']) ? BASE_ASSETS_UPLOADS . $item['img'] : 'dist/img/default-150x150.png';
                            $imgPath = !empty($item['img']) ? PATH_ROOT . 'assets/uploads/' . $item['img'] : '';
                            if (!empty($imgPath) && !file_exists($imgPath)) {
                                $img = 'dist/img/default-150x150.png';
                            }
                            ?>
                            <tr>
                                <td style="width: 100px;">
                                    <img src="<?= $img ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="img-fluid rounded" style="max-height: 80px; object-fit: contain;">
                                </td>
                                <td><?= htmlspecialchars($item['product_name']) ?></td>
                                <td><?= htmlspecialchars($item['size_name']) ?></td>
                                <td><?= htmlspecialchars($item['quantity']) ?></td>
                                <td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4 order-actions">
                <a href="?mode=admin&action=orders" class="btn btn-secondary">Quay lại</a>
                <a class="btn btn-success" href="?mode=admin&action=approveOrder&id=<?= $order['order_id'] ?>">Xác nhận</a>
                <a class="btn btn-danger" href="?mode=admin&action=cancelOrder&id=<?= $order['order_id'] ?>" onclick="return confirm('Xác nhận hủy đơn hàng này?');">Hủy</a>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>
