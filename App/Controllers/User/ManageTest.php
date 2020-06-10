<?php

namespace App\Controllers\User;

use App\Models\Test;
use App\Models\Topic;
use \Core\View;

class ManageTest extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    { 
        $userId = $_COOKIE["uid"];
        $tests = Test::getTestByUserId($userId);
        $topic_name = Topic::getTopicName();

        View::render('User/ManageCustomTest/ManageTest/index.html', [
            'tests' => $tests,
            'topic_name' => $topic_name,
        ]);
    }

    public function deleteAction()
    {
        $userId = $_COOKIE["uid"];
        $id = $_GET['id'];

        Test::deleteTest($id);

        $tests = Test::getTestByUserId($userId);

        View::render('User/ManageCustomTest/ManageTest/index.html', [
            'tests' => $tests,
            'topic_name' => $topic_name,
        ]);
    }

    public function addAction()
    {
        $userId = $_COOKIE["uid"];
        $name = $_POST['name_detail'];
        $topic_id = $_POST['topic'];
        $duration = $_POST['duration'];
        $description = $_POST['description'];

        Test::createTest($topic_id, $userId, $name, $description, $duration);

        $topic_name = Topic::getTopicName();
        $tests = Test::getTestByUserId($userId);

        View::render('User/ManageCustomTest/ManageTest/index.html', [
            'tests' => $tests,
            'topic_name' => $topic_name,
        ]);
    }
}