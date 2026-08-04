<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; min-height: 100vh; background: #f7f2e9; color: #111; font-family: 'Inter', Arial, sans-serif; font-size: 16px; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Space Grotesk', 'Inter', sans-serif; margin: 0; }
        .site-header { position: fixed; top: 1rem; left: 50%; transform: translateX(-50%); width: min(1200px, calc(100% - 2rem)); z-index: 2000; padding: 0; }
        .site-header .header-panel { background: rgba(255,255,255,0.95); border-radius: 80px; border: 1px solid rgba(0,0,0,0.08); box-shadow: 0 28px 50px rgba(0,0,0,0.08); backdrop-filter: blur(18px); padding: .85rem 1.4rem; display: flex; align-items: center; justify-content: space-between; }
        .site-header .brand { font-family: 'Space Grotesk', 'Inter', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; color: #111; }
        .site-header .brand span { font-weight: 900; letter-spacing: .35em; }
        .site-header .nav-group { display: flex; align-items: center; gap: .6rem; }
        .site-header .header-link, .site-header .header-chip, .site-header .icon-link { display: inline-flex; align-items: center; justify-content: center; padding: .72rem 1.1rem; border-radius: 999px; font-size: .8rem; text-transform: uppercase; letter-spacing: .16em; transition: background .25s ease, transform .25s ease, color .25s ease; }
        .site-header .header-link { color: #111; background: rgba(255,255,255,0.94); border: 1px solid rgba(0,0,0,0.12); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .site-header .header-link:hover { background: rgba(17,17,17,0.95); color: #fff; transform: translateY(-1px); text-decoration: none; }
        .site-header .header-link.active { background: #111; color: #fff; }
        .site-header .search-form { display: flex; align-items: center; gap: .35rem; padding: .5rem .75rem; border-radius: 999px; background: rgba(255,255,255,0.92); border: 1px solid rgba(0,0,0,0.12); }
        .site-header .search-input { width: 180px; border: none; background: transparent; outline: none; color: #111; font-size: .85rem; }
        .site-header .search-input::placeholder { color: rgba(17,17,17,0.6); }
        .site-header .search-button { border: none; background: transparent; color: #111; cursor: pointer; font-size: 1rem; }
        .site-header .header-chip { background: rgba(17,17,17,0.08); color: #111; border: 1px solid rgba(0,0,0,0.08); font-weight: 700; }
        .site-header .icon-link { min-width: 46px; background: rgba(255,255,255,0.95); border: 1px solid rgba(0,0,0,0.1); color: #111; font-size: 1rem; }
        .site-header .icon-link:hover { background: rgba(17,17,17,0.95); color: #fff; transform: translateY(-1px); text-decoration: none; }
        .site-header .login-button { color: #111; background: #fff; border: 1px solid rgba(0,0,0,0.14); box-shadow: 0 14px 30px rgba(0,0,0,0.08); padding: .72rem 1.25rem; border-radius: 999px; font-weight: 700; text-decoration: none; }
        .site-header .login-button:hover { background: #111; color: #fff; }
        .site-header .header-actions { display: flex; align-items: center; gap: .75rem; }
        .hero-banner { min-height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden; }
        .hero-banner::before { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(17,17,17,.2) 0%, rgba(17,17,17,.72) 100%); }
        .hero-content { position: relative; z-index: 2; max-width: 720px; padding-top: 120px; }
        .hero-title { font-size: clamp(3.4rem, 6vw, 5.25rem); line-height: .92; font-weight: 800; letter-spacing: -.03em; margin-bottom: 1rem; color: #f4efe6; }
        .hero-subtitle { font-size: 1.05rem; color: rgba(244,239,230,.88); margin-bottom: 1.8rem; max-width: 580px; }
        .hero-button { border-radius: 999px; padding: 14px 32px; font-weight: 700; background: rgba(255,255,255,0.94); color: #111; border: none; box-shadow: 0 18px 35px rgba(0,0,0,0.12); }
        .hero-button:hover { background: #111; color: #fff; }
        main { padding-top: 160px; }
        .product-card { border: 1px solid #f0f0f0; border-radius: 0; overflow: hidden; transition: none; background: #fff; }
        .product-card:hover { transform: none; box-shadow: none; }
        .product-thumb { position: relative; overflow: hidden; width: 100%; height: 280px; display: flex; align-items: center; justify-content: center; background: #fff; }
        .product-thumb img { width: 100%; height: 100%; object-fit: contain; transition: transform .35s ease; }
        .product-thumb:hover img { transform: scale(1.02); }
        .product-badge { position: absolute; top: 0; right: 0; padding: .35rem .7rem; border-radius: 0; background: #111; color: #fff; font-size: .72rem; letter-spacing: .15em; text-transform: uppercase; }
        .product-actions { position: absolute; top: 12px; left: 12px; display: flex; gap: .5rem; opacity: 0; visibility: hidden; transition: opacity .25s ease, transform .25s ease; transform: translateY(-10px); }
        .product-thumb:hover .product-actions { opacity: 1; visibility: visible; transform: translateY(0); }
        .product-quick-view { position: absolute; bottom: 16px; right: 16px; display: inline-flex; align-items: center; justify-content: center; padding: .85rem 1.1rem; border-radius: 0; background: #111; color: #fff; font-size: .82rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; text-decoration: none; opacity: 0; visibility: hidden; transition: opacity .25s ease, transform .25s ease; transform: translateY(10px); }
        .product-thumb:hover .product-quick-view { opacity: 1; visibility: visible; transform: translateY(0); }
        .product-action { width: 42px; height: 42px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.08); background: rgba(255,255,255,0.95); display: inline-flex; align-items: center; justify-content: center; color: #111; font-size: 1rem; transition: transform .2s ease, background .2s ease, color .2s ease; box-shadow: none; pointer-events: auto; }
        .product-thumb:hover .product-action { pointer-events: auto; }
        .product-action:hover { background: #111; color: #fff; transform: translateY(-2px); text-decoration: none; }
        .product-body { padding: 1.6rem 1.6rem 1.8rem; }
        .product-name { font-size: 1rem; font-weight: 700; color: #111; margin-bottom: .5rem; text-transform: uppercase; letter-spacing: .06em; }
        .product-desc { color: #777; font-size: .95rem; line-height: 1.5; min-height: 2.5rem; margin-bottom: 1rem; }
        .product-info-row { display: flex; justify-content: space-between; align-items: center; gap: .75rem; flex-wrap: wrap; }
        .product-price { font-size: 1.05rem; font-weight: 800; color: #111; }
        .product-option { border-radius: 999px; padding: .75rem 1.1rem; border: 1px solid #111; color: #111; font-size: .82rem; text-transform: uppercase; letter-spacing: .12em; transition: background .2s ease, color .2s ease, transform .2s ease, opacity .25s ease; text-decoration: none; background: rgba(255,255,255,0.95); opacity: 0; visibility: hidden; transform: translateY(10px); }
        .product-card:hover .product-option { opacity: 1; visibility: visible; transform: translateY(0); }
        .product-option:hover { background: #111; color: #fff; transform: translateY(-1px); }
        .footer { background: #111; color: #d3cfc7; }
        .footer a { color: #f6f2eb; }
    </style>
</head>
<body>
<header class="site-header">
    <div class="header-panel">
        <a href="?mode=client" class="brand">KEEP:<span>SILENT</span></a>
        <div class="nav-group">
            <a class="header-link" href="?mode=client">Home</a>
            <a class="header-link" href="?mode=client">Shop</a>
            <a class="header-link" href="?mode=client&action=checkout">Collection</a>
            <a class="header-link" href="?mode=client&action=checkout">About</a>
        </div>
        <div class="header-actions">
            <form class="search-form" action="?mode=client" method="get">
                <input type="hidden" name="mode" value="client">
                <input class="search-input" type="search" name="q" placeholder="Tìm sản phẩm" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                <button class="search-button" type="submit" title="Tìm kiếm"><i class="bi bi-search"></i></button>
            </form>
            <a class="icon-link" href="?mode=client&action=cart" title="Giỏ hàng"><i class="bi bi-cart2"></i></a>
            <?php if (!empty($_SESSION['user'])): ?>
                <a class="login-button" href="?mode=users">Tài khoản</a>
            <?php else: ?>
                <a class="login-button" href="?mode=client&action=login">Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<main class="pt-4">
    <?php
    if (!empty($view)) {
        require_once PATH_VIEW_CLIENT . $view . '.php';
    }
    ?>
</main>

<footer class="footer py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="text-white">KeepSilent</h5>
                <p>They come alive under the flash.
Reflective. Reactive. Remarkable.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h6 class="text-white">Liên hệ</h6>
                <p>0335919904<br>support@keepsilent.vn</p>
            </div>
            <div class="col-md-4 mb-4">
                <h6 class="text-white">Chính sách</h6>
                <ul class="list-unstyled">
                    <li><a href="#">Chính sách đổi trả</a></li>
                    <li><a href="#">Vận chuyển</a></li>
                    <li><a href="#">Bảo mật</a></li>
                </ul>
            </div>
        </div>
        <div class="text-center pt-3 border-top border-secondary">© 2026 keepsilent. Bản quyền thuộc về Shop.</div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
