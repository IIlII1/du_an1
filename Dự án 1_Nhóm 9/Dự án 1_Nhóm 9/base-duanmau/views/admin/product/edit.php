<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sửa sản phẩm</title>
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <section class="content" style="padding: 30px;">
    <div class="container-fluid">
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title">Sửa sản phẩm</h3>
        </div>
        <form action="?mode=admin&action=editPro" method="post" enctype="multipart/form-data">
          <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
          <div class="card-body">
            <?php if (!empty($_SESSION['error'])): ?>
              <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
              </div>
            <?php endif; ?>

            <div class="form-group">
              <label for="product_name">Tên sản phẩm</label>
              <input type="text" class="form-control" id="product_name" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>
            </div>

            <div class="form-group">
              <label for="cate_id">Bộ sưu tập</label>
              <select class="form-control" id="cate_id" name="cate_id" required>
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?= htmlspecialchars($category['cate_id']) ?>" <?= (string)$category['cate_id'] === (string)$product['cate_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['cate_name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="description">Mô tả</label>
              <textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <div class="form-group">
              <label for="price">Giá</label>
              <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" value="<?= htmlspecialchars($product['price']) ?>" required>
            </div>

            <div class="form-group">
              <label for="stock">Số lượng</label>
              <input type="number" class="form-control" id="stock" name="stock" min="0" value="<?= htmlspecialchars($product['stock']) ?>" required>
            </div>

            <div class="form-group">
              <label for="created_at">Ngày sản xuất</label>
              <input type="datetime-local" class="form-control" id="created_at" name="created_at" value="<?= !empty($product['created_at']) ? date('Y-m-d\TH:i', strtotime($product['created_at'])) : '' ?>">
            </div>

            <div class="form-group">
              <label for="img">Ảnh sản phẩm</label>
              <input type="file" class="form-control-file" id="img" name="img">
            </div>
          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-success">Cập nhật</button>
            <a href="?mode=admin" class="btn btn-secondary">Quay lại</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
</body>
</html>
