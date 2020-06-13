<?php

namespace App\Controllers\User;

use App\Models\Test;
use App\Models\Topic;
use App\Models\Question;
use App\Models\TestQuestion;
use \Core\View;

class QuestionInfo extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    { 
        // $userId = $_COOKIE["uid"];
        $id = $_GET['id'];
        $topic_name = Topic::getTopicName();
        $tests = TestQuestion::getQuestionById($id);

        View::render('User/ManagePersonalInfo/QuestionInfo/index.html', [
            'tests' => $tests,
            'topic_name' => $topic_name,
        ]);
    }

    public function deleteAction()
    {
        // $userId = $_COOKIE["uid"];
        $test_id = $_GET['test_id'];
        $question_id = $_GET['question_id'];

        TestQuestion::deleteTestQuestion($test_id, $question_id);

        $topic_name = Topic::getTopicName();
        $tests = TestQuestion::getQuestionById($test_id);

        View::render('User/ManageCustomTest/ManageTestQuestion/index.html', [
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
        $nbquestion = $_POST['nbquestion'];
        $description = $_POST['description'];

        $id = Test::createTest($topic_id, $userId, $name, $description, $duration);
        
        // $id = $test;

        $randoms = Question::getRandomQuestion($nbquestion);

        foreach ($randoms as $random) {
            $questionId = $random["id"];
            TestQuestion::createTestQuestion($id, $questionId);
        }

        $topic_name = Topic::getTopicName();
        $tests = Test::getTestByUserId($userId);

        View::render('User/ManageCustomTest/ManageTestQuestion/index.html', [
            'tests' => $tests,
            'topic_name' => $topic_name,
        ]);
    }
}