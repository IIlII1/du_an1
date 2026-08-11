<?php
$cartItems = $cartItems ?? [];
$total = $total ?? 0;
$shipping = 0;
$grandTotal = $total + $shipping;
?>


<div class="cart-page">
    <div class="container">
        <!-- Header -->
        <div class="cart-header">
            <div>
                <div class="cart-breadcrumb">
                    <a href="?mode=client" class="cart-breadcrumb-link">Home</a>
                    <span style="opacity:.5;margin:0 .5rem;">/</span>
                    <a href="?mode=client&action=cart" class="cart-breadcrumb-link" style="opacity:1">Cart</a>
                </div>
                <h1 class="cart-title">Shopping Cart</h1>
                <p class="cart-count"><?= count($cartItems) ?> sản phẩm trong giỏ hàng</p>
            </div>
        </div>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success" style="border-radius:15px;"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger" style="border-radius:15px;"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (empty($cartItems)): ?>
            <div class="text-center py-5">
                <i class="bi bi-bag" style="font-size:4rem;opacity:.3;"></i>
                <h3 class="mt-3 font-weight-bold" style="letter-spacing:.06em;">Giỏ hàng đang trống</h3>
                <p class="text-muted">Hãy thêm một vài sản phẩm yêu thích vào giỏ nhé!</p>
                <a href="?mode=client" class="btn btn-black" style="display:inline-block;width:auto;padding:.9rem 2.5rem;">Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <div class="row">
                <!-- Danh sách sản phẩm -->
                <div class="col-lg-8">
                    <form action="?mode=client&action=updateCart" method="post" id="cart-form">
                        <div class="cart-items-card">
                            <?php foreach ($cartItems as $item): ?>
                                <div class="cart-item">
                                    <div class="cart-item-thumb">
                                        <?php
                                        $img = !empty($item['img']) ? BASE_ASSETS_UPLOADS . $item['img'] : 'dist/img/default-150x150.png';
                                        $imgPath = !empty($item['img']) ? PATH_ROOT . 'assets/uploads/' . $item['img'] : '';
                                        if (!empty($imgPath) && !file_exists($imgPath)) { $img = 'dist/img/default-150x150.png'; }
                                        ?>
                                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                                    </div>
<div class="cart-item-details">
                                        <div class="cart-item-top">
                                            <div>
                                                <h4 class="cart-item-name"><?= htmlspecialchars($item['product_name']) ?></h4>
                                                <div class="cart-item-subtitle text-muted">
                                                    <?php if (!empty($item['size_name'])): ?>
                                                        <span class="badge badge-dark mr-2">Size: <?= htmlspecialchars($item['size_name']) ?></span>
                                                    <?php endif; ?>
                                                    Đơn giá: <strong><?= number_format($item['price'], 0, ',', '.') ?>₫</strong>
                                                </div>
                                            </div>
                                            <a href="?mode=client&action=removeCart&key=<?= urlencode($item['key']) ?>" class="cart-remove" title="Xóa sản phẩm">
                                                <i class="bi bi-trash3"></i>
                                            </a>
                                        </div>
                                        <div class="cart-item-meta">
                                            <div class="cart-quantity">
                                                <label>Số lượng</label>
                                                <div class="qty-control">
                                                    <button type="button" class="qty-btn qty-minus" data-key="<?= urlencode($item['key']) ?>">−</button>
                                                    <input type="number" name="quantity[<?= htmlspecialchars($item['key']) ?>]" value="<?= $item['quantity'] ?>" min="1" class="qty-input">
                                                    <button type="button" class="qty-btn qty-plus" data-key="<?= urlencode($item['key']) ?>">+</button>
                                                </div>
                                            </div>
<div class="cart-item-total">
                                                <span class="text-muted" style="font-size:.85rem;font-weight:400;">Tạm tính:</span>
                                                <br>
                                                <span class="line-total" data-key="<?= htmlspecialchars($item['key']) ?>"><?= number_format($item['line_total'], 0, ',', '.') ?>₫</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="cart-form-row mt-3">
                            <button type="submit" class="btn btn-outline-dark" style="border-radius:999px;padding:.9rem 1.8rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;font-size:.85rem;">
                                <i class="bi bi-arrow-repeat mr-1"></i> Cập nhật giỏ hàng
                            </button>
                            <a href="?mode=client" class="btn btn-link text-muted" style="text-decoration:none;font-weight:600;">← Tiếp tục mua sắm</a>
                        </div>
                    </form>
                </div>

                <!-- Tóm tắt đơn hàng -->
                <div class="col-lg-4">
                    <div class="cart-summary-card">
                        <div class="summary-header">
                            <span class="summary-label">Tóm tắt đơn hàng</span>
                            <i class="bi bi-receipt" style="font-size:1.3rem;"></i>
                        </div>
                        <div class="summary-value" id="cart-total"><?= number_format($total, 0, ',', '.') ?>₫</div>
                        <div class="summary-meta">
                            <div><span>Tạm tính</span><span id="cart-subtotal"><?= number_format($total, 0, ',', '.') ?>₫</span></div>
                            <div><span>Phí vận chuyển</span><span>Miễn phí</span></div>
                        </div>
                        <div class="summary-total">
                            <span>Tổng cộng</span>
                            <span id="cart-grand-total"><?= number_format($grandTotal, 0, ',', '.') ?>₫</span>
                        </div>
                        <a href="?mode=client&action=checkout" class="btn btn-black">
                            <i class="bi bi-lock mr-1"></i> Tiến hành thanh toán
                        </a>
                    </div>

                    <div class="cart-policy-card">
                        <h5 class="policy-header"><i class="bi bi-shield-check mr-1"></i> Chính sách mua hàng</h5>
                        <div class="summary-meta" style="border-top:none;padding-top:0;margin-bottom:0;">
                            <div><span>🚚 Giao hàng nhanh</span></div>
                            <div><span>🔄 Đổi trả trong 7 ngày</span></div>
                            <div><span>🔒 Thanh toán an toàn</span></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.qty-control { display:inline-flex; align-items:center; border:1px solid rgba(0,0,0,.12); border-radius:999px; overflow:hidden; }
.qty-btn { width:38px; height:38px; border:none; background:transparent; font-size:1.1rem; cursor:pointer; color:#111; transition:background .2s; }
.qty-btn:hover { background:rgba(0,0,0,.06); }
.qty-input { width:44px; border:none; text-align:center; font-weight:700; outline:none; padding:0; height:38px; font-size:.95rem; }
.qty-input::-webkit-outer-spin-button,
.qty-input::-webkit-inner-spin-button { -webkit-appearance:none; margin:0; }
.qty-input[type=number] { -moz-appearance:textfield; }
.cart-item-thumb { min-width: 90px; min-height: 90px; max-width: 90px; width: 90px; }
.cart-item-thumb img { width: 100%; height: 100%; object-fit: contain; }
</style>

<script>
function formatVND(n) {
    return Number(n).toLocaleString('vi-VN') + '₫';
}

function updateCartTotals(data) {
    $('#cart-total').text(formatVND(data.total));
    $('#cart-subtotal').text(formatVND(data.total));
    $('#cart-grand-total').text(formatVND(data.total));
    if (data.key) {
        $('.line-total[data-key="' + data.key + '"]').text(formatVND(data.lineTotal));
    }
    $('.cart-badge').text(data.cartCount).removeClass('d-none');
}

$(document).ready(function () {
    // Tăng giảm số lượng (AJAX, cập nhật ngay lập tức)
    $(document).on('click', '.qty-btn', function () {
        var $btn = $(this);
        var $input = $btn.closest('.qty-control').find('.qty-input');
        var key = $btn.data('key');
        var current = parseInt($input.val() || 1);
        var newQty = $btn.hasClass('qty-plus') ? current + 1 : Math.max(1, current - 1);

        $input.val(newQty);

        var payload = {};
        payload[key] = newQty;

        $.ajax({
            url: '?mode=client&action=updateCart',
            type: 'POST',
            data: { quantity: payload },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function (response) {
                if (response.success) {
                    response.key = key;
                    updateCartTotals(response);
                }
            }
        });
    });

    // Giữ nguyên form submit cập nhật giỏ hàng (load lại trang)
});
</script>
