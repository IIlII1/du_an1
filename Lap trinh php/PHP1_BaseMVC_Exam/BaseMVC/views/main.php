<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table border="1" cellpadding="10" cellspacing="0">
        <a href="<?php echo BASE_URL.'?action=add'  ?>">add</a>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>email</th>
            <th>avatar</th>
            <th>salary</th>
            <th>department_id</th>
            <th>action</th>
        </tr>
            <?php foreach($ontap as $item): ?>
                <th><?= $item['id'] ?></th>
                <th><?= $item['name'] ?></th>
                <th><?= $item['email'] ?></th>
                <th><?= $item['avatar'] ?></th>
                <th><?= $item['salary'] ?></th>
                <th><?= $item['department_id'] ?></th>
                <td>
                    <a href="<?php echo BASE_URL .'?action=update&id'. $item['id'] ?>">chi tiet</a>
                </td>
        <tr>

        </tr>
        <?php endforeach;?>
    </table>
</body>
</html>