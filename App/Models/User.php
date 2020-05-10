<?php

namespace App\Models;

use PDO;

class User extends \Core\Model
{
    public $id;
    public $email;
    public $password;
    public $role;

    public function __construct($id, $email, $password, $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public static function getOne($id)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT id, email, userName, password, role FROM user WHERE id = $id");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function createUser($email, $password)
    {
        try {
            $db = static::getDB();

            // $stmt = $db->prepare('INSERT INTO user (email, password) Values (:email, :password)');
            // $stmt->bindParam(':email', $p1);
            // $stmt->bindParam(':password', $p2);

            // $p1 = $email;
            // $p2 = $password;
            
            $sql = "INSERT INTO user (email, password) VALUES ($email, $password)";

            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}