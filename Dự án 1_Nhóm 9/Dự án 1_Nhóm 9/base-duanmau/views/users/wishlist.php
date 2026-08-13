<h1 class="page-title">
    Sản phẩm yêu thích
</h1>

<p class="page-description">
    Những sản phẩm bạn đã lưu.
</p>


<?php if (!empty($_SESSION['success'])): ?>

    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>

    <?php unset($_SESSION['success']); ?>

<?php endif; ?>


<div class="user-card">

    <div class="card-title">
        WISHLIST
    </div>

    <div class="card-body">

        <?php if (empty($wishlist)): ?>

            <div class="empty-data">
                Chưa có sản phẩm yêu thích.
            </div>

        <?php else: ?>

            <div class="table-wrapper">

                <table class="user-table">

                    <thead>

                        <tr>
                            <th>Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Size</th>
                            <th>Hành động</th>
                        </tr>

                    </thead>

                    <tbody>
                        

                    <?php foreach ($wishlist as $item): ?>

                        <tr>
                            <td>
                                <img src="<?= BASE_URL . 'assets/uploads/' . $item['img'] ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $item['product_name']
                                ) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $item['product_name']
                                ) ?>
                            </td>

                            <td>
                                <?= number_format(
                                    $item['price'],
                                    0,
                                    ',',
                                    '.'
                                ) ?>₫
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $item['size_name'] ?? '-'
                                ) ?>
                            </td>

                            <td>

                                <a
                                    href="?mode=users&action=removeWishlist&id=<?= (int)$item['wishlist_id'] ?>"
                                    class="delete-btn"
                                    onclick="return confirm('Xóa sản phẩm khỏi yêu thích?')"
                                >
                                    Xóa
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