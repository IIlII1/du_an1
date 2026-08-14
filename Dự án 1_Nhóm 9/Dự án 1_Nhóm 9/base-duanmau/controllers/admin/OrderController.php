<?php

class OrderController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $orders = $this->userModel->getAllOrders();
        $statusClassMap = [
            'Chờ xác nhận' => 'badge-warning',
            'Đã xác nhận' => 'badge-info',
            'Đang giao' => 'badge-primary',
            'Hoàn thành' => 'badge-success',
            'Đã hủy' => 'badge-danger',
        ];
        require_once PATH_VIEW_ADMIN . 'order/index.php';
    }
   

    public function detail()
    {
        $orderId = (int) ($_GET['id'] ?? 0);
        if ($orderId <= 0) {
            header('Location: ' . BASE_URL . '?mode=admin&action=orders');
            exit;
        }

        $order = $this->userModel->getOrderByIdAdmin($orderId);
        if (!$order) {
            $_SESSION['admin_error'] = 'Không tìm thấy đơn hàng.';
            header('Location: ' . BASE_URL . '?mode=admin&action=orders');
            exit;
        }

        $details = $this->userModel->getOrderDetails($orderId);
        require_once PATH_VIEW_ADMIN . 'order/detail.php';
    }

    public function approve()
    {
        $orderId = (int) ($_GET['id'] ?? 0);
        if ($orderId > 0) {
            $this->userModel->updateOrderStatus($orderId, 'Đã xác nhận');
            $_SESSION['success'] = 'Đơn hàng đã được xác nhận.';
        }
        header('Location: ' . BASE_URL . '?mode=admin&action=orders');
        exit;
    }

    public function cancel()
    {
        $orderId = (int) ($_GET['id'] ?? 0);
        if ($orderId > 0) {
            $this->userModel->updateOrderStatus($orderId, 'Đã hủy');
            $_SESSION['success'] = 'Đơn hàng đã bị hủy.';
        }
        header('Location: ' . BASE_URL . '?mode=admin&action=orders');
        exit;
    }
}
