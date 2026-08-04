<?php
$products = $data ?? [];
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<div class="hero-banner" style="background-image: url('https://pbs.twimg.com/media/HOE0EpubIAAn4SG?format=jpg&name=large'); background-size: cover; background-position: center;">
    <div class="container-fluid px-3 px-lg-4">
        <div class="hero-content text-white py-5">
            <div class="product-tag">KeepSilent collection</div>
            <h1 class="hero-title">INVISIBLE FENCE</h1>
            <p class="hero-subtitle">Available on our website on July 31 at 9:00 AM</p>
            <a href="#featured-products" class="btn btn-light hero-button">COLLECTIONS</a>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 py-5" id="featured-products">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row gap-3">
        <div>
            <img src="https://inwfile.com/s-gn/_webp_max_images/1024/1024/yx/io/9u.webp" width="80px" alt="">
            <h2 class="font-weight-bold">|NEW ARRIVALS</h2>
            <p class="text-muted">INVISIBLE FENCE</p>
        </div>
        <?php if (!empty($_GET['q'])): ?>
            <div class="text-right">
                <p class="mb-1 text-muted">Kết quả tìm kiếm cho: <strong><?= htmlspecialchars($_GET['q']) ?></strong></p>
                <p class="mb-0 text-muted"><?= count($products) ?> sản phẩm được tìm thấy</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="product-card position-relative">
                    <?php $img = !empty($product['img']) ? BASE_ASSETS_UPLOADS . $product['img'] : 'dist/img/default-150x150.png'; $imgPath = !empty($product['img']) ? PATH_ROOT . 'assets/uploads/' . $product['img'] : ''; if (!empty($imgPath) && !file_exists($imgPath)) { $img = 'dist/img/default-150x150.png'; } ?>
                    <div class="product-thumb position-relative">
                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                        <span class="product-badge">NEW</span>
                        <div class="product-actions">
                            <form action="?mode=users&action=addWishlist" method="post" class="m-0">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                <button type="submit" class="product-action" title="Yêu thích"><i class="bi bi-heart-fill"></i></button>
                            </form>
                            <form action="?mode=client&action=addCart" method="post" class="m-0">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                <button type="submit" class="product-action" title="Thêm vào giỏ"><i class="bi bi-cart2"></i> </button>
                            </form>
                        </div>
                        <a href="?mode=client&action=productDetail&product_id=<?= $product['product_id'] ?>" class="product-quick-view">Option</a>
                    </div>
                    <div class="product-body d-flex flex-column align-items-center text-center">
                        <h5 class="product-name mb-3"><?= htmlspecialchars($product['product_name']) ?></h5>
                        <div class="mt-auto product-info-row pt-1 w-100 justify-content-center">
                            <span class="product-price"><?= number_format($product['price'], 0, ',', '.') ?>₫</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
