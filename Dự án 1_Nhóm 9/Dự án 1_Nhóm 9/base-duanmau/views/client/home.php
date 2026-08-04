<?php
$products = $data ?? [];
?>
<div class="hero-banner" style="background-image: url('https://pbs.twimg.com/media/HOE0EpubIAAn4SG?format=jpg&name=large'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="hero-content text-white py-5">
            <div class="product-tag">KeepSilent collection</div>
            <h1 class="hero-title">INVISIBLE FENCE</h1>
            <p class="hero-subtitle">Available on our website on July 31 at 9:00 AM</p>
            <a href="#featured-products" class="btn btn-light hero-button">COLLECTIONS</a>
        </div>
    </div>
</div>

<div class="container py-5" id="featured-products">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <img src="https://inwfile.com/s-gn/_webp_max_images/1024/1024/yx/io/9u.webp" width="80px" alt=""></center>
            <h2 class="font-weight-bold">|NEW ARRIVALS</h2>
            <p class="text-muted">Your loudest self doesn't have to speak.</p>
        </div>
    </div>

    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="product-card shadow-sm border-0 position-relative">
                    <?php $img = !empty($product['img']) ? BASE_ASSETS_UPLOADS . $product['img'] : 'dist/img/default-150x150.png'; $imgPath = !empty($product['img']) ? PATH_ROOT . 'assets/uploads/' . $product['img'] : ''; if (!empty($imgPath) && !file_exists($imgPath)) { $img = 'dist/img/default-150x150.png'; } ?>
                    <div class="product-thumb position-relative">
                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                        <span class="product-badge">NEW</span>
                        <div class="product-actions">
                            <a href="?mode=users&action=wishlist&product_id=<?= $product['product_id'] ?>" class="product-action" title="Yêu thích">♥</a>
                            <form action="?mode=client&action=addCart" method="post" class="m-0">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                <button type="submit" class="product-action" title="Thêm vào giỏ">🛒</button>
                            </form>
                        </div>
                    </div>
                    <div class="product-body p-4 d-flex flex-column">
                        <h5 class="product-name"><?= htmlspecialchars($product['product_name']) ?></h5>
                        <div class="mt-auto product-info-row pt-3">
                            <span class="product-price"><?= number_format($product['price'], 0, ',', '.') ?>₫</span>
                            <a href="?mode=client&action=productDetail&product_id=<?= $product['product_id'] ?>" class="product-option">+ Option</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
