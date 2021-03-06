<?php

namespace App\Controllers\User;

use App\Controllers\Authentication;
use App\Models\Comment;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\Topic;
use App\Models\User;
use \Core\View;

class ManageCustomTest extends \Core\Controller
{
    protected function before()
    {
        if (array_key_exists('uid', $_COOKIE)) {
            $user = User::getUser($_COOKIE['uid']);
            if ($user == null) {
                Authentication::indexAction();
                return false;
            }
        } else {
            Authentication::indexAction();
            return false;
        };
    }

    public function indexAction()
    {
        $userId = $_COOKIE["uid"];
        $tests = Test::getTestByUserId($userId);
        $topic_name = Topic::getTopicName();

        View::render('User/ManageCustomTest/index.html', [
            'tests' => $tests,
            'topic_name' => $topic_name,
        ]);
    }

    public function deleteAction()
    {
        $userId = $_COOKIE["uid"];
        $id = $_GET['id'];

        Test::deleteTest($id);
        TestQuestion::deleteAllTestQuestion($id);
        Comment::deleteAllCommentByTestId($id);

        $topic_name = Topic::getTopicName();
        $tests = Test::getTestByUserId($userId);

        View::render('User/ManageCustomTest/index.html', [
            'tests' => $tests,
            'topic_name' => $topic_name,
        ]);
    }
}
