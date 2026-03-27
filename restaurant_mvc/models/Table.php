<?php
require_once 'commons/function.php';

class Table {
    
    public function all() {
        $conn = connectDB();
        $sql = "SELECT * FROM tables ORDER BY table_number";
        return $conn->query($sql)->fetchAll();
    }
    
    public function findById($id) {
        $conn = connectDB();
        $sql = "SELECT * FROM tables WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $conn = connectDB();
        $sql = "INSERT INTO tables(table_number, status) VALUES(:table_number, :status)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute($data);
    }
    
    public function update($id, $data) {
        $conn = connectDB();
        
        // Nếu chỉ cập nhật status (table_number trống), chỉ update status
        if(isset($data[':table_number']) && empty($data[':table_number']) && isset($data[':status'])) {
            $sql = "UPDATE tables SET status = :status WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $params = [':id' => $id, ':status' => $data[':status']];
            return $stmt->execute($params);
        }
        
        // Cập nhật cả table_number và status
        $sql = "UPDATE tables SET table_number = :table_number, status = :status WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $data[':id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id) {
        $conn = connectDB();
        $sql = "DELETE FROM tables WHERE id = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    public function getAvailable() {
        $conn = connectDB();
        $sql = "SELECT * FROM tables WHERE status = 'available' ORDER BY table_number";
        return $conn->query($sql)->fetchAll();
    }

    public function getByStatus($status) {
        $conn = connectDB();
        $sql = "SELECT * FROM tables WHERE status = :status ORDER BY table_number";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':status' => $status]);
        return $stmt->fetchAll();
    }

    public function getLastInsertId() {
        $conn = connectDB();
        return $conn->lastInsertId();
    }
}

