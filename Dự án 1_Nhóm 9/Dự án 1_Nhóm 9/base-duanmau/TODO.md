# TODO - Add to Cart, Size, Gallery, Related & Recently Viewed

## Steps
- [x] 1. Thêm model methods vào `ProModel.php`: `getAllSizes`, `getRelatedProducts`, `getProductImages`, `getProductsByIds`
- [x] 2. Refactor `CartController.php` hỗ trợ size (composite key `productId:sizeId`): `add`, `update`, `remove`, `buildCartItems`, `getCartCount`
- [x] 3. Cập nhật `views/client/cart.php` dùng key item và hiển thị tên size
- [x] 4. Cập nhật `HomeController::productDetail()`: nạp related products, product images, recently viewed (session)
- [x] 5. Cập nhật `views/client/product-detail.php`: sửa action form, validate size, gallery ảnh phụ, section related & recently viewed
- [x] 6. Cung cấp SQL seed cho `product_size` và `product_img` demo

## Followup
- [ ] Kiểm tra add-to-cart hoạt động và size được lưu trong giỏ
- [ ] Kiểm tra trang chi tiết hiển thị gallery ảnh, sản phẩm liên quan & từng xem

## SQL Seed (demo) - chạy trong phpMyAdmin cho DB `duan1_wd21201`

```sql
-- Sizes chuẩn (nếu chưa có)
INSERT INTO `sizes` (`size_id`, `size_name`, `weight`, `height`, `product_id`) VALUES
(1, 'S', '120-140cm', '30-40kg', 0),
(2, 'M', '140-160cm', '40-55kg', 0),
(3, 'L', '160-175cm', '55-68kg', 0),
(4, 'XL', '175-190cm', '68-85kg', 0);

-- Gán size cho từng sản phẩm (thay product_id cho phù hợp)
INSERT INTO `product_size` (`product_id`, `size_id`, `quantity`) VALUES
(1, 1, 10), (1, 2, 10), (1, 3, 5),
(2, 1, 8),  (2, 2, 6),
(3, 2, 5),  (3, 3, 5),  (3, 4, 5);

-- Ảnh phụ cho sản phẩm (thay product_id & img_url)
INSERT INTO `product_img` (`product_id`, `img_url`) VALUES
(1, 'products/1-2.jpg'),
(1, 'products/1-3.jpg'),
(2, 'products/2-2.jpg');
```

> Lưu ý: Đảm bảo các file ảnh tương ứng tồn tại trong `assets/uploads/products/` hoặc dùng URL đầy đủ (https://...).

