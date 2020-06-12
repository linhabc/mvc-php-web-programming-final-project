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
    public $time;

    public static function createResult($userId, $testId, $score, $rating, $create_at)
    {
        try {
            $db = static::getDB();

            $sql = "INSERT INTO result (userId, testId, score, rating, create_at) VALUES ($userId, $testId, $score, $rating, $create_at)";

            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function createResultWithObject($result)
    {
        try {
            $db = static::getDB();

            $sql = "INSERT INTO result (userId, testId, score, rating, create_at, time) VALUES ('$result->userId', '$result->testId', '$result->score', '$result->rating', FROM_UNIXTIME($result->create_at), '$result->time')";

            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteResult($id)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM result WHERE id = $id";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function updateResult($id, $userId, $testId, $score, $rating, $create_at)
    {

        try {
            $db = static::getDB();

            $sql = "UPDATE result SET userId = $userId, testId = $testId, score = $score, rating = $rating,create_at = $create_at  WHERE id = $id";
            $db->exec($sql);

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

    public static function getResult($userId, $testId)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT * FROM result WHERE userId = $userId AND testId = $testId LIMIT 1");
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\Models\Result');
            $result = $stmt->fetch();

            return $result;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getResultsByTestId($testId)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT r.*, u.userName FROM result as r, user as u
                                WHERE testId = $testId
                                AND r.userId = u.id
                                ORDER BY r.score DESC, r.time ASC, r.create_at ASC
                                ");
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\Models\Result');
            $result = $stmt->fetchAll();

            return $result;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
