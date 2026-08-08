<?php

class UserModel extends BaseModel
{
    public function getAll()
    {
        $sql = "SELECT * FROM users ORDER BY user_id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM users WHERE user_id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function register(array $data): int
    {
        $nextId = $this->getNextUserId();
        $sql = "INSERT INTO users (user_id, name, email, password, phone, role) VALUES (:user_id, :name, :email, :password, :phone, :role)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $nextId);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':password', $data['password_hash']);
        $stmt->bindValue(':phone', $data['phone']);
        $stmt->bindValue(':role', $data['role'] ?? 'user');
        $stmt->execute();

        return $nextId;
    }

    private function getNextUserId(): int
    {
        $stmt = $this->pdo->query("SELECT MAX(user_id) AS max_id FROM users");
        $row = $stmt->fetch();
        return (int) ($row['max_id'] ?? 0) + 1;
    }

    public function getAddressesByUser(int $userId): array
    {
        $sql = "SELECT * FROM addresses WHERE user_id = :user_id ORDER BY address_id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAddressById(int $addressId, int $userId)
    {
        $sql = "SELECT * FROM addresses WHERE address_id = :address_id AND user_id = :user_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':address_id', $addressId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function addAddress(int $userId, string $receiverName, string $phone, string $address): bool
    {
        $addressId = $this->getNextAddressId();
        $sql = "INSERT INTO addresses (address_id, user_id, receiver_name, phone, address) VALUES (:address_id, :user_id, :receiver_name, :phone, :address)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':address_id', $addressId);
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':receiver_name', $receiverName);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':address', $address);
        return $stmt->execute();
    }

    public function deleteAddress(int $addressId, int $userId): bool
    {
        $sql = "DELETE FROM addresses WHERE address_id = :address_id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':address_id', $addressId);
        $stmt->bindValue(':user_id', $userId);
        return $stmt->execute();
    }

    private function getNextAddressId(): int
    {
        $stmt = $this->pdo->query("SELECT MAX(address_id) AS max_id FROM addresses");
        $row = $stmt->fetch();
        return (int) ($row['max_id'] ?? 0) + 1;
    }

    public function getWishlistByUser(int $userId): array
    {
        $sql = "SELECT w.wishlist_id, w.product_id, p.product_name, p.price, p.img, p.size_id, s.size_name
                FROM wishlist w
                JOIN products p ON w.product_id = p.product_id
                LEFT JOIN sizes s ON p.size_id = s.size_id
                WHERE w.user_id = :user_id
                ORDER BY w.wishlist_id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addWishlist(int $userId, int $productId): bool
    {
        $existing = $this->getWishlistItem($userId, $productId);
        if ($existing) {
            return true;
        }

        $wishlistId = $this->getNextWishlistId();
        $sql = "INSERT INTO wishlist (wishlist_id, user_id, product_id, created_at) VALUES (:wishlist_id, :user_id, :product_id, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':wishlist_id', $wishlistId);
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':product_id', $productId);
        return $stmt->execute();
    }

    public function removeWishlist(int $wishlistId, int $userId): bool
    {
        $sql = "DELETE FROM wishlist WHERE wishlist_id = :wishlist_id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':wishlist_id', $wishlistId);
        $stmt->bindValue(':user_id', $userId);
        return $stmt->execute();
    }

    private function getWishlistItem(int $userId, int $productId)
    {
        $sql = "SELECT * FROM wishlist WHERE user_id = :user_id AND product_id = :product_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':product_id', $productId);
        $stmt->execute();
        return $stmt->fetch();
    }

    private function getNextWishlistId(): int
    {
        $stmt = $this->pdo->query("SELECT MAX(wishlist_id) AS max_id FROM wishlist");
        $row = $stmt->fetch();
        return (int) ($row['max_id'] ?? 0) + 1;
    }

<<<<<<< HEAD
    public function createOrderWithDetails(int $userId, float $total, array $items, string $paymentMethod, string $paymentStatus): int
    {
        $this->beginTransaction();

        try {
            $orderId = $this->getNextOrderId();
            $sql = "INSERT INTO orders (order_id, user_id, order_date, total_money, status) VALUES (:order_id, :user_id, :order_date, :total_money, :status)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':order_date', date('Y-m-d'));
            $stmt->bindValue(':total_money', $total);
            $stmt->bindValue(':status', 'Chờ xác nhận');
            $stmt->execute();

            $sqlPayment = "INSERT INTO payment (order_id, payment_method, payment_status, payment_date) VALUES (:order_id, :payment_method, :payment_status, :payment_date)";
            $stmtPayment = $this->pdo->prepare($sqlPayment);
            $stmtPayment->bindValue(':order_id', $orderId, PDO::PARAM_INT);
            $stmtPayment->bindValue(':payment_method', $paymentMethod);
            $stmtPayment->bindValue(':payment_status', $paymentStatus);
            $stmtPayment->bindValue(':payment_date', date('Y-m-d H:i:s'));
            $stmtPayment->execute();

            foreach ($items as $item) {
                $sqlDetail = "INSERT INTO order_details (order_id, product_id, quantity, price, size_id) VALUES (:order_id, :product_id, :quantity, :price, :size_id)";
                $stmtDetail = $this->pdo->prepare($sqlDetail);
                $stmtDetail->bindValue(':order_id', $orderId, PDO::PARAM_INT);
                $stmtDetail->bindValue(':product_id', (int) ($item['product_id'] ?? 0), PDO::PARAM_INT);
                $stmtDetail->bindValue(':quantity', (int) ($item['quantity'] ?? 1), PDO::PARAM_INT);
                $stmtDetail->bindValue(':price', (float) ($item['price'] ?? 0));
                $stmtDetail->bindValue(':size_id', (int) ($item['size_id'] ?? 0), PDO::PARAM_INT);
                $stmtDetail->execute();
            }

            $this->commit();
            return $orderId;
        } catch (Throwable $e) {
            $this->rollBack();
            throw $e;
        }
    }

    private function getNextOrderId(): int
    {
        $stmt = $this->pdo->query("SELECT MAX(order_id) AS max_id FROM orders");
        $row = $stmt->fetch();
        return (int) ($row['max_id'] ?? 0) + 1;
    }

    public function getOrdersByUser(int $userId): array
    {
        $sql = "SELECT o.*, p.payment_method, p.payment_status FROM orders o LEFT JOIN payment p ON o.order_id = p.order_id WHERE o.user_id = :user_id ORDER BY o.order_id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOrderById(int $orderId, int $userId)
    {
        $sql = "SELECT o.*, p.payment_method, p.payment_status FROM orders o LEFT JOIN payment p ON o.order_id = p.order_id WHERE o.order_id = :order_id AND o.user_id = :user_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllOrders(): array
    {
        $sql = "SELECT o.*, u.name AS user_name, u.email AS user_email, p.payment_method, p.payment_status FROM orders o JOIN users u ON o.user_id = u.user_id LEFT JOIN payment p ON o.order_id = p.order_id ORDER BY o.order_id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOrderByIdAdmin(int $orderId)
    {
        $sql = "SELECT o.*, u.name AS user_name, u.email AS user_email, p.payment_method, p.payment_status FROM orders o JOIN users u ON o.user_id = u.user_id LEFT JOIN payment p ON o.order_id = p.order_id WHERE o.order_id = :order_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateOrderStatus(int $orderId, string $status): bool
    {
        $sql = "UPDATE orders SET status = :status WHERE order_id = :order_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getOrderDetails(int $orderId): array
    {
        $sql = "SELECT od.*, p.product_name, p.img, s.size_name
                FROM order_details od
                JOIN products p ON od.product_id = p.product_id
                LEFT JOIN sizes s ON od.size_id = s.size_id
                WHERE od.order_id = :order_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
=======
   public function getOrdersByUser(int $userId): array
{
    $sql = "
        SELECT *
        FROM orders
        WHERE user_id = :user_id
        ORDER BY order_id DESC
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->bindValue(
        ':user_id',
        $userId,
        PDO::PARAM_INT
    );

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getOrderById(
    int $orderId,
    int $userId
) {
    $sql = "
        SELECT *
        FROM orders
        WHERE order_id = :order_id
        AND user_id = :user_id
        LIMIT 1
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->bindValue(
        ':order_id',
        $orderId,
        PDO::PARAM_INT
    );

    $stmt->bindValue(
        ':user_id',
        $userId,
        PDO::PARAM_INT
    );

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function getOrderDetails(
    int $orderId
): array {

    $sql = "
        SELECT
            od.*,
            p.product_name,
            p.img
        FROM order_details od

        LEFT JOIN products p
            ON od.product_id = p.product_id

        WHERE od.order_id = :order_id
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->bindValue(
        ':order_id',
        $orderId,
        PDO::PARAM_INT
    );

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
>>>>>>> 8c12713984b5f03d5d97580439140bfe66b2086e

    public function getCommentsByUser(int $userId): array
    {
        $sql = "SELECT c.*, p.product_name FROM comments c JOIN products p ON c.product_id = p.product_id WHERE c.user_id = :user_id ORDER BY c.comment_date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addComment(int $userId, int $productId, string $content): bool
    {
        $commentId = $this->getNextCommentId();
        $sql = "INSERT INTO comments (comment_id, user_id, product_id, content, comment_date) VALUES (:comment_id, :user_id, :product_id, :content, :comment_date)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':comment_id', $commentId);
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':product_id', $productId);
        $stmt->bindValue(':content', $content);
        $stmt->bindValue(':comment_date', date('Y-m-d'));
        return $stmt->execute();
    }

    public function removeComment(int $commentId, int $userId): bool
    {
        $sql = "DELETE FROM comments WHERE comment_id = :comment_id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':comment_id', $commentId);
        $stmt->bindValue(':user_id', $userId);
        return $stmt->execute();
    }

    private function getNextCommentId(): int
    {
        $stmt = $this->pdo->query("SELECT MAX(comment_id) AS max_id FROM comments");
        $row = $stmt->fetch();
        return (int) ($row['max_id'] ?? 0) + 1;
    }
    public function updateProfile(
    int $userId,
    string $name,
    string $email,
    string $phone,
    string $gender,
    string $dateOfBirth,
    string $city,
    string $district,
    ?string $avatar
): bool {

    $sql = "
        UPDATE users
        SET
            name = :name,
            email = :email,
            phone = :phone,
            gender = :gender,
            date_of_birth = :date_of_birth,
            city = :city,
            district = :district,
            avatar = :avatar
        WHERE user_id = :user_id
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':phone', $phone);

    $stmt->bindValue(
        ':gender',
        $gender !== '' ? $gender : null,
        $gender !== '' ? PDO::PARAM_STR : PDO::PARAM_NULL
    );

    $stmt->bindValue(
        ':date_of_birth',
        $dateOfBirth !== '' ? $dateOfBirth : null,
        $dateOfBirth !== '' ? PDO::PARAM_STR : PDO::PARAM_NULL
    );

    $stmt->bindValue(
        ':city',
        $city !== '' ? $city : null,
        $city !== '' ? PDO::PARAM_STR : PDO::PARAM_NULL
    );

    $stmt->bindValue(
        ':district',
        $district !== '' ? $district : null,
        $district !== '' ? PDO::PARAM_STR : PDO::PARAM_NULL
    );

    $stmt->bindValue(
        ':avatar',
        $avatar !== null ? $avatar : null,
        $avatar !== null ? PDO::PARAM_STR : PDO::PARAM_NULL
    );

    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);

    return $stmt->execute();
}
}
