<?php
?>
<div class="card shadow-sm mb-4">
    <div class="card-header">Địa chỉ nhận hàng</div>
    <div class="card-body">
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="?mode=users&action=saveAddress" method="post">
            <div class="form-group">
                <label>Người nhận</label>
                <input type="text" name="receiver_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Địa chỉ</label>
                <textarea name="address" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Lưu địa chỉ</button>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header">Danh sách địa chỉ</div>
    <div class="card-body">
        <?php if (empty($addresses)): ?>
            <p>Chưa có địa chỉ nào.</p>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Người nhận</th>
                        <th>Điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($addresses as $address): ?>
                        <tr>
                            <td><?= htmlspecialchars($address['receiver_name']) ?></td>
                            <td><?= htmlspecialchars($address['phone']) ?></td>
                            <td><?= htmlspecialchars($address['address']) ?></td>
                            <td>
                                <a href="?mode=users&action=removeAddress&id=<?= $address['address_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa địa chỉ này?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
