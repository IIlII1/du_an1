<?php

if (!function_exists('debug')) {
    function debug($data)
    {
        echo '<pre>';
        print_r($data);
        die;
    }
}

if (!function_exists('upload_file')) {
    function upload_file($folder, $file)
    {
        if (!is_array($file) || empty($file['name']) || empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            throw new Exception('Không có file ảnh hợp lệ được gửi lên.');
        }

        $targetFolder = PATH_ASSETS_UPLOADS . $folder;
        if (!is_dir($targetFolder) && !mkdir($targetFolder, 0777, true) && !is_dir($targetFolder)) {
            throw new Exception('Không thể tạo thư mục upload: ' . $targetFolder);
        }

        if (!is_writable($targetFolder)) {
            throw new Exception('Thư mục upload không có quyền ghi: ' . $targetFolder);
        }

        $safeName = preg_replace('/[^A-Za-z0-9._-]/', '-', $file['name']);
        $targetFile = $folder . DIRECTORY_SEPARATOR . time() . '-' . $safeName;
        $fullPath = PATH_ASSETS_UPLOADS . $targetFile;

        if (move_uploaded_file($file['tmp_name'], $fullPath)) {
            return $targetFile;
        }

        throw new Exception('Upload file không thành công!');
    }
}