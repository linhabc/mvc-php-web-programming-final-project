<?php

namespace App\Models;

use PDO;

class Question extends \Core\Model
{
    public $id;
    public $topicId;
    public $userId;
    public $question;
    public $answer;
    public $a;
    public $b;
    public $c;
    public $d;

    public function __construct($id, $topicId, $userId, $question, $answer, $a, $b, $c, $d)
    {
        $this->id = $id;
        $this->topicId = $topicId;
        $this->userId = $userId;
        $this->question = $question;
        $this->answer = $answer;
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
        $this->d = $d;
    }

    public static function getAllQuestion()
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT * FROM question");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getQuestion($id)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT * FROM question WHERE id = $id");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function createQuestion($topicId, $userId, $question, $answer, $a, $b, $c, $d)
    {
        try {
            $db = static::getDB();

            $sql = "INSERT INTO question (topicId, userId, question, answer, a, b, c, d) VALUES ($id, $topicId, $userId, $question, $answer, $a, $b, $c, $d)";

            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteQuestion($id)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM question WHERE id = $id";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function updateQuestion($id, $topicId, $userId, $question, $answer, $a, $b, $c, $d)
    {

        try {
            $db = static::getDB();

            $sql = "UPDATE question SET topicId = $topicId, userId = $userId, question = $question, answer = $answer, a = $a, b = $b, c = $c, d = $d WHERE id = $id";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getRandomQuestion($numberOfQuestions)
    {
        try {
            $db = static::getDB();

            $sql = "SELECT * FROM question
                    ORDER BY RAND()
                    LIMIT $numberOfQuestions;";

            $stmt = $db->query($sql);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
