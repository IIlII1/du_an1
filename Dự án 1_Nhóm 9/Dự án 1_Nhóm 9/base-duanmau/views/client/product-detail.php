<?php
$product = $product ?? [];

$productId = $product['product_id']
    ?? $product['id']
    ?? 0;

$productName = $product['product_name']
    ?? $product['name']
    ?? 'Product';

$price = $product['price']
    ?? 0;

$image = $product['img']
    ?? $product['image']
    ?? $product['image_url']
    ?? '';

$description = $product['description']
    ?? '';

$category = $product['category_name']
    ?? $product['category']
    ?? '';


if (empty($image)) {
    $image = BASE_ASSETS_UPLOADS . 'no-image.jpg';
} elseif (
    !str_starts_with($image, 'http://') &&
    !str_starts_with($image, 'https://') &&
    !str_starts_with($image, '/')
) {
    // Ảnh được lưu dạng tương đối (vd: products/xxx.jpg)
    // -> dựng URL đầy đủ từ thư mục uploads
    $image = BASE_ASSETS_UPLOADS . ltrim($image, '/');
}


$sizes = $sizes ?? [];

?>

<style>

* {
    box-sizing: border-box;
}

.product-detail-page {
    width: 100%;
    min-height: calc(100vh - 80px);
    background: #fff;
    color: #171717;
}

.product-detail-container {
    width: 100%;
    display: grid;
    grid-template-columns: 64% 36%;
    min-height: calc(100vh - 80px);
}

.product-gallery {
    width: 100%;
    min-height: 850px;
    background: #f7f7f7;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.gallery-main {
    width: 100%;
}

.product-main-image {
    width: 100%;
    height: 790px;
    object-fit: contain;
    display: block;
}

.gallery-thumbs {
    position: absolute;
    left: 30px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 5;
}

.gallery-thumb {
    width: 70px;
    height: 70px;
    border: 2px solid transparent;
    background: #fff;
    cursor: pointer;
    overflow: hidden;
    padding: 0;
    transition: border-color .2s;
}

.gallery-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.gallery-thumb:hover,
.gallery-thumb.active {
    border-color: #111;
}

@media (max-width: 900px) {

    .product-gallery {
        min-height: 550px;
    }

    .product-main-image {
        height: 520px;
    }

    .gallery-thumbs {
        position: static;
        transform: none;
        flex-direction: row;
        justify-content: center;
        margin-top: 10px;
        padding-bottom: 15px;
    }

}


.product-info {
    padding: 55px 70px 60px 45px;
    background: #fff;
}

.product-new {
    color: #e50000;
    font-size: 10px;
    margin-bottom: 25px;
    text-transform: uppercase;
}

.product-name {
    font-size: 22px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0 0 32px;
    text-transform: uppercase;
}

.product-price {
    font-size: 14px;
    margin-bottom: 32px;
}


.size-title {
    font-size: 11px;
    margin-bottom: 12px;
}

.size-list {
    display: flex;
    gap: 10px;
    margin-bottom: 30px;
}

.size-btn {
    width: 62px;
    height: 62px;
    border: 1px solid #ddd;
    background: #fff;
    cursor: pointer;
    position: relative;
    font-size: 12px;
    transition: .2s;
}

.size-btn:hover {
    border-color: #111;
}

.size-btn.active {
    border: 2px solid #111;
}

.size-btn.disabled {
    color: #aaa;
    background: #eee;
    cursor: not-allowed;
}

.size-btn.disabled::after {
    content: "";
    position: absolute;
    width: 1px;
    height: 80px;
    background: #aaa;
    transform: rotate(-45deg);
    top: -10px;
    left: 30px;
}


.quantity-box {
    display: flex;
    align-items: center;
    gap: 22px;
    margin-bottom: 25px;
}

.quantity-btn {
    width: 40px;
    height: 40px;
    border: 1px solid #ddd;
    background: #fff;
    border-radius: 50%;
    cursor: pointer;
    font-size: 15px;
}

.quantity-number {
    font-size: 13px;
    min-width: 15px;
    text-align: center;
}


.add-cart-btn {
    width: 100%;
    height: 55px;
    border: none;
    border-radius: 30px;
    background: #241000;
    color: #fff;
    cursor: pointer;
    font-size: 13px;
    transition: .2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.add-cart-btn:hover {
    background: #000;
}

.add-cart-btn svg {
    width: 18px;
    height: 18px;
}


.product-extra {
    margin-top: 50px;
}

.extra-row {
    border-top: 1px solid #eee;
    min-height: 80px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
}

.extra-row:last-child {
    border-bottom: 1px solid #eee;
}

.extra-title {
    font-size: 11px;
}

.extra-arrow {
    font-size: 20px;
    font-weight: 300;
}

.extra-content {
    display: none;
    padding: 0 0 25px;
    color: #666;
    font-size: 12px;
    line-height: 1.8;
}

.extra-row.open + .extra-content {
    display: block;
}

.product-category {
    display: inline-block;
    margin-top: 25px;
    padding: 8px 16px;
    background: #241000;
    color: white;
    border-radius: 20px;
    font-size: 9px;
    text-transform: uppercase;
}

.related-section {
    padding: 60px max(25px, 5vw);
    background: #fff;
    border-top: 1px solid #eee;
}

.related-heading {
    text-align: center;
    margin-bottom: 35px;
}

.related-heading h2 {
    font-size: 24px;
    font-weight: 800;
    letter-spacing: .15em;
    text-transform: uppercase;
    margin-bottom: 6px;
}

.related-heading span {
    font-size: 12px;
    color: #888;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
    max-width: 1400px;
    margin: 0 auto;
}

.related-card {
    text-decoration: none;
    color: #171717;
    display: block;
    transition: transform .2s;
}

.related-card:hover {
    transform: translateY(-4px);
    text-decoration: none;
    color: #171717;
}

.related-thumb {
    width: 100%;
    aspect-ratio: 1 / 1;
    background: #f7f7f7;
    overflow: hidden;
    margin-bottom: 14px;
}

.related-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.related-card h3 {
    font-size: 13px;
    font-weight: 700;
    letter-spacing: .05em;
    text-transform: uppercase;
    margin-bottom: 6px;
    line-height: 1.4;
}

.related-price {
    font-size: 13px;
    color: #555;
}

@media (max-width: 900px) {

    .product-detail-container {
        grid-template-columns: 1fr;
    }

    .product-gallery {
        min-height: 550px;
    }

    .product-main-image {
        height: 550px;
    }

    .product-info {
        padding: 40px 25px;
    }

    .related-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

}

</style>


<div class="product-detail-page">

    <div class="product-detail-container">


        <div class="product-gallery">

            <div class="gallery-main">
                <img
                    src="<?= htmlspecialchars($image) ?>"
                    alt="<?= htmlspecialchars($productName) ?>"
                    class="product-main-image"
                    id="mainProductImage"
                >
            </div>

            <?php if (!empty($productImages)): ?>
                <div class="gallery-thumbs">
                    <button
                        type="button"
                        class="gallery-thumb active"
                        data-src="<?= htmlspecialchars($image) ?>"
                    >
                        <img src="<?= htmlspecialchars($image) ?>" alt="Ảnh chính">
                    </button>
                    <?php foreach ($productImages as $pi): ?>
                        <?php
                        $piUrl = $pi['img_url'] ?? '';
                        if (empty($piUrl)) { continue; }
                        if (!str_starts_with($piUrl, 'http://') && !str_starts_with($piUrl, 'https://') && !str_starts_with($piUrl, '/')) {
                            $piUrl = BASE_ASSETS_UPLOADS . ltrim($piUrl, '/');
                        }
                        ?>
                        <button
                            type="button"
                            class="gallery-thumb"
                            data-src="<?= htmlspecialchars($piUrl) ?>"
                        >
                            <img src="<?= htmlspecialchars($piUrl) ?>" alt="Ảnh phụ">
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>


        <div class="product-info">

            <div class="product-new">
                NEW
            </div>


            <h1 class="product-name">
                <?= htmlspecialchars($productName) ?>
            </h1>


            <div class="product-price">

                ₫ <?= number_format(
                    (float)$price,
                    0,
                    ',',
                    '.'
                ) ?>

            </div>


            <?php if (!empty($sizes)): ?>

                <div class="size-title">
                    SIZE
                </div>

                <div class="size-list">

                    <?php foreach ($sizes as $size): ?>

                        <?php

                        $sizeId = $size['size_id']
                            ?? $size['id']
                            ?? 0;

                        $sizeName = $size['size_name']
                            ?? $size['name']
                            ?? $size['size']
                            ?? '';

                        $quantity = $size['quantity']
                            ?? 0;

                        ?>

                        <button
                            type="button"
                            class="size-btn <?= $quantity <= 0 ? 'disabled' : '' ?>"
                            data-size="<?= $sizeId ?>"
                            <?= $quantity <= 0 ? 'disabled' : '' ?>
                        >
                            <?= htmlspecialchars($sizeName) ?>
                        </button>

                    <?php endforeach; ?>

                </div>

            <?php else: ?>

                <?php $fallbackSizes = $allSizes ?? []; ?>

                <div class="size-title">
                    SIZE
                </div>

                <div class="size-list">

                    <?php if (!empty($fallbackSizes)): ?>
                        <?php $isFirst = true; ?>
                        <?php foreach ($fallbackSizes as $fsize): ?>
                            <button
                                type="button"
                                class="size-btn <?= $isFirst ? 'active' : '' ?>"
                                data-size="<?= (int) ($fsize['size_id'] ?? 0) ?>"
                            >
                                <?= htmlspecialchars($fsize['size_name'] ?? '') ?>
                            </button>
                            <?php $isFirst = false; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <button
                            type="button"
                            class="size-btn active"
                        >
                            S
                        </button>

                        <button
                            type="button"
                            class="size-btn"
                        >
                            M
                        </button>

                        <button
                            type="button"
                            class="size-btn"
                        >
                            L
                        </button>

                        <button
                            type="button"
                            class="size-btn"
                        >
                            XL
                        </button>
                    <?php endif; ?>

                </div>

            <?php endif; ?>


            <div class="quantity-box">

                <button
                    type="button"
                    class="quantity-btn"
                    id="minusBtn"
                >
                    −
                </button>

                <span
                    class="quantity-number"
                    id="quantityNumber"
                >
                    1
                </span>

                <button
                    type="button"
                    class="quantity-btn"
                    id="plusBtn"
                >
                    +
                </button>

            </div>


<form
                method="POST"
                action="?mode=client&action=addCart"
                id="cartForm"
                class="add-to-cart-form"
            >

                <input
                    type="hidden"
                    name="product_id"
                    value="<?= (int)$productId ?>"
                >

                <input
                    type="hidden"
                    name="size_id"
                    id="selectedSize"
                    value=""
                >

                <input
                    type="hidden"
                    name="quantity"
                    id="selectedQuantity"
                    value="1"
                >

                <button
                    type="submit"
                    class="add-cart-btn"
                >

                    Add to cart

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >

                        <path
                            d="M3 3h2l2.5 12h10l3-9H6"
                        />

                        <circle
                            cx="10"
                            cy="19"
                            r="1"
                        />

                        <circle
                            cx="18"
                            cy="19"
                            r="1"
                        />

                    </svg>

                </button>

            </form>


            <div class="product-extra">



                <div
                    class="extra-row"
                    onclick="toggleExtra(this)"
                >

                    <span class="extra-title">
                        Product details
                    </span>

                    <span class="extra-arrow">
                        →
                    </span>

                </div>

                <div class="extra-content">

                    <?php if (!empty($description)): ?>

                        <?= nl2br(
                            htmlspecialchars($description)
                        ) ?>

                    <?php else: ?>

                        <?= htmlspecialchars($productName) ?>

                        <br>

                        KEEPSILENT collection.

                        <br>

                        Designed for everyday wear.

                    <?php endif; ?>

                </div>


                <div
                    class="extra-row"
                    onclick="toggleExtra(this)"
                >

                    <span class="extra-title">
                        Payment methods
                    </span>

                    <span class="extra-arrow">
                        →
                    </span>

                </div>

                <div class="extra-content">
                    Payment methods
                    Because this store uses the LnwPay payment system, the recipient's name for all online payment methods, including the bank account name, is LNW Co., Ltd. (the LnwPay service provider). Please rest assured that you are paying this store directly and your purchase is protected by LnwPay.

                </div>


            </div>


            <?php if (!empty($category)): ?>

                <div class="product-category">

                    <?= htmlspecialchars($category) ?>

                </div>

            <?php endif; ?>


</div>

    </div>

</div>


<?php if (!empty($relatedProducts)): ?>
<div class="related-section">
    <div class="related-heading">
        <h2>Related products</h2>
    </div>
    <div class="related-grid">
        <?php foreach ($relatedProducts as $rp): ?>
            <?php
            $rpImg = $rp['img'] ?? '';
            if (empty($rpImg)) {
                $rpImg = BASE_ASSETS_UPLOADS . 'no-image.jpg';
            } elseif (!str_starts_with($rpImg, 'http://') && !str_starts_with($rpImg, 'https://') && !str_starts_with($rpImg, '/')) {
                $rpImg = BASE_ASSETS_UPLOADS . ltrim($rpImg, '/');
            }
            ?>
            <a href="?mode=client&action=productDetail&product_id=<?= (int) $rp['product_id'] ?>" class="related-card">
                <div class="related-thumb">
                    <img src="<?= htmlspecialchars($rpImg) ?>" alt="<?= htmlspecialchars($rp['product_name']) ?>">
                </div>
                <h3><?= htmlspecialchars($rp['product_name']) ?></h3>
                <p class="related-price">₫ <?= number_format((float) $rp['price'], 0, ',', '.') ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>


<?php if (!empty($recentlyViewedProducts) && count($recentlyViewedProducts) > 1): ?>
<div class="related-section">
    <div class="related-heading">
        <h2>Recently viewed</h2>
    </div>
    <div class="related-grid">
        <?php foreach ($recentlyViewedProducts as $rv): ?>
            <?php if ((int) $rv['product_id'] === (int) $productId) { continue; } ?>
            <?php
            $rvImg = $rv['img'] ?? '';
            if (empty($rvImg)) {
                $rvImg = BASE_ASSETS_UPLOADS . 'no-image.jpg';
            } elseif (!str_starts_with($rvImg, 'http://') && !str_starts_with($rvImg, 'https://') && !str_starts_with($rvImg, '/')) {
                $rvImg = BASE_ASSETS_UPLOADS . ltrim($rvImg, '/');
            }
            ?>
            <a href="?mode=client&action=productDetail&product_id=<?= (int) $rv['product_id'] ?>" class="related-card">
                <div class="related-thumb">
                    <img src="<?= htmlspecialchars($rvImg) ?>" alt="<?= htmlspecialchars($rv['product_name']) ?>">
                </div>
                <h3><?= htmlspecialchars($rv['product_name']) ?></h3>
                <p class="related-price">₫ <?= number_format((float) $rv['price'], 0, ',', '.') ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>


<script>

// Gallery: bấm ảnh phụ để đổi ảnh chính
const galleryThumbs =
    document.querySelectorAll('.gallery-thumb');

const mainProductImage =
    document.getElementById('mainProductImage');

galleryThumbs.forEach(function(thumb) {

    thumb.addEventListener('click', function() {

        galleryThumbs.forEach(function(t) {
            t.classList.remove('active');
        });

        thumb.classList.add('active');

        if (mainProductImage && thumb.dataset.src) {
            mainProductImage.src = thumb.dataset.src;
        }

    });

});

const sizeButtons =
    document.querySelectorAll('.size-btn');

const selectedSize =
    document.getElementById('selectedSize');

sizeButtons.forEach(function(button) {

    button.addEventListener('click', function() {

        if (button.disabled) {
            return;
        }

        sizeButtons.forEach(function(btn) {
            btn.classList.remove('active');
        });

        button.classList.add('active');

        selectedSize.value =
            button.dataset.size || button.innerText.trim();

    });

});

const cartForm =
    document.getElementById('cartForm');

if (cartForm) {
    cartForm.addEventListener('submit', function(e) {
        if (!selectedSize.value) {
            e.preventDefault();
            alert('Vui lòng chọn SIZE.');
        }
    });
}

let quantity = 1;

const quantityNumber =
    document.getElementById('quantityNumber');

const selectedQuantity =
    document.getElementById('selectedQuantity');


document.getElementById('minusBtn')
    .addEventListener('click', function() {

        if (quantity > 1) {

            quantity--;

            quantityNumber.innerText =
                quantity;

            selectedQuantity.value =
                quantity;
        }

    });


document.getElementById('plusBtn')
    .addEventListener('click', function() {

        quantity++;

        quantityNumber.innerText =
            quantity;

        selectedQuantity.value =
            quantity;

    });

function toggleExtra(element) {

    element.classList.toggle('open');

}

</script>