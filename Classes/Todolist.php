<?php

class Todolist{
    private PDO $conn;

    public function __construct(PDO $conn){
        $this->conn = $conn;
    }

    public function createList(string $list){
        $idStatus = 2;
        $sql = "INSERT INTO t_list (list, user_id, status_id) VALUES (:list, :user_id, :status_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':list', $list);
        $stmt->bindParam(':user_id', $_SESSION['usr']['id_user']);
        $stmt->bindParam(':status_id', $idStatus);
        return $stmt->execute();
    }

    public function getByUsrId() : ?array {
        $sql = "SELECT * FROM t_list WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $_SESSION['usr']['id_user']);
        $stmt->execute();

        $todolist = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $todolist ?: null;
    }

    public function delete(){
        $sql = "DELETE FROM t_list WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $_SESSION['usr']['id_user']);
        return $stmt->execute();
    }

    public function delById(int $id_list){
        $sql = "DELETE FROM t_list WHERE id_list = :id_list AND user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_list', $id_list);
        $stmt->bindParam(':user_id', $_SESSION['usr']['id_user']);
        return $stmt->execute();
    }

    public function finish(int $id_list){
        $sql = "UPDATE t_list SET status_id = :status_id WHERE id_list = :id_list";
        $stmt = $this->conn->prepare($sql);
        $status_id = 1;
        $stmt->bindParam(':status_id', $status_id);
        $stmt->bindParam(':id_list', $id_list);

        return $stmt->execute();
    }


}