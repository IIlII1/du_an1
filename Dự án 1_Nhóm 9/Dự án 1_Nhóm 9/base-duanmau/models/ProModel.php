<?php
class ProModel extends BaseModel
{
    public function getAll()
    {
        $sql = "SELECT * FROM `products`";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getLatestProducts()
    {
        $sql = "SELECT p.*, c.cate_name AS category_name FROM `products` p JOIN `categories` c ON p.cate_id = c.cate_id ORDER BY p.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductsByCategoryName($categoryName)
    {
        $sql = "SELECT p.*, c.cate_name AS category_name FROM `products` p JOIN `categories` c ON p.cate_id = c.cate_id WHERE LOWER(c.cate_name) = LOWER(:cate_name) ORDER BY p.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cate_name', $categoryName);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function searchByName($keyword)
    {
        $sql = "SELECT p.*, c.cate_name AS category_name FROM `products` p JOIN `categories` c ON p.cate_id = c.cate_id WHERE p.product_name LIKE :keyword OR p.description LIKE :keyword ORDER BY p.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':keyword', '%' . $keyword . '%');
        $stmt->execute();
        return $stmt->fetchAll();
    }
public function getProductById($id)
{
    $sql = "
        SELECT 
            p.*,
            c.cate_name AS category_name
        FROM products p
        LEFT JOIN categories c
            ON p.cate_id = c.cate_id
        WHERE p.product_id = :id
        LIMIT 1
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function getProductSizes($productId)
{
    $sql = "
        SELECT
            ps.*,
            s.*
        FROM product_size ps

        INNER JOIN sizes s
            ON ps.size_id = s.size_id

        WHERE ps.product_id = :product_id
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        ':product_id' => $productId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getAllSizes()
    {
        $sql = "SELECT * FROM sizes ORDER BY size_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getRelatedProducts($productId, $cateId, $limit = 4)
    {
        $sql = "
            SELECT p.*, c.cate_name AS category_name
            FROM products p
            JOIN categories c ON p.cate_id = c.cate_id
            WHERE p.cate_id = :cate_id
              AND p.product_id <> :product_id
            ORDER BY p.created_at DESC
            LIMIT :limit
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cate_id', $cateId, PDO::PARAM_INT);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductImages($productId)
    {
        $sql = "
            SELECT pi.img_url
            FROM product_img pi
            WHERE pi.product_id = :product_id
            ORDER BY pi.img_id ASC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':product_id' => $productId]);
        return $stmt->fetchAll();
    }

    public function getProductsByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $ids = array_map('intval', $ids);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "
            SELECT p.*, c.cate_name AS category_name
            FROM products p
            JOIN categories c ON p.cate_id = c.cate_id
            WHERE p.product_id IN ($placeholders)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($ids);
        return $stmt->fetchAll();
    }
    public function getById($id)
    {
        $sql = "SELECT * FROM products WHERE product_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function addPro($data)
    {
        $sql = "INSERT INTO products (cate_id, size_id, product_name, description, price, img, stock, created_at) VALUES (:cate_id, :size_id, :product_name, :description, :price, :img, :stock, :created_at)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cate_id', $data['cate_id']);
        $stmt->bindValue(':size_id', $data['size_id']);
        $stmt->bindValue(':product_name', $data['product_name']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':price', $data['price']);
        $stmt->bindValue(':img', $data['img']);
        $stmt->bindValue(':stock', $data['stock']);
        $stmt->bindValue(':created_at', $data['created_at']);
        return $stmt->execute();
    }

    public function updatePro($id, $data)
    {
        $sql = "UPDATE products SET cate_id = :cate_id, size_id = :size_id, product_name = :product_name, description = :description, price = :price, stock = :stock, created_at = :created_at";

        if (!empty($data['img'])) {
            $sql .= ", img = :img";
        }

        $sql .= " WHERE product_id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cate_id', $data['cate_id']);
        $stmt->bindValue(':size_id', $data['size_id']);
        $stmt->bindValue(':product_name', $data['product_name']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':price', $data['price']);
        $stmt->bindValue(':stock', $data['stock']);
        $stmt->bindValue(':created_at', $data['created_at']);
        $stmt->bindValue(':id', $id);

        if (!empty($data['img'])) {
            $stmt->bindValue(':img', $data['img']);
        }

        return $stmt->execute();
    }

    public function deletePro($id)
    {
        try {
            $this->pdo->beginTransaction();

            $dependentTables = [
                'wishlist',
                'product_img',
                'product_size',
                'comments',
                'cart_detail'
            ];

            foreach ($dependentTables as $table) {
                $sql = "DELETE FROM {$table} WHERE product_id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }

            $sql = "DELETE FROM products WHERE product_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}
?>