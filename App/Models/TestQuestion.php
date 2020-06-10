<?php

namespace App\Models;

use PDO;

class TestQuestion extends \Core\Model
{
    public $testId;
    public $questionId;

    public function __construct($testId, $questionId)
    {
        $this->testId = $testId;
        $this->questionId = $questionId;
    }

    public static function getAll()
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT * FROM testquestion");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteTestQuestion($testId, $questionId)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM testquestion WHERE testId = $testId AND questionId = $questionId";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getTestQuestion($testId, $questionId)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT * FROM testquestion WHERE testId = $testId AND questionId = $questionId");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function createTestQuestion($testId, $questionId)
    {
        try {
            $db = static::getDB();

            $sql = "INSERT INTO testquestion (testId, questionId) VALUES ('$testId', '$questionId')";

            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}