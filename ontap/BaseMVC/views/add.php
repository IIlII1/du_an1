 <h2>Thêm cầu thủ mới</h2>

<form action="<?php echo BASE_URL . '?action=product-stor'; ?>" 
      method="POST" 
      enctype="multipart/form-data">

    <label>Tên:</label>
    <input type="text" name="name" required><br>

    <label>Ảnh đại diện:</label>
    <input type="file" name="avatar" accept="image/*" required><br>

    <label>Câu lạc bộ:</label>
    <input type="text" name="club_id" required><br>

    <label>Vị trí thi đấu:</label>
    <input type="text" name="position" required><br>

    <label>Ngày sinh:</label>
    <input type="date" name="date_of_birth" required><br>

    <button type="submit">Lưu</button>
</form>
