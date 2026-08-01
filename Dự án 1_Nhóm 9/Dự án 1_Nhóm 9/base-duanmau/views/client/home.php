<?php
$products = $data ?? [];
?>
<div class="container py-5">
    <h2 class="mb-4">Sản phẩm mới</h2>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php $img = !empty($product['img']) ? BASE_ASSETS_UPLOADS . $product['img'] : 'dist/img/default-150x150.png'; $imgPath = !empty($product['img']) ? PATH_ROOT . 'assets/uploads/' . $product['img'] : ''; if (!empty($imgPath) && !file_exists($imgPath)) { $img = 'dist/img/default-150x150.png'; } ?>
                    <img src="<?= $img ?>" class="card-img-top" alt="<?= htmlspecialchars($product['product_name']) ?>" style="height:220px;object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                        <p class="card-text text-muted"><?= htmlspecialchars($product['description']) ?></p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <strong><?= number_format($product['price'], 0, ',', '.') ?>₫</strong>
                            <form action="?mode=client&action=addCart" method="post">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                <button type="submit" class="btn btn-sm btn-primary">Thêm vào giỏ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
