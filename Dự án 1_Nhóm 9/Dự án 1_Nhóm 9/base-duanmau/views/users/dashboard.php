<?php
?>
<div class="card shadow-sm">
    <div class="card-header">Trang cá nhân</div>
    <div class="card-body">
        <p><strong>Họ tên:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone']) ?></p>
        <p><strong>Vai trò:</strong> <?= htmlspecialchars($user['role']) ?></p>
    </div>
</div>
