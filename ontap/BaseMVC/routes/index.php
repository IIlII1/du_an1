<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new HomeController)->index(),
     'product-add'         => (new HomeController)->add(),
    'product-delete'         => (new HomeController)->delete(),
     'product-stor'         => (new HomeController)->stor(),
     'product-edit'         => (new HomeController)->edit(),
    'product-show'         => (new HomeController)->show(),
};