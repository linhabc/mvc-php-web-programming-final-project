<?php

namespace App\Models;

use PDO;

class Test extends \Core\Model
{
    public $id;
    public $topicId;
    public $userId;
    public $name;
    public $description;

    public function __construct($id, $topicId, $userId, $name, $description){
        $this->id = $id;
        $this->topicId = $topicId;
        $this->userId = $userId;
        $this->name = $name;
        $this->description = $description;
    }

    public static function getTest($id)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT * FROM test WHERE id = $id");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function createTest($topicId, $userId, $name, $description)
    {
        try {
            $db = static::getDB();

            $sql = "INSERT INTO test (topic_id, user_id, name, description) VALUES ($id, $topicId, $name, $description)";

            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function updateTest($id, $topicId, $userId, $name, $description)
    {

        try {
            $db = static::getDB();

            // $stmt = $db->query('UPDATE topic SET name = $name, description = $description WHERE id = $id');

            $sql = "UPDATE test SET topic_id = $topic_id, user_id = $user_id, name = $name, description = $description  WHERE id = $id";
            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteTest($id)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM test WHERE id = $id";
            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getAll()
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT * FROM test");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}