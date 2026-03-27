<?php
class ontap2Model extends BaseModel{
    public function getAll(){
       $sql = "SELECT ban2.* , ban1.name AS ban1_name
        FROM ban2
        JOIN ban1 ON ban2.club_id = ban1.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     public function insert($data){
    $sql = "INSERT INTO ban2 (name, club_id, position, date_of_birth)
            VALUES (:name, :club_id, :position, :date_of_birth)";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute($data);
}

    public function delete($id){
    $sql = "DELETE FROM ban2 WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
    }
    //xem chi tiết
    public function getById($id){
        $sql= "SELECT * FROM ban2 WHERE id = $id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchObject();
    }


}
?>