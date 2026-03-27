<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php echo BASE_URL . '?action=stor'; ?>" 
      method="POST" 
      enctype="multipart/form-data">

    <th>
        <td>name</td>
        <input type="text" name="name" id="name">
    </th>


    <th>
        <td>email/td>
        <input type="text" name="email" id="email">
    </th>

    <th>
        <td>avatar</td>
        <input type="text" name="avatar" id="avatar">
    </th>

    <th>
        <td>salary</td>
        <input type="number" name="salary" id="salary">
    </th>

    <th>
        <td>department_id</td>
        <input type="text" name="" id="">
    </th>
    <button type="subbmit">LUU</button>
    </form>
</body>
</html>