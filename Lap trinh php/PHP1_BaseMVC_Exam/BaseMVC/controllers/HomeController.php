<?php

class HomeController
{
    public function index() 
    {
        $model = new ProductModel;
  $ontap = $model->getAll();      
        require_once PATH_VIEW . 'main.php';
    }
    public function add(){
        require_once PATH_VIEW . 'add.php';
    }
    public function stor(){
        if(!empty($_POST)){
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'avatar' => $_POST['avatar'],
                'salary' => $_POST['salary'],
                'department_id' => $_POST['department_id'],
            ];
            $model = new ProductModel;
            $model->insert($data);

            header("Location : " . BASE_URL);
            exit();
        }
    }
}
