<?php

$action = $_GET['action'] ?? 'index';

$controller = new HomeController();

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'cart':
        $cartController = new CartController();
        $cartController->index();
        break;
    case 'addCart':
        $cartController = new CartController();
        $cartController->add();
        break;
    case 'updateCart':
        $cartController = new CartController();
        $cartController->update();
        break;
    case 'removeCart':
        $cartController = new CartController();
        $cartController->remove();
        break;
    case 'checkout':
        $cartController = new CartController();
        $cartController->checkout();
        break;
    case 'placeOrder':
        $cartController = new CartController();
        $cartController->placeOrder();
        break;
    case 'login':
        $authController = new AuthController();
        $authController->showForm('login');
        break;
    case 'register':
        $authController = new AuthController();
        $authController->showForm('register');
        break;
    case 'doRegister':
        $authController = new AuthController();
        $authController->register();
        break;
    case 'doLogin':
        $authController = new AuthController();
        $authController->login();
        break;
    case 'logout':
        $authController = new AuthController();
        $authController->logout();
        break;
    default:
        $controller->index();
        break;
}
