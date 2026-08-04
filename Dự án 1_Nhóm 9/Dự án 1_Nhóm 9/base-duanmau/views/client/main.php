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
        .site-header { position: fixed; top: 1rem; left: 50%; transform: translateX(-50%); width: min(1400px, calc(100% - 2rem)); z-index: 2000; padding: 0; }
        .site-header .header-panel { background: rgba(255,255,255,0.95); border-radius: 80px; border: 1px solid rgba(0,0,0,0.08); box-shadow: 0 28px 50px rgba(0,0,0,0.08); backdrop-filter: blur(18px); padding: 1rem 1.8rem; display: flex; align-items: center; justify-content: space-between; }
        .site-header .brand { font-family: 'Space Grotesk', 'Inter', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; color: #111; }
        .site-header .brand span { font-weight: 900; letter-spacing: .35em; }
        .site-header .nav-group { display: flex; align-items: center; gap: 1rem; }
        .site-header .header-link, .site-header .header-chip, .site-header .icon-link { display: inline-flex; align-items: center; justify-content: center; padding: .85rem 1.3rem; border-radius: 999px; font-size: .8rem; text-transform: uppercase; letter-spacing: .16em; transition: background .25s ease, transform .25s ease, color .25s ease; }
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
        .hero-row { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 2rem; }
        .hero-text { flex: 1 1 480px; max-width: 620px; }
        .hero-overline { font-size: .85rem; letter-spacing: .22em; text-transform: uppercase; color: rgba(244,239,230,.82); margin-bottom: 1.3rem; }
        .hero-copy { max-width: 620px; font-size: 1rem; line-height: 1.9; color: rgba(244,239,230,.88); margin-bottom: 1.8rem; }
        .hero-note { font-size: .95rem; font-weight: 600; letter-spacing: .02em; color: rgba(244,239,230,.96); margin-bottom: 2rem; }
        .hero-visual { flex: 0 0 440px; min-height: 520px; overflow: hidden; background: rgba(255,255,255,0.05); position: relative; }
        .hero-visual img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .banner-two-image-section { margin-top: 3rem; }
        .banner-two-image-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; }
        .banner-panel { position: relative; overflow: hidden; min-height: 520px; background: #f3e9dd; border: 1px solid rgba(17,17,17,0.08); }
        .banner-panel img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .banner-panel-right { display: flex; align-items: center; justify-content: center; }
        .banner-overlay-logo { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 220px; height: auto; pointer-events: none; z-index: 2; }
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
        .all-items-slider { display: flex; gap: 1rem; overflow-x: auto; padding-bottom: 1rem; scroll-snap-type: x mandatory; }
        .all-items-slider::-webkit-scrollbar { height: 10px; }
        .all-items-slider::-webkit-scrollbar-thumb { background: rgba(17,17,17,.25); border-radius: 999px; }
        .slider-item { flex: 0 0 320px; scroll-snap-align: start; }
        .slider-item .product-card { min-width: 100%; }
        .view-all-button { display: inline-flex; align-items: center; gap: .7rem; padding: .95rem 2rem; background: #21140a; color: #fff; border-radius: 999px; text-transform: uppercase; letter-spacing: .18em; font-weight: 700; font-size: .95rem; border: none; text-decoration: none; transition: transform .2s ease, background .2s ease; }
        .view-all-button:hover { background: #000; transform: translateY(-1px); text-decoration: none; }
        .view-all-button span { font-size: 1.2rem; }
        .collections-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 1rem; }
        .collection-card { position: relative; overflow: hidden; min-height: 420px; border-radius: 0; }
        .collection-card img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .collection-overlay { position: absolute; inset: 0; background: linear-gradient(180deg, rgba(17,17,17,0.08) 0%, rgba(17,17,17,0.5) 100%); }
        .collection-meta { position: absolute; left: 1.5rem; bottom: 1.5rem; z-index: 2; color: #fff; }
        .collection-name { display: block; font-size: 1.05rem; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; margin-bottom: .8rem; }
        .collection-button { display: inline-flex; align-items: center; gap: .6rem; padding: .75rem 1.4rem; background: rgba(255,255,255,0.15); color: #fff; border-radius: 999px; border: 1px solid rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: .12em; font-weight: 700; font-size: .82rem; text-decoration: none; transition: background .2s ease, transform .2s ease; }
        .collection-button:hover { background: rgba(255,255,255,0.25); transform: translateY(-1px); }
        .product-name { font-size: 1rem; font-weight: 700; color: #111; margin-bottom: .5rem; text-transform: uppercase; letter-spacing: .06em; }
        .product-desc { color: #777; font-size: .95rem; line-height: 1.5; min-height: 2.5rem; margin-bottom: 1rem; }
        .product-info-row { display: flex; justify-content: space-between; align-items: center; gap: .75rem; flex-wrap: wrap; }
        .product-price { font-size: 1.05rem; font-weight: 800; color: #111; }
        .product-option { border-radius: 999px; padding: .75rem 1.1rem; border: 1px solid #111; color: #111; font-size: .82rem; text-transform: uppercase; letter-spacing: .12em; transition: background .2s ease, color .2s ease, transform .2s ease, opacity .25s ease; text-decoration: none; background: rgba(255,255,255,0.95); opacity: 0; visibility: hidden; transform: translateY(10px); }
        .product-card:hover .product-option { opacity: 1; visibility: visible; transform: translateY(0); }
        .product-option:hover { background: #111; color: #fff; transform: translateY(-1px); }
        .footer { background: #1e0f06; color: #faf1df; }
        .footer a { color: #faf1df; text-decoration: none; opacity: .85; transition: opacity .2s ease; }
        .footer a:hover { opacity: 1; }
        .footer .footer-top { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 2rem; padding-bottom: 3rem; border-bottom: 1px solid rgba(255,255,255,.08); }
        .footer .footer-col h6 { text-transform: uppercase; letter-spacing: .24em; font-size: .8rem; margin-bottom: 1.2rem; color: #fff; }
        .footer .footer-col ul { list-style: none; padding: 0; margin: 0; }
        .footer .footer-col li { margin-bottom: 1rem; font-size: .9rem; opacity: .92; }
        .footer .footer-col li:last-child { margin-bottom: 0; }
        .footer .footer-col p { margin: 0; line-height: 1.8; opacity: .9; }
        .footer .footer-bottom { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; padding-top: 2rem; }
        .footer .footer-logo { font-family: 'Space Grotesk', 'Inter', sans-serif; font-size: 2rem; font-weight: 900; letter-spacing: .2em; text-transform: uppercase; opacity: .95; }
        .footer .footer-copy { font-size: .85rem; opacity: .75; }
        @media (max-width: 991.98px) {
            .footer .footer-top { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 575.98px) {
            .footer .footer-top { grid-template-columns: 1fr; }
            .footer .footer-bottom { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
<header class="site-header">
    <div class="header-panel">
        <a href="?mode=client" class="brand"><img src="https://inwfile.com/s-gn/_webp_max_images/300/300/2r/ot/34.webp" width="200" alt="KEEP:SILENT"></a>
        <div class="nav-group">
            <a class="header-link" href="?mode=client">All Items</a>
            <a class="header-link" href="?mode=client">Collections</a>
            <a class="header-link" href="?mode=client&action=checkout">About Us</a>
            <a class="header-link" href="?mode=client&action=checkout">Contact</a>
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
        <div class="footer-top">
            <div class="footer-col">
                <h6>Category</h6>
                <ul>
                    <li><a href="?mode=client">All Items</a></li>
                    <li><a href="?mode=client&action=category&cate=Keep Tee">Keep Tee</a></li>
                    <li><a href="?mode=client&action=category&cate=Keep Sleeveless">Keep Sleeveless</a></li>
                    <li><a href="?mode=client&action=category&cate=Keep Bundle">Keep Bundle</a></li>
                    <li><a href="?mode=client&action=category&cate=Keep Pants">Keep Pants</a></li>
                    <li><a href="?mode=client&action=category&cate=Keep Sweater">Keep Sweater</a></li>
                    <li><a href="?mode=client&action=category&cate=Keep Accessory">Keep Accessory</a></li>
                    <li><a href="?mode=client&action=category&cate=Keep Pre-Order">Keep Pre-order</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h6>Collections</h6>
                <ul>
                    <li><a href="?mode=client&action=collection&name=Invisible Fence">Invisible Fence</a></li>
                    <li><a href="?mode=client&action=collection&name=Wishless Party">Wishless Party</a></li>
                    <li><a href="?mode=client&action=collection&name=Chaos Hotel">Chaos Hotel</a></li>
                    <li><a href="?mode=client&action=collection&name=Keep The Wonder">Keep The Wonder</a></li>
                    <li><a href="?mode=client&action=collection&name=Keep Love">Keep Love Tee</a></li>
                    <li><a href="?mode=client&action=collection&name=Keep Love">RE(FLEX)</a></li>
                   
                </ul>
            </div>
            <div class="footer-col">
                <h6>About Keep:Silent</h6>
                <ul>
                    <li><a href="?mode=client&action=checkout">Store Policies</a></li>
                    <li><a href="?mode=client&action=checkout">About Us</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h6>Account</h6>
                <ul>
                    <li><a href="?mode=users&action=orders">My Orders</a></li>
                    <li><a href="?mode=users&action=profile">Profile</a></li>
                    <li><a href="?mode=users&action=addresses">Address</a></li>
                    <li><a href="?mode=users&action=security">Security and Privacy</a></li>
                    <li><a href="?mode=users&action=settings">Account Setting</a></li>
                    <li><a href="?mode=users&action=help">Order Help</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-logo"><img src="https://inwfile.com/s-gn/_webp_max_images/600/600/ni/yw/w6.webp" alt=""></div>
            <div class="footer-copy">Copyright ©2026 KEEP:SILENT All rights reserved.</div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
