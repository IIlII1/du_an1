<h1 class="page-title">
    Bình luận
</h1>

<p class="page-description">
    Quản lý những bình luận của bạn.
</p>


<?php if (!empty($_SESSION['success'])): ?>

    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>

    <?php unset($_SESSION['success']); ?>

<?php endif; ?>


<?php if (!empty($_SESSION['error'])): ?>

    <div class="alert alert-danger">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>

    <?php unset($_SESSION['error']); ?>

<?php endif; ?>


<div class="user-card">

    <div class="card-title">
        THÊM BÌNH LUẬN
    </div>

    <div class="card-body">

        <form
            action="?mode=users&action=addComment"
            method="post"
            class="profile-form"
        >

            <div class="form-group">

                <label class="form-label">
                    Sản phẩm
                </label>

                <input
                    type="number"
                    name="product_id"
                    class="form-control"
                    required
                >

            </div>


            <div class="form-group full">

                <label class="form-label">
                    Nội dung
                </label>

                <textarea
                    name="content"
                    class="form-control"
                    required
                ></textarea>

            </div>


            <div class="form-group full">

                <button
                    type="submit"
                    class="save-btn"
                >
                    GỬI BÌNH LUẬN
                </button>

            </div>

        </form>

    </div>

</div>


<div class="user-card">

    <div class="card-title">
        BÌNH LUẬN CỦA BẠN
    </div>

    <div class="card-body">

        <?php if (empty($comments)): ?>

            <div class="empty-data">
                Chưa có bình luận nào.
            </div>

        <?php else: ?>

            <div class="table-wrapper">

                <table class="user-table">

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

                            <td>
                                <?= htmlspecialchars(
                                    $comment['product_name']
                                ) ?>
                            </td>

                            <td>
                                <?= nl2br(
                                    htmlspecialchars(
                                        $comment['content']
                                    )
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $comment['comment_date']
                                ) ?>
                            </td>

                            <td>

                                <a
                                    href="?mode=users&action=removeComment&id=<?= (int)$comment['comment_id'] ?>"
                                    class="delete-btn"
                                    onclick="return confirm('Xóa bình luận này?')"
                                >
                                    Xóa
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>

</div>