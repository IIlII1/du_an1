<h1 class="page-title">
    Chi tiết đơn hàng
</h1>

<p class="page-description">
    Mã đơn #<?= htmlspecialchars($order['order_id'] ?? '') ?>
</p>


<div class="user-card">

    <div class="card-title">
        THÔNG TIN ĐƠN HÀNG
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
