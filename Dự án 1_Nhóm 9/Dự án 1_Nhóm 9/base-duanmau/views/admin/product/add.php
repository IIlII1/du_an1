<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Thêm sản phẩm</title>
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <section class="content" style="padding: 30px;">
    <div class="container-fluid">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Thêm sản phẩm mới</h3>
        </div>
        <form action="?mode=admin&action=addPro" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <?php if (!empty($_SESSION['error'])): ?>
              <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
              </div>
            <?php endif; ?>

            <div class="form-group">
              <label for="product_name">Tên sản phẩm</label>
              <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>

            <div class="form-group">
              <label for="cate_id">Bộ sưu tập</label>
              <select class="form-control" id="cate_id" name="cate_id" required>
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?= htmlspecialchars($category['cate_id']) ?>">
                    <?= htmlspecialchars($category['cate_name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="size_id">Kích thước</label>
              <select class="form-control" id="size_id" name="size_id" required>
                <option value="">-- Chọn kích thước --</option>
                <?php foreach ($sizes as $size): ?>
                  <option value="<?= htmlspecialchars($size['size_id']) ?>">
                    <?= htmlspecialchars($size['size_name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="description">Mô tả</label>
              <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>

            <div class="form-group">
              <label for="price">Giá</label>
              <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
            </div>

            <div class="form-group">
              <label for="stock">Số lượng</label>
              <input type="number" class="form-control" id="stock" name="stock" min="0" required>
            </div>

            <div class="form-group">
              <label for="created_at">Ngày sản xuất</label>
              <input type="datetime-local" class="form-control" id="created_at" name="created_at">
            </div>

            <div class="form-group">
              <label for="img">Ảnh sản phẩm</label>
              <input type="file" class="form-control-file" id="img" name="img">
            </div>
          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
            <a href="?mode=admin" class="btn btn-secondary">Quay lại</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
</body>
</html>
