<h1 class="page-title">
    Đơn hàng
</h1>

<p class="page-description">
    Theo dõi lịch sử mua hàng của bạn.
</p>

<?php if (!empty($_SESSION['success'])): ?>

    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']) ?>
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
