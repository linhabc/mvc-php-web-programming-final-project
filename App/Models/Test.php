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
    public $duration;

    public function __construct($id, $topicId, $userId, $name, $description)
    {
        $this->id = $id;
        $this->topicId = $topicId;
        $this->userId = $userId;
        $this->name = $name;
        $this->description = $description;
    }

    public static function getAllTest()
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT test.id,topic.name as to_name, test.name as te_name,test.description as te_des, test.duration as te_duration FROM test INNER JOIN topic ON test.topic_id = topic.id");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteTest($id)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM test WHERE id = $id";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
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

    public static function createTest($topicId, $userId, $name, $description, $duration)
    {
        try {
            $db = static::getDB();

            $sql = "INSERT INTO test (topic_id, user_id, name, description, duration) VALUES ('$topicId', '$userId', '$name', '$description', '$duration')";

            // $stmt = $db->prepare($sql);
            // $stmt->execute();

            // $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $db->exec($sql);
            $last_id = $db->lastInsertId();

            return $last_id;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function updateTest($id, $topicId, $userId, $name, $description, $duration)
    {

        try {
            $db = static::getDB();

            // $stmt = $db->query('UPDATE topic SET name = $name, description = $description WHERE id = $id');

            $sql = "UPDATE test SET topic_id = $topic_id, user_id = $user_id, name = $name, description = $description, duration = $duration  WHERE id = $id";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getTestByUserId($userId)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT test.id,topic.name as to_name, test.name as te_name,test.description as te_des, test.duration as te_duration FROM test INNER JOIN topic ON test.topic_id = topic.id WHERE user_id = $userId");
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}