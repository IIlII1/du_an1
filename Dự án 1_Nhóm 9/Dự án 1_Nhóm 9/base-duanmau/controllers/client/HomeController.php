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

        if ($query !== '') {
            $data = $this->productModel->searchByName($query);
        } else {
            $data = $this->productModel->getLatestProducts();
        }

        require_once PATH_VIEW_CLIENT . 'main.php';
    }
}