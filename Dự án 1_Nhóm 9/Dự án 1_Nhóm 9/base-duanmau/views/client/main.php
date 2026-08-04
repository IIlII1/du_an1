<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
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
        .site-header .header-link { color: #111; background: rgba(255,255,255,0.96); border: 1px solid rgba(0,0,0,0.12); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .site-header .header-link:hover { background: rgba(17,17,17,0.95); color: #fff; transform: translateY(-1px); text-decoration: none; }
        .site-header .header-chip { background: rgba(17,17,17,0.08); color: #111; border: 1px solid rgba(0,0,0,0.08); font-weight: 700; }
        .site-header .icon-link { min-width: 46px; background: rgba(255,255,255,0.95); border: 1px solid rgba(0,0,0,0.1); color: #111; font-size: 1rem; }
        .site-header .icon-link:hover { background: rgba(17,17,17,0.95); color: #fff; transform: translateY(-1px); text-decoration: none; }
        .hero-banner { min-height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden; }
        .hero-banner::before { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(17,17,17,.2) 0%, rgba(17,17,17,.72) 100%); }
        .hero-content { position: relative; z-index: 2; max-width: 720px; padding-top: 120px; }
        .hero-title { font-size: clamp(3.4rem, 6vw, 5.25rem); line-height: .92; font-weight: 800; letter-spacing: -.03em; margin-bottom: 1rem; color: #f4efe6; }
        .hero-subtitle { font-size: 1.05rem; color: rgba(244,239,230,.88); margin-bottom: 1.8rem; max-width: 580px; }
        .hero-button { border-radius: 999px; padding: 14px 32px; font-weight: 700; background: rgba(255,255,255,0.94); color: #111; border: none; box-shadow: 0 18px 35px rgba(0,0,0,0.12); }
        .hero-button:hover { background: #111; color: #fff; }
        main { padding-top: 160px; }
        .product-card { border: none; border-radius: 32px; overflow: hidden; transition: transform .3s ease, box-shadow .3s ease; background: #fff; }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 28px 60px rgba(0,0,0,0.12); }
        .product-thumb { position: relative; overflow: hidden; min-height: 280px; display: flex; align-items: center; justify-content: center; background: #f7f2e9; }
        .product-thumb img { width: 100%; height: 100%; object-fit: contain; transition: transform .35s ease; }
        .product-thumb:hover img { transform: scale(1.05); }
        .product-badge { position: absolute; top: 16px; right: 16px; padding: .45rem .8rem; border-radius: 999px; background: #111; color: #fff; font-size: .7rem; letter-spacing: .12em; text-transform: uppercase; }
        .product-actions { position: absolute; bottom: 16px; right: 16px; display: flex; gap: .5rem; }
        .product-action { width: 42px; height: 42px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.08); background: #fff; display: inline-flex; align-items: center; justify-content: center; color: #111; font-size: 1rem; line-height: 1; transition: transform .2s ease, background .2s ease, color .2s ease; }
        .product-action:hover { background: #111; color: #fff; transform: translateY(-2px); text-decoration: none; }
        .product-body { min-height: 130px; }
        .product-name { font-size: 1rem; font-weight: 700; color: #111; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: .02em; }
        .product-info-row { display: flex; justify-content: space-between; align-items: center; gap: .75rem; flex-wrap: wrap; }
        .product-price { font-size: 1.02rem; font-weight: 800; color: #111; }
        .product-option { border-radius: 999px; padding: .6rem 1rem; border: 1px solid rgba(0,0,0,0.12); color: #111; font-size: .82rem; text-transform: uppercase; letter-spacing: .1em; transition: background .2s ease, color .2s ease; text-decoration: none; }
        .product-option:hover { background: #111; color: #fff; }
        .footer { background: #111; color: #d3cfc7; }
        .footer a { color: #f6f2eb; }
    </style>
</head>
<body>
<header class="site-header">
    <div class="header-panel">
        <a href="?mode=client" class="brand">KEEP:<span>SILENT</span></a>
        <div class="nav-group">
            <a class="header-link" href="?mode=client">All Items</a>
            <a class="header-link" href="?mode=client&action=cart">Category</a>
            <a class="header-link" href="?mode=client&action=checkout">Collections</a>
            <a class="header-link" href="?mode=client&action=checkout">About Us</a>
        </div>
        <div class="nav-group">
            <span class="header-chip">Store Policies</span>
            <a class="icon-link" href="?mode=client&action=cart">🛒</a>
            <?php if (!empty($_SESSION['user'])): ?>
                <a class="icon-link" href="?mode=users">👤</a>
            <?php else: ?>
                <a class="icon-link" href="?mode=client&action=login">👤</a>
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
