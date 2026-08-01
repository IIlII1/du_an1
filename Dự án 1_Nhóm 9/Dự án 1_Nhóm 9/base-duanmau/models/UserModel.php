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
}
