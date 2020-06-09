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

    public static function getAllTopic()
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT id, name, description FROM topic");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getTopicName()
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT id, name FROM topic");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
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

            $sql = "INSERT INTO topic (name, description) VALUES ('$name', '$description')";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function editTopic($id, $name, $description)
    {
        try {
            $db = static::getDB();

            $sql = "UPDATE topic SET name = '$name', description = '$description' where id = $id";

            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteTopic($id)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM topic WHERE id = $id";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}