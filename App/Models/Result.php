<?php

namespace App\Models;

use PDO;

class Result extends \Core\Model
{
    public $id;
    public $userId;
    public $testId;
    public $score;
    public $rating;
    public $create_at;
    // Thêm trường thời gian làm bài
    // public $time;

    public function __construct($id, $userId, $testId, $score, $rating, $create_at)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->testId = $testId;
        $this->score = $score;
        $this->rating = $rating;
        $this->create_at = $create_at;
    }

    public static function getResult($id)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT * FROM result WHERE id = $id");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function createResult($userId, $testId, $score, $rating, $create_at)
    {
        try {
            $db = static::getDB();
           
            $sql = "INSERT INTO result (userId, testId, score, rating, create_at) VALUES ($userId, $testId, $score, $rating, $create_at)";

            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteResult($id)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM result WHERE id = $id";
            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function updateResult($id, $userId, $testId, $score, $rating, $create_at)
    {

        try {
            $db = static::getDB();

            $sql = "UPDATE result SET userId = $userId, testId = $testId, score = $score, rating = $rating,create_at = $create_at  WHERE id = $id";
            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getAll()
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT * FROM result");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}