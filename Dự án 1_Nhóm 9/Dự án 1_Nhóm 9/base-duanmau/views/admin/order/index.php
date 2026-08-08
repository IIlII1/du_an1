<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f1f5f9;
        }
        .admin-order-table th,
        .admin-order-table td {
            vertical-align: middle;
            white-space: nowrap;
        }
        .admin-order-table tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }
        .admin-order-actions .btn {
            margin-right: 0.35rem;
            margin-bottom: 0.25rem;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="mb-4">
        <h1 class="h3 font-weight-bold">Quản lý đơn hàng</h1>
        <p class="text-muted">Danh sách đơn hàng mới nhất và thao tác duyệt đơn.</p>
    </div>
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success shadow-sm"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['admin_error'])): ?>
        <div class="alert alert-danger shadow-sm"><?php echo htmlspecialchars($_SESSION['admin_error']); unset($_SESSION['admin_error']); ?></div>
    <?php endif; ?>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 admin-order-table">
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
                                <td>
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <span class="badge badge-pill <?= $badgeClass ?>"><?= htmlspecialchars($order['status']) ?></span>
                                        <span class="badge badge-pill badge-light text-dark"><?= htmlspecialchars($order['payment_status'] ?? 'Chưa thanh toán') ?></span>
                                    </div>
                                </td>
                                <td class="admin-order-actions">
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
</body>
</html>
