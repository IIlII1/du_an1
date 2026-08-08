<?php

$defaultAvatar = BASE_URL . 'dist/img/user1-128x128.jpg';

if (!empty($user['avatar'])) {

    $avatarPath = PATH_ASSETS_UPLOADS . 'avatars/' . $user['avatar'];

    if (file_exists($avatarPath)) {
        $avatar = BASE_ASSETS_UPLOADS . 'avatars/' . rawurlencode($user['avatar']);
    } else {
        $avatar = $defaultAvatar;
    }

} else {

    $avatar = $defaultAvatar;

}

?>

<h1 class="page-title">
    Trang cá nhân
</h1>

<p class="page-description">
    Quản lý và cập nhật thông tin cá nhân của bạn.
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
        THÔNG TIN CÁ NHÂN
    </div>


    <div class="card-body">


        <form
            action="?mode=users&action=updateProfile"
            method="post"
            enctype="multipart/form-data"
        >


            <!-- AVATAR -->

            <div class="profile-avatar-area">

                <img
                    src="<?= htmlspecialchars($avatar) ?>"
                    class="profile-avatar"
                    id="avatarPreview"
                    alt="Avatar"
                >

                <div>

                    <div style="color:#ddd;font-size:11px;font-weight:600;">
                        Ảnh đại diện
                    </div>

                    <div class="avatar-note">
                        JPG, JPEG, PNG hoặc WEBP.<br>
                        Nên sử dụng ảnh vuông.
                    </div>

                    <input
                        type="file"
                        name="avatar"
                        class="avatar-input"
                        accept="image/*"
                        onchange="previewAvatar(this)"
                    >

                </div>

            </div>


            <!-- FORM -->

            <div class="profile-form">


                <!-- HỌ TÊN -->

                <div class="form-group">

                    <label class="form-label">
                        Họ và tên
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="<?= htmlspecialchars($user['name'] ?? '') ?>"
                        required
                    >

                </div>


                <!-- EMAIL -->

                <div class="form-group">

                    <label class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                        required
                    >

                </div>


                <!-- PHONE -->

                <div class="form-group">

                    <label class="form-label">
                        Số điện thoại
                    </label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                        required
                    >

                </div>


                <!-- GENDER -->

                <div class="form-group">

                    <label class="form-label">
                        Giới tính
                    </label>

                    <select
                        name="gender"
                        class="form-control"
                    >

                        <option value="">
                            Chọn giới tính
                        </option>

                        <option
                            value="Nam"
                            <?= (($user['gender'] ?? '') === 'Nam') ? 'selected' : '' ?>
                        >
                            Nam
                        </option>

                        <option
                            value="Nữ"
                            <?= (($user['gender'] ?? '') === 'Nữ') ? 'selected' : '' ?>
                        >
                            Nữ
                        </option>

                        <option
                            value="Khác"
                            <?= (($user['gender'] ?? '') === 'Khác') ? 'selected' : '' ?>
                        >
                            Khác
                        </option>

                    </select>

                </div>


                <!-- NGÀY SINH -->

                <div class="form-group">

                    <label class="form-label">
                        Ngày sinh
                    </label>

                    <input
                        type="date"
                        name="date_of_birth"
                        class="form-control"
                        value="<?= htmlspecialchars($user['date_of_birth'] ?? '') ?>"
                    >

                </div>


                <!-- THÀNH PHỐ -->

                <div class="form-group">

                    <label class="form-label">
                        Thành phố
                    </label>

                    <input
                        type="text"
                        name="city"
                        class="form-control"
                        placeholder="Ví dụ: Hà Nội"
                        value="<?= htmlspecialchars($user['city'] ?? '') ?>"
                    >

                </div>


                <!-- QUẬN HUYỆN -->

                <div class="form-group">

                    <label class="form-label">
                        Quận / Huyện
                    </label>

                    <input
                        type="text"
                        name="district"
                        class="form-control"
                        placeholder="Ví dụ: Cầu Giấy"
                        value="<?= htmlspecialchars($user['district'] ?? '') ?>"
                    >

                </div>


                <!-- BUTTON -->

                <div class="form-group full">

                    <button
                        type="submit"
                        class="save-btn"
                    >
                        LƯU THAY ĐỔI
                    </button>

                </div>


            </div>


        </form>


    </div>

</div>


<script>

function previewAvatar(input) {

    if (input.files && input.files[0]) {

        const reader = new FileReader();

        reader.onload = function(e) {

            document.getElementById('avatarPreview').src = e.target.result;

        };

        reader.readAsDataURL(input.files[0]);

    }

}

</script>