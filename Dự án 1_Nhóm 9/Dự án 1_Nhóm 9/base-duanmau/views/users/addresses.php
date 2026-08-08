<h1 class="page-title">
    My addresses
</h1>

<p class="page-description">
    Quản lý các địa chỉ nhận hàng của bạn.
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
        DANH SÁCH ĐỊA CHỈ
    </div>

    <div class="card-body">

        <?php if (empty($addresses)): ?>

            <div class="empty-data">
                Chưa có địa chỉ nào.
            </div>

        <?php else: ?>

            <div class="table-wrapper">

                <table class="user-table">

                    <thead>

                        <tr>
                            <th>Người nhận</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Hành động</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($addresses as $address): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($address['receiver_name']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($address['phone']) ?>
                            </td>

                            <td>
                                <?= nl2br(htmlspecialchars($address['address'])) ?>
                            </td>

                            <td>

                                <a
                                    href="?mode=users&action=removeAddress&id=<?= (int)$address['address_id'] ?>"
                                    class="delete-btn"
                                    onclick="return confirm('Xóa địa chỉ này?')"
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

<div class="user-card">

    <div class="card-title">
        THÊM ĐỊA CHỈ NHẬN HÀNG
    </div>

    <div class="card-body">

        <form
            action="?mode=users&action=saveAddress"
            method="post"
            class="profile-form"
        >

            <div class="form-group">

                <label class="form-label">
                    Người nhận
                </label>

                <input
                    type="text"
                    name="receiver_name"
                    class="form-control"
                    required
                >

            </div>


            <div class="form-group">

                <label class="form-label">
                    Số điện thoại
                </label>

                <input
                    type="text"
                    name="phone"
                    class="form-control"
                    required
                >

            </div>


            <div class="form-group full">

                <label class="form-label">
                    Địa chỉ
                </label>

                <textarea
                    name="address"
                    class="form-control"
                    required
                ></textarea>

            </div>


            <div class="form-group full">

                <button
                    type="submit"
                    class="save-btn"
                >
                    LƯU ĐỊA CHỈ
                </button>

            </div>

        </form>

    </div>

</div>