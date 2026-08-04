<?php

class HomeController
{   
    private $productModel;

    public function __construct() {
        $this->productModel = new ProModel();
    }

    public function index()
    {
        $view = 'home';
        $query = trim($_GET['q'] ?? '');

        $newArrivals = $this->productModel->getProductsByCategoryName('Invisible Fence');
        $data = $query !== '' ? $this->productModel->searchByName($query) : $this->productModel->getLatestProducts();

        require_once PATH_VIEW_CLIENT . 'main.php';
    }
}