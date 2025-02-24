<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/config/config.php";
class Form_types
{
    public static function get_form_type($id){
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM form_types WHERE id = :id");
        $stmt->bindParam(':id', $id);
        if($stmt->execute()){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            return null;
        }
    }
}