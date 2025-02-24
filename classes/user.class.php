<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/config/config.php";

class User{
    public static function getUserById($id){
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}