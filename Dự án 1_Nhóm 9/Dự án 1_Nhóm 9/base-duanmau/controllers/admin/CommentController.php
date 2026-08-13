<?php

class CommentController extends BaseModel
{
    // Hiển thị danh sách đánh giá trang web
    public function index()
{
    $sql = "SELECT c.*, u.name as user_name 
            FROM comments c 
            JOIN users u ON c.user_id = u.user_id 
            WHERE c.product_id = -1 
            ORDER BY c.comment_id DESC"; 
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $reviews = $stmt->fetchAll();

    $view = 'comment/index';
require_once PATH_VIEW_ADMIN . 'layout.php';
}
    // Xóa đánh giá
    public function remove()
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $sql = "DELETE FROM comments WHERE comment_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            $_SESSION['success'] = 'Đã xóa đánh giá.';
        }
        header('Location: ' . BASE_URL . '?mode=admin&action=listComments');
        exit;
    }
}