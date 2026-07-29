<?php

define('BASE_URL',          'http://localhost/D%e1%bb%b1%20%c3%a1n%201_Nh%c3%b3m%209/D%e1%bb%b1%20%c3%a1n%201_Nh%c3%b3m%209/base-duanmau/');
define('BASE_URL_ADMIN',          'http://localhost/DU%20AN%201/D%e1%bb%b1%20%c3%a1n%201_Nh%c3%b3m%209/base-duanmau/?mode=admin');

define('PATH_ROOT',         __DIR__ . '/../');

define('PATH_VIEW_CLIENT',         PATH_ROOT . 'views/client/');
define('PATH_VIEW_ADMIN',         PATH_ROOT . 'views/admin/');

define('PATH_VIEW_MAIN_CLIENT',    PATH_ROOT . 'views/client/main.php');
define('PATH_VIEW_MAIN_ADMIN',    PATH_ROOT . 'views/admin/index.php');

define('BASE_ASSETS_UPLOADS',   BASE_URL . 'assets/uploads/');
define('BASE_ASSETS_UPLOADS_PRODUCTS',   BASE_URL . 'assets/uploads/products');

define('PATH_ASSETS_UPLOADS',   PATH_ROOT . 'assets/uploads/');

define('PATH_CONTROLLER_CLIENT',       PATH_ROOT . 'controllers/client/');
define('PATH_CONTROLLER_ADMIN',       PATH_ROOT . 'controllers/admin/');

define('PATH_MODEL',            PATH_ROOT . 'models/');

define('DB_HOST',     'localhost');
define('DB_PORT',     '3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME',     'duan1_wd21201');
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
