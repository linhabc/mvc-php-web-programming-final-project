<?php

namespace App\Models;

use PDO;

class User extends \Core\Model
{

    public static function getOne($id)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT id, name, description FROM topic WHERE id = $id');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function create($id, $name, $description)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query('INSERT INTO topic ('id','name','description') VALUES ('$id','$name','$description')');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function updateOne($id, $name, $description)
    {
        //$host = 'localhost';
        //$dbname = 'mvc';
        //$username = 'root';
        //$password = 'secret';

        try {
            //$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $db = static::getDB();

            $stmt = $db->query('UPDATE topic SET name = '$name', description = '$description' WHERE id = $id');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public static function deleteOne($id)
    {
        //$host = 'localhost';
        //$dbname = 'mvc';
        //$username = 'root';
        //$password = 'secret';

        try {
            //$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $db = static::getDB();

            $stmt = $db->query('DELETE FROM topic WHERE id = $id');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}