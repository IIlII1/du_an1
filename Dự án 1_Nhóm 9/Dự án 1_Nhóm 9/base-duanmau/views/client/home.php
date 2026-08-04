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


<div class="container-fluid px-3 px-lg-4 py-5" id="new-arrivals">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row gap-3">
        <div>
            <img src="https://inwfile.com/s-gn/_webp_max_images/1024/1024/yx/io/9u.webp" width="80px" alt="">
            <h2 class="font-weight-bold">|NEW ARRIVALS</h2>
            <p class="text-muted">INVISIBLE FENCE</p>
        </div>
    </div>

    <div class="row">
        <?php foreach ($newArrivals as $product): ?>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="product-card position-relative">
                    <?php $img = !empty($product['img']) ? BASE_ASSETS_UPLOADS . $product['img'] : 'dist/img/default-150x150.png'; $imgPath = !empty($product['img']) ? PATH_ROOT . 'assets/uploads/' . $product['img'] : ''; if (!empty($imgPath) && !file_exists($imgPath)) { $img = 'dist/img/default-150x150.png'; } ?>
                    <div class="product-thumb position-relative">
                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                        <?php if (!empty($product['category_name']) && strcasecmp($product['category_name'], 'Invisible Fence') === 0): ?>
                            <span class="product-badge">NEW</span>
                        <?php endif; ?>
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


<div class="container-fluid px-3 px-lg-4 py-5">
    <div class="hero-row text-black bg-white p-4">
        <div class="hero-text">
            <div class="hero-overline">#KEEPSILENT_INVISIBLEFENCE</div>
            <h2 class="hero-title" style="color:#111;">THIS COLLECTION IS INSPIRED BY THE COWBOY.</h2>
            <p class="hero-copy" style="color:rgba(17,17,17,0.76);">Not as someone who escaped society, but as someone who walked through it without letting it defy. Because true freedom is staying true to yourself. Featuring the Own Way Oversized Shirt, Tough Day Jeans, Night Scarf, and Night Pin Set.</p>
            <p class="hero-note" style="color:rgba(17,17,17,0.85);">Available on our website on July 31 at 9:00 AM.</p>
        </div>
        <div class="hero-visual" style="background:#8B4513;">
            <img src="https://inwfile.com/s-gn/_webp_max_images/1024/1024/8x/mw/oz.webp" alt="Collection visual">
        </div>
    </div>
</div>
<!-- banner 2 ảnh -->
<div class="banner-two-image-section">
    <div class="banner-two-image-grid">
        <div class="banner-panel banner-panel-left">
        <img src="https://pbs.twimg.com/media/HOJ-i1zbcAAFihd?format=jpg&name=large" alt="Banner image left">
        
        </div>
        <div class="banner-panel banner-panel-right">
            <img src="https://pbs.twimg.com/media/HOJ-i11aQAA0Y2C?format=jpg&name=large" alt="Banner image right">
        </div>
    </div>
</div>

<!-- All Items -->
<div class="container-fluid px-3 px-lg-4 py-5" id="all-items">
    <?php $showAll = !empty($_GET['show']) && $_GET['show'] === 'all'; ?>
    <?php $previewItems = $showAll ? $data : array_slice($data, 0, 12); ?>
    <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row gap-3">
        <div>
            <img src="https://inwfile.com/s-gn/_webp_max_images/1024/1024/s1/e1/js.webp" width="80px" alt="">
            <h2 class="font-weight-bold">|ALL ITEMS</h2>
        </div>
        <?php if (!empty($_GET['q'])): ?>
            <div class="text-right">
                <p class="mb-1 text-muted">Kết quả tìm kiếm cho: <strong><?= htmlspecialchars($_GET['q']) ?></strong></p>
                <p class="mb-0 text-muted"><?= count($data) ?> sản phẩm được tìm thấy</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="all-items-slider">
        <?php foreach ($previewItems as $product): ?>
            <div class="slider-item">
                <div class="product-card position-relative">
                    <?php $img = !empty($product['img']) ? BASE_ASSETS_UPLOADS . $product['img'] : 'dist/img/default-150x150.png'; $imgPath = !empty($product['img']) ? PATH_ROOT . 'assets/uploads/' . $product['img'] : ''; if (!empty($imgPath) && !file_exists($imgPath)) { $img = 'dist/img/default-150x150.png'; } ?>
                    <div class="product-thumb position-relative">
                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
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

    <?php if (!$showAll && count($data) > 12): ?>
        <div class="text-center mt-3">
            <a href="?mode=client&show=all" class="view-all-button">View All <span aria-hidden="true">→</span></a>
        </div>
    <?php endif; ?>
</div>

<!-- Collections -->
<div class="container-fluid px-3 px-lg-4 py-5" id="collections">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row gap-3">
        <div>
            <img src="https://gn.lnwfile.com/sc7h8m.webp" width="80px" alt="Collections icon">
            <h2 class="font-weight-bold">|COLLECTIONS</h2>
        </div>
    </div>
    <div class="collections-grid">
        <div class="collection-card">
            <img src="https://pbs.twimg.com/media/HOekYQ3agAAKjpl?format=jpg&name=large" alt="Invisible Fence">
            <div class="collection-overlay"></div>
            <div class="collection-meta">
                <span class="collection-name">INVISIBLE FENCE</span>
                <a href="?mode=client&show=all" class="collection-button">Explore <span aria-hidden="true">→</span></a>
            </div>
        </div>
        <div class="collection-card">
            <img src="https://pbs.twimg.com/media/HIrY5MpbAAIVCHX?format=jpg&name=large" alt="WishLessParty">
            <div class="collection-overlay"></div>
            <div class="collection-meta">
                <span class="collection-name">WISHLESSPARTY</span>
                <a href="?mode=client&show=all" class="collection-button">Explore <span aria-hidden="true">→</span></a>
            </div>
        </div>
        <div class="collection-card">
            <img src="https://pbs.twimg.com/media/HGKi6QlbUAA9X54?format=jpg&name=large" alt="Chaos Hotel">
            <div class="collection-overlay"></div>
            <div class="collection-meta">
                <span class="collection-name">CHAOS HOTEL</span>
                <a href="?mode=client&show=all" class="collection-button">Explore <span aria-hidden="true">→</span></a>
            </div>
        </div>
        <div class="collection-card">
            <img src="https://pbs.twimg.com/media/G_zRXYvagAANDuw?format=jpg&name=large" alt="Keep The Wonder">
            <div class="collection-overlay"></div>
            <div class="collection-meta">
                <span class="collection-name">KEEP THE WONDER</span>
                <a href="?mode=client&show=all" class="collection-button">Explore <span aria-hidden="true">→</span></a>
            </div>
        </div>
    </div>
</div>

