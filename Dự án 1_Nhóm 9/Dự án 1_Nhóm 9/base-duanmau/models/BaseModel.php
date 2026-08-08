<?php

class BaseModel
{
    protected $table;
    protected $pdo;

    // Kết nối CSDL
    public function __construct()
    {
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME);

        try {
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
        } catch (PDOException $e) {
            // Xử lý lỗi kết nối
            die("Kết nối cơ sở dữ liệu thất bại: {$e->getMessage()}. Vui lòng thử lại sau.");
        }
    }

    protected function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    protected function commit(): bool
    {
        return $this->pdo->commit();
    }

    protected function rollBack(): bool
    {
        return $this->pdo->rollBack();
    }

    // Hủy kết nối CSDL
    public function __destruct()
    {
        $this->pdo = null;
    }
}
