<?php

namespace App\Models;

use PDO;

class Test extends \Core\Model
{
    public $id;
    public $testId;
    public $userId;
    public $content;
    public $create_at;

    public function __construct($id, $testId, $userId, $content, $create_at){
        $this->id = $id;
        $this->testId = $testId;
        $this->userId = $userId;
        $this->content = $content;
        $this->create_at = $create_at;
    }

    public static function getComment($id)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT * FROM comment WHERE id = $id");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function createCommment($testId, $userId, $content, $create_at)
    {
        try {
            $db = static::getDB();

            $sql = "INSERT INTO comment (testId, userId, content, create_at) VALUES ($testId, $userId, $content, $create_at)";

            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function updateComment($id, $testId, $userId, $content, $create_at)
    {

        try {
            $db = static::getDB();

            // $stmt = $db->query('UPDATE topic SET name = $name, description = $description WHERE id = $id');

            $sql = "UPDATE comment SET testId = $testId, userId = $userId, content = $content, create_at = $create_at  WHERE id = $id";
            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteComment($id)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM comment WHERE id = $id";
            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getAll()
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT * FROM comment");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}