<?php

namespace App\Models;

use PDO;

class User extends \Core\Model
{
    public $id;
    public $email;
    public $userName;
    public $password;
    public $role;

    public function __construct($id, $email, $password, $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public static function getAll()
    {

        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM user ORDER BY id');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function login($email, $password)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT id, email, username, password, role FROM user WHERE email = '$email' LIMIT 1");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $hashPass = $result[0]['password'];

            if (password_verify($password, $hashPass)) {
                return $result;
            } else {
                return null;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getUser($id)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT id, email, username, password, role FROM user WHERE id = $id");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function createAdmin($email, $username, $password)
    {
        try {
            $db = static::getDB();

            $sql = "INSERT INTO user (id, email, username, password, role) VALUES (NULL, '$email', '$username', '$password', 'Admin')";
            // $sql = "INSERT INTO user (id, email, username, password) VALUES (NULL, 'b@gmail.com', 'aloalo', '123')";

            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function editAdmin($id, $email, $username)
    {
        try {
            $db = static::getDB();

            $sql = "UPDATE user SET email = '$email', username = '$username' where id = $id";

            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function createUser($email, $username, $password)
    {
        try {
            $db = static::getDB();

            $sql = "INSERT INTO user (id, email, username, password) VALUES (NULL, '$email', '$username', '$password')";
            $db->exec($sql);

            $last_id = $db->lastInsertId();

            return $last_id;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteUser($id)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM user WHERE id = $id";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function updateUser($id, $email, $password, $role)
    {

        try {
            $db = static::getDB();

            $sql = "UPDATE user SET email = $email, password = $password, role = $role WHERE id = $id";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function editUser($id, $username, $password)
    {

        try {
            $db = static::getDB();

            $sql = "UPDATE user SET username = '$username', password = '$password' WHERE id = $id";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function editUserName($id, $username) 
    {
        try {
            $db = static::getDB();

            $sql = "UPDATE user SET username = '$username' WHERE id = $id";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
