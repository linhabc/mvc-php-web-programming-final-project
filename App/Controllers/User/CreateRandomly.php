<?php

namespace App\Controllers\User;

use App\Controllers\Authentication;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\Topic;
use App\Models\User;
use \Core\View;

class CreateRandomly extends \Core\Controller
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
        $topic_name = Topic::getTopicName();

        View::render('User/ManageCustomTest/CreateRandomly/index.html', [
            'topic_name' => $topic_name,
        ]);
    }

    public function addAction()
    {
        $userId = $_COOKIE["uid"];
        $name = $_POST['name_detail'];
        $topic_id = $_POST['topic'];
        $duration = $_POST['duration'];
        $nbquestion = $_POST['nbquestion'];
        $description = $_POST['description'];
        $topic_name = Topic::getTopicName();
        $questions = Question::getAllQuestion();
        $topic_name = Topic::getTopicName();

        $id = Test::createTest($topic_id, $userId, $name, $description, $duration);

        $randoms = Question::getRandomQuestion($nbquestion);

        foreach ($randoms as $random) {
            $questionId = $random["id"];
            TestQuestion::createTestQuestion($id, $questionId);
        }

        $tests = Test::getTestByUserId($userId);

        View::render('User/ManageCustomTest/CreateRandomly/index.html', [
            'tests' => $tests,
            'topic_name' => $topic_name,
        ]);
    }
}
