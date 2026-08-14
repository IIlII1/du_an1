<h1 class="page-title">Đánh giá</h1>

<div class="user-card">
    <div class="card-title">PHẢN HỒI CỦA BẠN</div>
    
    <div class="card-body">
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($hasReviewed) && $hasReviewed): ?>
            <div class="empty-data">Bạn đã đánh giá trang web của chúng tôi. Cảm ơn bạn!</div>
        <?php else: ?>
            <form action="?mode=users&action=submitReview" method="POST">
                <style>
                    .rating-group { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 10px; margin-bottom: 20px; }
                    .rating-group input { display: none; }
                    .rating-group label { font-size: 2rem; color: #ccc; cursor: pointer; }
                    .rating-group input:checked ~ label,
                    .rating-group label:hover,
                    .rating-group label:hover ~ label { color: #f39c12; }
                    .review-textarea { width: 100%; min-height: 100px; padding: 10px; border: 1px solid #ddd; margin-bottom: 15px; }
                    .btn-submit { background: #000; color: #fff; padding: 10px 20px; border: none; cursor: pointer; }
                </style>

                <div class="rating-group">
                    <input type="radio" id="star5" name="rating" value="5" required><label for="star5">★</label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                </div>

                <textarea name="content" class="review-textarea" placeholder="Nhận xét của bạn về trải nghiệm tại trang web..." required></textarea>
                
                <button type="submit" class="btn-submit">GỬI ĐÁNH GIÁ</button>
            </form>
        <?php endif; ?>
    </div>
</div>