<?php
$products = $data ?? [];
?>
<div class="hero-banner" style="background-image: url('https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=1600&q=80'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="hero-content text-white py-5">
            <div class="product-tag">KeepSilent collection</div>
            <h1 class="hero-title">Invisible Fence</h1>
            <p class="hero-subtitle">Bộ sưu tập mới nhất lấy cảm hứng từ sự tĩnh lặng và sự bí ẩn, dành cho người yêu phong cách tối giản.</p>
            <a href="#featured-products" class="btn btn-light hero-button">Khám phá bộ sưu tập</a>
        </div>
    </div>
</div>

<div class="container py-5" id="featured-products">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="font-weight-bold">Sản phẩm nổi bật</h2>
            <p class="text-muted">Những sản phẩm mới nhất và được yêu thích nhất.</p>
        </div>
    </div>

    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 product-card shadow-sm border-0">
                    <?php $img = !empty($product['img']) ? BASE_ASSETS_UPLOADS . $product['img'] : 'dist/img/default-150x150.png'; $imgPath = !empty($product['img']) ? PATH_ROOT . 'assets/uploads/' . $product['img'] : ''; if (!empty($imgPath) && !file_exists($imgPath)) { $img = 'dist/img/default-150x150.png'; } ?>
                    <img src="<?= $img ?>" class="card-img-top" alt="<?= htmlspecialchars($product['product_name']) ?>" style="height:220px;object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                        <p class="card-text text-muted mb-3" style="min-height: 3rem;"><?= htmlspecialchars($product['description']) ?></p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <strong class="text-primary"><?= number_format($product['price'], 0, ',', '.') ?>₫</strong>
                                <form action="?mode=client&action=addCart" method="post">
                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Thêm vào giỏ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
