<?php

namespace App\Controllers\User;

use App\Models\Question;
use App\Models\Test;
use App\Models\Topic;
use App\Models\User;
use \Core\View;

class CreateManually extends \Core\Controller
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
        $user_id = $_COOKIE['uid'];
        $question_type = array("All questions", "Your questions");
        $topic_name = Topic::getTopicName();
        if (array_key_exists('topic-name', $_POST) && array_key_exists('ques-type', $_POST)) {
            $topic_id = $_POST['topic-name'];
            $ques = $_POST['ques-type'];

            if ($topic_id == "all") {
                if ($ques == "all") {
                    $questions = Question::getAllQuestion();

                    View::render('User/ManageCustomTest/CreateManually/index.html', [
                        'questions' => $questions,
                        'topic_name' => $topic_name,
                        'selected_field' => 'all',
                        'selected_ques' => 'all',
                    ]);
                } else {
                    $questions = Question::getQuestionMadeByUID($user_id);

                    View::render('User/ManageCustomTest/CreateManually/index.html', [
                        'questions' => $questions,
                        'topic_name' => $topic_name,
                        'selected_field' => 'all',
                        'selected_ques' => 'your',
                    ]);
                }

            } else {
                if ($ques == "all") {
                    $question = Question::getQuestionByTopic($topic_id);

                    View::render('User/ManageCustomTest/CreateManually/index.html', [
                        'questions' => $question,
                        'topic_name' => $topic_name,
                        'selected_field' => $topic_id,
                        'selected_ques' => 'all',
                    ]);
                } else {
                    $question = Question::getQuestionByTopicUid($topic_id, $user_id);

                    View::render('User/ManageCustomTest/CreateManually/index.html', [
                        'questions' => $question,
                        'topic_name' => $topic_name,
                        'selected_field' => $topic_id,
                        'selected_ques' => 'your',
                    ]);
                }
            }

        } else {
            $questions = Question::getAllQuestion();

            View::render('User/ManageCustomTest/CreateManually/index.html', [
                'questions' => $questions,
                'topic_name' => $topic_name,
                'selected_field' => 'all',
                'selected_ques' => 'all',
            ]);
        }
    }

    public function addAction()
    {
        // $question = htmlentities($_POST['question_detail']);
        // $topic_id = $_POST['topic'];
        // $user_id = $_COOKIE['uid'];
        // $answer_a = htmlentities($_POST['answer_a']);
        // $answer_b = htmlentities($_POST['answer_b']);
        // $answer_c = htmlentities($_POST['answer_c']);
        // $answer_d = htmlentities($_POST['answer_d']);
        // $correct_answer = htmlentities($_POST['correct_answer']);

        // Question::createQuestion($topic_id, $user_id, $question, $correct_answer, $answer_a, $answer_b, $answer_c, $answer_d);

        // $questions = Question::getAllQuestion();
        // $topic_name = Topic::getTopicName();

        // View::render('User/ManageCustomTest/CreateManually/index.html', [
        //     'questions' => $questions,
        //     'topic_name' => $topic_name,
        //     'selected_field' => 'all',
        // ]);

        $userId = $_COOKIE["uid"];
        $name = $_POST['name_detail'];
        $topic_id = $_POST['topic'];
        $duration = $_POST['duration'];
        $description = $_POST['description'];
        $ids = $_POST['question'];

        $id = Test::createTest($topic_id, $userId, $name, $description, $duration);

        // $ids = $_GET['ids'];

        // $id = $test;

        // $randoms = Question::getRandomQuestion($nbquestion);

        foreach ($ids as $questionId) {
            // $questionId = $random["id"];
            TestQuestion::createTestQuestion($id, $questionId);
        }

        $questions = Question::getAllQuestion();
        $topic_name = Topic::getTopicName();

        View::render('User/ManageCustomTest/CreateManually/index.html', [
            'questions' => $questions,
            'topic_name' => $topic_name,
            'selected_field' => 'all',
            'selected_ques' => 'all',
        ]);
    }
}
