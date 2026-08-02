<?php
?>
<div class="card shadow-sm">
    <div class="card-header">Sản phẩm yêu thích</div>
    <div class="card-body">
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (empty($wishlist)): ?>
            <p>Chưa có sản phẩm yêu thích.</p>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Size</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($wishlist as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                            <td><?= htmlspecialchars($item['size_name']) ?></td>
                            <td>
                                <a href="?mode=users&action=removeWishlist&id=<?= $item['wishlist_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa yêu thích?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
