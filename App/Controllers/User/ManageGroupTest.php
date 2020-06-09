<?php

namespace App\Controllers\User;

use App\Models\Test;
use App\Models\Topic;
use \Core\View;

class ManageGroupTest extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {
        $userId = -1;
        $tests = Test::getTestByUserId($userId);
        $topic_name = Topic::getTopicName();

        View::render('User/ManageGroupTest/index.html', [
            'tests' => $tests,
            'topic_name' => $topic_name,
        ]);
    }

    public function deleteAction()
    {
        $userId = -1;
        $id = $_GET['id'];

        Test::deleteTest($id);

        $tests = Test::getTestByUserId($userId);

        View::render('User/ManageGroupTest/index.html', [
            'tests' => $tests,
            'topic_name' => $topic_name,
        ]);
    }
}