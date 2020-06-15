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

    public static function deleteResult($userId)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM result WHERE userId = $userId";
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

    public static function getResultUid($userId)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT topic.name as to_name, test.name, test.topic_id, test.description, test.duration, result.userId, result.testId, user.username, result.score, result.rating, result.create_at, result.time FROM result INNER JOIN user ON result.userId = user.id INNER JOIN test ON result.testId = test.id INNER JOIN topic ON test.topic_id = topic.id WHERE result.userId = $userId");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

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

    public static function getResultByTestId($testId)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT result.userId, result.testId, user.username, result.score, result.rating, result.create_at, result.time FROM result INNER JOIN user ON result.userId = user.id WHERE testId = $testId");

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
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

    public static function getResultTopic($userId)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT DISTINCT topic.id
                                FROM result 
                                INNER JOIN user ON result.userId = user.id 
                                INNER JOIN test ON result.testId = test.id 
                                INNER JOIN topic ON test.topic_id = topic.id 
                                WHERE result.userId = $userId");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getResultQuestion($userId)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT DISTINCT testquestion.questionId   
                                FROM result 
                                INNER JOIN testquestion ON result.testId = testquestion.testId                                
                                WHERE result.userId = $userId");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
