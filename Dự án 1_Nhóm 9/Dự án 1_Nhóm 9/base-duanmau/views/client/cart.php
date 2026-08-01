<?php
$cartItems = $cartItems ?? [];
$total = $total ?? 0;
?>
<div class="container py-5">
    <h2 class="mb-4">Giỏ hàng của bạn</h2>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <div class="alert alert-info">Giỏ hàng đang trống.</div>
    <?php else: ?>
        <form action="?mode=client&action=updateCart" method="post" class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tạm tính</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php $img = !empty($item['img']) ? BASE_ASSETS_UPLOADS . $item['img'] : 'dist/img/default-150x150.png'; $imgPath = !empty($item['img']) ? PATH_ROOT . 'assets/uploads/' . $item['img'] : ''; if (!empty($imgPath) && !file_exists($imgPath)) { $img = 'dist/img/default-150x150.png'; } ?>
                                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" width="70" class="mr-3">
                                        <span><?= htmlspecialchars($item['product_name']) ?></span>
                                    </div>
                                </td>
                                <td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                                <td>
                                    <input type="number" name="quantity[<?= $item['product_id'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control" style="width: 90px">
                                </td>
                                <td><?= number_format($item['line_total'], 0, ',', '.') ?>₫</td>
                                <td>
                                    <a href="?mode=client&action=removeCart&id=<?= $item['product_id'] ?>" class="btn btn-sm btn-outline-danger">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-outline-primary">Cập nhật số lượng</button>
                <div class="text-right">
                    <h5 class="mb-0">Tổng tiền: <strong><?= number_format($total, 0, ',', '.') ?>₫</strong></h5>
                    <a href="?mode=client&action=checkout" class="btn btn-success mt-2">Tiến hành thanh toán</a>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>
