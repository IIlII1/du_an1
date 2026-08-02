<?php
?>
<div class="card shadow-sm">
    <div class="card-header">Bình luận của bạn</div>
    <div class="card-body">
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="?mode=users&action=addComment" method="post">
            <div class="form-group">
                <label>Sản phẩm (ID)</label>
                <input type="number" name="product_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nội dung</label>
                <textarea name="content" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Thêm bình luận</button>
        </form>
        <hr>

        <?php if (empty($comments)): ?>
            <p>Chưa có bình luận nào.</p>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Nội dung</th>
                        <th>Ngày</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $comment): ?>
                        <tr>
                            <td><?= htmlspecialchars($comment['product_name']) ?></td>
                            <td><?= nl2br(htmlspecialchars($comment['content'])) ?></td>
                            <td><?= htmlspecialchars($comment['comment_date']) ?></td>
                            <td>
                                <a href="?mode=users&action=removeComment&id=<?= $comment['comment_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa bình luận?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
