<?php
class ProductModel extends BaseModel{
    public function getAll(){
        $sql = "SELECT ban2.*,ban1.name as ban1_name from ban2 join ban1 on ban2.department_id = ban1.id  ";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> execute();
        return $stmt->fetchAll();
    }
    public function insert($data){
        $sql = "SELECT INTO ban2(name,email,avatar,salary,department_id values :name,:email,:avatar,:salary,:department_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);

    }
}   



?>