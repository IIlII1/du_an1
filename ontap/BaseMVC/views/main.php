<a href="<?php echo BASE_URL.'?action=product-add&id='; ?>">thêm</a>
<table border="1">
    <tr>
        <th>Tên</th>
        <th>Ảnh</th>
        <th>Câu lạc bộ</th>
        <th>Vị trí</th>
        <th>Ngày sinh</th>
    </tr>

    <?php foreach($ontap2 as $item): ?>
        <tr>
            <td><?= $item["name"] ?></td>
            <td><?= $item["avatar"] ?></td>
            <td><?= $item["club_id"] ?></td>
            <td><?= $item["position"] ?></td>
            <td><?= $item["date_of_birth"] ?></td>
            <td>
                <a href="<?php echo BASE_URL.'?action=product-delete&id='.$item['id']?>">xóa</a>
            <a href="<?php echo BASE_URL.'?action=product-show&id='.$item['id']?>">xem</a>
            </td>
        </tr>
    <?php endforeach ?>
</table>
