<div class="content-wrapper p-3">
    <div class="card">
        <div class="card-header">
            <h3>Danh sách đánh giá trang web</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Khách hàng</th>
                        <th>Số sao</th>
                        <th>Nội dung</th>
                        <th>Thời gian</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reviews as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['user_name']) ?></td>
                        <td>
                            <span style="color: #f39c12;">
                                <?= str_repeat('★', $r['rating']) ?><?= str_repeat('☆', 5 - $r['rating']) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($r['content']) ?></td>
                        <td><?= $r['created_at'] ?></td>
                        <td>
                            <a href="?mode=admin&action=removeComment&id=<?= $r['comment_id'] ?>" 
                               onclick="return confirm('Bạn chắc chắn muốn xóa?')" 
                               class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>