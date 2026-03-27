<?php

class HomeController
{
    public function index() 
    {
        $model = new ontap2Model;
        $ontap2 = $model->getAll();
        // debug($ontap2);
        require_once PATH_VIEW . 'main.php';
    }
//     //thêm
     public function add(){
    require_once PATH_VIEW . 'add.php';
}

public function stor(){
    if (!empty($_POST)) {

        $data = [
            'name'          => $_POST['name'],
            'club_id'       => $_POST['club_id'],
            'position'      => $_POST['position'],
            'date_of_birth' => $_POST['date_of_birth'],
        ];

        $model = new ontap2Model;
        $model->insert($data);

        header("Location: " . BASE_URL);
        exit;
    }
}

    //xóa
    public function delete(){
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $model = new ontap2Model;
        $model->delete($id);
        header("Location: " . BASE_URL);
        exit;
    }
}
 public function show(){
    $id = $_GET['id'] ?? 0;
    if($id > 0){
        $ontap2Model = new ontap2Model();
        $ontapModel = $ontap2Model->getById($id);
        require_once PATH_VIEW . 'show.php';
    }
}
}