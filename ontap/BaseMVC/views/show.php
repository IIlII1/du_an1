<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Trang Chi Tiết</h1>
    <p><strong>ID:</strong> <?= $ontapModel->id ?></p>
    <p><strong>Tên:</strong> <?= $ontapModel->name ?></p>
    <p><strong>Vị trí:</strong> <?= $ontapModel->position ?></p>
    <p><strong>Ngày sinh:</strong> <?= $ontapModel->date_of_birth ?></p>
    <img src="<?= BASE_URL . 'uploads/' . $ontapModel->avatar ?>" width="120">
</body>
</html>