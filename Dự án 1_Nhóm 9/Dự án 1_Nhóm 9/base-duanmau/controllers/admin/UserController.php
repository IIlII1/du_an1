<?php

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->getAll();
        require_once PATH_VIEW_ADMIN . 'user/index.php';
    }
}
