<?php

namespace App\Models;

use PDO;

class User extends \Core\Model
{

    public static function getOne($id)
    {
        //$host = 'localhost';
        //$dbname = 'mvc';
        //$username = 'root';
        //$password = 'secret';

        try {
            //$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $db = static::getDB();

            $stmt = $db->query('SELECT id, email, userName, password, role FROM user WHERE id = $id');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // create( -, -, -,)
    // getOne(id)
    // updateOne(id)
    // deleteOne(id)
}