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

    public static function deleteAllTestQuestion($testId)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM testquestion WHERE testId = $testId";
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

    public static function getQuestionById($testId)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT testquestion.testId as test_id, question.id as question_id, topic.name as topic_name, question.question as question, question.a as a, question.b as b, question.c as c, question.d as d, question.answer as answer FROM question INNER JOIN testquestion ON question.id = testquestion.questionId INNER JOIN topic ON question.topicId = topic.id WHERE testquestion.testId = $testId");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}