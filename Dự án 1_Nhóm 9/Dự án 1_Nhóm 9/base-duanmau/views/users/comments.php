<style>
    .review-form {
        max-width: 720px;
        margin: 0 auto;
        padding: 8px 0 0;
    }

    .review-header {
        margin-bottom: 18px;
    }

    .review-title {
        color: #f5f5f5;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .review-subtitle {
        color: #8b8b8b;
        font-size: 12px;
    }

    .rating-group {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-start;
        align-items: center;
        gap: 10px;
        margin: 18px 0 22px;
        padding: 10px 12px;
        border: 1px solid #2d2d2d;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.02);
        width: fit-content;
    }

    .rating-group input {
        display: none;
    }

    .rating-group label {
        font-size: 2rem;
        line-height: 1;
        color: #4a4a4a;
        cursor: pointer;
        transition: transform 0.18s ease, color 0.18s ease;
        user-select: none;
    }

    .rating-group label:hover,
    .rating-group label:hover ~ label,
    .rating-group input:checked ~ label {
        color: #f4b942;
        transform: scale(1.08);
    }

    .review-textarea {
        width: 100%;
        min-height: 130px;
        resize: vertical;
        border: 1px solid #2b2b2b;
        border-radius: 12px;
        background: #101010;
        color: #f5f5f5;
        padding: 14px 16px;
        font-size: 13px;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .review-textarea:focus {
        border-color: #7a7a7a;
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.04);
    }

    .review-textarea::placeholder {
        color: #666;
    }

    .review-actions {
        margin-top: 18px;
        display: flex;
        justify-content: flex-start;
    }

    .btn-submit {
        background: linear-gradient(135deg, #f5f5f5, #d9d9d9);
        color: #111;
        border: none;
        border-radius: 10px;
        padding: 12px 22px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 8px 20px rgba(255, 255, 255, 0.12);
    }

    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(255, 255, 255, 0.18);
    }

    @media (max-width: 576px) {
        .rating-group {
            gap: 8px;
            padding: 8px 10px;
        }

        .rating-group label {
            font-size: 1.8rem;
        }

        .review-title {
            font-size: 16px;
        }
    }
</style>

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
            <form action="?mode=users&action=submitReview" method="POST" class="review-form">
                <div class="review-header">
                    <div class="review-title">Bạn cảm thấy thế nào về trải nghiệm của mình?</div>
                    <div class="review-subtitle">Mức độ hài lòng của bạn giúp chúng tôi cải thiện tốt hơn.</div>
                </div>

                <div class="rating-group" aria-label="Đánh giá sao">
                    <input type="radio" id="star5" name="rating" value="5" required>
                    <label for="star5" title="Rất hài lòng">★</label>

                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4" title="Hài lòng">★</label>

                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3" title="Bình thường">★</label>

                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2" title="Không hài lòng">★</label>

                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1" title="Rất không hài lòng">★</label>
                </div>

                <textarea name="content" class="review-textarea" placeholder="Nhận xét của bạn về trải nghiệm tại trang web..." required></textarea>

                <div class="review-actions">
                    <button type="submit" class="btn-submit">GỬI ĐÁNH GIÁ</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>