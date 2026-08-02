<?php 

session_start();

spl_autoload_register(function ($class) {    
    $fileName = "$class.php";

    $fileModel              = PATH_MODEL . $fileName;
    $fileControllerClient   = PATH_CONTROLLER_CLIENT . $fileName;
    $fileControllerAdmin    = PATH_CONTROLLER_ADMIN . $fileName;
    $fileControllerUsers    = PATH_CONTROLLER_USERS . $fileName;

    if (is_readable($fileModel)) {
        require_once $fileModel;
    } elseif (is_readable($fileControllerClient)) {
        require_once $fileControllerClient;
    } elseif (is_readable($fileControllerAdmin)) {
        require_once $fileControllerAdmin;
    } elseif (is_readable($fileControllerUsers)) {
        require_once $fileControllerUsers;
    }
});

require_once './configs/env.php';
require_once './configs/helper.php';

// Điều hướng
$mode = $_GET['mode'] ?? 'client';

if ($mode === 'client') {
    require_once './routes/client.php';
} elseif ($mode === 'admin') {
    require_once './routes/admin.php';
} elseif ($mode === 'users') {
    require_once './routes/users.php';
} else {
    require_once './routes/client.php';
}

