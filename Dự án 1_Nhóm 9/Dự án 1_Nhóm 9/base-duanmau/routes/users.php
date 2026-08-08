<?php

$action = $_GET['action'] ?? 'dashboard';

$controller = new UsersController();

switch ($action) {
    case 'dashboard':
        $controller->dashboard();
        break;
    case 'addresses':
        $controller->addresses();
        break;
    case 'saveAddress':
        $controller->saveAddress();
        break;
    case 'removeAddress':
        $controller->removeAddress();
        break;
    case 'orders':
        $controller->orders();
        break;
    case 'orderDetail':
        $controller->orderDetail();
        break;
    case 'wishlist':
        $controller->wishlist();
        break;
    case 'addWishlist':
        $controller->addWishlist();
        break;
    case 'removeWishlist':
        $controller->removeWishlist();
        break;
    case 'comments':
        $controller->comments();
        break;
    case 'addComment':
        $controller->addComment();
        break;
    case 'removeComment':
        $controller->removeComment();
        break;
    case 'updateProfile':
        $controller->updateProfile();
        break;
    default:
        $controller->dashboard();
        break;
    
}
