<?php
class ProController
{
    public $proModel;

    public function __construct()
    {
        $this->proModel = new ProModel();
    }

    public function index()
    {
        $products = $this->proModel->getAll();
        require_once PATH_VIEW_ADMIN . 'product/index.php';
    }

    public function deletePro()
    {
        $id = $_GET['id'] ?? 0;
        if ($id) {
            $this->proModel->deletePro($id);
        }

        header('Location: ' . BASE_URL . '?mode=admin');
        exit;
    }
}
?>