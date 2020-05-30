<?php

namespace App\Models;

use PDO;

class Result extends \Core\Model
{
    public $userId;
    public $testId;
    public $score;
    public $rating;
    public $create_at;

    public function __construct($userId, $testId, $score, $rating, $create_at)
    {
        $this->userId = $userId;
        $this->testId = $testId;
        $this->score = $score;
        $this->rating = $rating;
        $this->create_at = $create_at;
    }

    public static function getResult($userId, $testId)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT userId, testId, score, rating, create_at FROM result WHERE userId = $userId AND testId = $testId");
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

    public static function deleteResult($userId, $testId)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM result WHERE userId = $userId AND testId = $testId";
            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function updateResult($userId, $testId, $score, $rating, $create_at)
    {

        try {
            $db = static::getDB();

            $sql = "UPDATE result SET score = $score, rating = $rating,create_at = $create_at  WHERE userId = $userId AND testId = $testId";
            $stmt->execute($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}