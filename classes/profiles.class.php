<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/config/config.php";
class Profiles
{
    private $id;
    private $name;
    private $email;
    private $surname;

    public static function create($name,$surname,$email)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO profiles (name, surname, email) VALUES (:name, :surname, :email)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $pdo->lastInsertId();
    }
}