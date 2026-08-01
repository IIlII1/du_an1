<?php
class ProModel extends BaseModel
{
    public function getAll()
    {
        $sql = "SELECT p.*, c.cate_name, s.size_name FROM products p
                LEFT JOIN categories c ON p.cate_id = c.cate_id
                LEFT JOIN sizes s ON p.size_id = s.size_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
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

    public function getTop4Lastest()
    {
        $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT 4";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
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
        $sql = "DELETE FROM products WHERE `products`.`product_id` = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
?>