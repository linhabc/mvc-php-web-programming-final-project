<?php

namespace App\Models;

use PDO;

class Comment extends \Core\Model
{
    public $id;
    public $testId;
    public $userId;
    public $content;
    public $create_at;

    // public function __construct($id, $testId, $userId, $content, $create_at)
    // {
    //     $this->id = $id;
    //     $this->testId = $testId;
    //     $this->userId = $userId;
    //     $this->content = $content;
    //     $this->create_at = $create_at;
    // }

    public static function getCommentById($id)
    {
        try {
            $db = static::getDB();

            // $stmt = $db->query("SELECT * FROM comment WHERE id = $id LIMIT 1");
            $stmt = $db->query("SELECT c.*, u.role as userRole, u.userName FROM comment as c, user as u
                                WHERE c.user_id = u.id
                                AND c.id = $id
                                ORDER BY c.create_at ASC
                                LIMIT 1");
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\Models\Comment');
            $result = $stmt->fetch();

            return $result;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function findCommentsByTestId($testId)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT c.*, u.role as userRole, u.userName FROM comment as c, user as u
                            WHERE c.user_id = u.id
                            AND c.test_id = $testId
                            ORDER BY c.create_at ASC
                            ");
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\Models\Comment');
            $results = $stmt->fetchAll();

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function createCommment($testId, $userId, $content, $create_at)
    {
        try {
            $db = static::getDB();

            $sql = "INSERT INTO comment (test_id, user_id, content, create_at) VALUES ('$testId', '$userId', '$content', FROM_UNIXTIME($create_at))";

            $db->exec($sql);

            $last_id = $db->lastInsertId();

            return $last_id;
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
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteComment($id)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM comment WHERE id = $id";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteAllCommentByTestId($id)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM comment WHERE test_id = $id";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteAllCommentByUserId($id)
    {

        try {
            $db = static::getDB();

            $sql = "DELETE FROM comment WHERE user_id = $id";
            $db->exec($sql);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getAll()
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT comment.id, user.username as u_name,test.name as t_name, comment.content, comment.create_at  FROM comment INNER JOIN user on comment.user_id = user.id INNER JOIN test on comment.test_id = test.id");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getCommentByTestCreateByUser($userId)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT comment.id, user.username as u_name,test.name as t_name, comment.content, comment.create_at  FROM comment INNER JOIN user on comment.user_id = user.id INNER JOIN test on comment.test_id = test.id WHERE test.user_id = $userId");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getCommentUid($userId)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("SELECT comment.id, user.username as u_name,test.name as t_name, comment.content, comment.create_at  FROM comment INNER JOIN user on comment.user_id = user.id INNER JOIN test on comment.test_id = test.id WHERE comment.user_id = $userId");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
