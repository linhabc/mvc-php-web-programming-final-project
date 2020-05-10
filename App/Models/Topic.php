<?php

namespace App\Models;

use PDO;

class Topic extends \Core\Model
{
    public $id;
    public $name;
    public $description;

    public function __construct($id, $name, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public static function getTopic($id)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT id, name, description FROM topic WHERE id = $id");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function createTopic($name, $description)
    {
        try {
            $db = static::getDB();

            // $stmt = $db->prepare("INSERT INTO topic (name,description) VALUES (:name,:description)");

            // $stmt->bindParam(':name', $p1);
            // $stmt->bindParam(':description', $p2);

            // $p1 = $name;
            // $p2 = $description;

            $sql = "INSERT INTO topic (name,description) VALUES ($name, $description)";
            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function updateTopic($id, $name, $description)
    {

        try {
            $db = static::getDB();

            // $stmt = $db->query('UPDATE topic SET name = $name, description = $description WHERE id = $id');

            $sql = "UPDATE topic SET name = $name, description = $description WHERE id = $id";
            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteTopic($id)
    {

        try {
            //$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $db = static::getDB();

            // $stmt = $db->query('DELETE FROM topic WHERE id = $id');
            // $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // return $results;

            $sql = "DELETE FROM topic WHERE id = $id";
            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}