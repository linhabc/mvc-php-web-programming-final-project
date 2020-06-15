<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Question;
use App\Models\Topic;
use \Core\View;

class ManageQuestion extends \Core\Controller
{
    protected function before()
    {
        if(array_key_exists('uid', $_COOKIE)){
            $user = User::getUser($_COOKIE['uid']);
            if($user == NULL){
                Authentication::indexAction();
                return false; 
            }
        } else {
            Authentication::indexAction();
            return false; 
        } ;
    }

    public function indexAction()
    {
        $topic_name = Topic::getTopicName();
        if (array_key_exists('topic-name', $_POST)) {
            $topic_id = $_POST['topic-name'];

            if ($topic_id == "all") {
                $questions = Question::getAllQuestion();

                View::render('Admin/ManageQuestion/index.html', [
                    'questions' => $questions,
                    'topic_name' => $topic_name,
                    'selected_field' => 'all',
                ]);
            } else {
                $question = Question::getQuestionByTopic($topic_id);

                View::render('Admin/ManageQuestion/index.html', [
                    'questions' => $question,
                    'topic_name' => $topic_name,
                    'selected_field' => $topic_id,
                ]);
            }

        } else {
            $questions = Question::getAllQuestion();

            View::render('Admin/ManageQuestion/index.html', [
                'questions' => $questions,
                'topic_name' => $topic_name,
                'selected_field' => 'all',
            ]);
        }
    }

    public function deleteAction()
    {

        $id = $_GET['id'];

        Question::deleteQuestion($id);

        $questions = Question::getAllQuestion();
        $topic_name = Topic::getTopicName();

        View::render('Admin/ManageQuestion/index.html', [
            'questions' => $questions,
            'topic_name' => $topic_name,
            'selected_field' => 'all',
        ]);
    }

    public function addAction()
    {
        $question = htmlentities($_POST['question_detail']);
        $topic_id = $_POST['topic'];
        $user_id = $_COOKIE['uid'];
        $answer_a = htmlentities($_POST['answer_a']);
        $answer_b = htmlentities($_POST['answer_b']);
        $answer_c = htmlentities($_POST['answer_c']);
        $answer_d = htmlentities($_POST['answer_d']);
        $correct_answer = htmlentities($_POST['correct_answer']);

        Question::createQuestion($topic_id, $user_id, $question, $correct_answer, $answer_a, $answer_b, $answer_c, $answer_d);

        $questions = Question::getAllQuestion();
        $topic_name = Topic::getTopicName();

        View::render('Admin/ManageQuestion/index.html', [
            'questions' => $questions,
            'topic_name' => $topic_name,
            'selected_field' => 'all',
        ]);
    }

    public function editAction()
    {

        $id = $_POST['id'];
        $question = htmlentities($_POST['question']);
        $answer_a = htmlentities($_POST['answer_a']);
        $answer_b = htmlentities($_POST['answer_b']);
        $answer_c = htmlentities($_POST['answer_c']);
        $answer_d = htmlentities($_POST['answer_d']);
        $correct_answer = htmlentities($_POST['correct_answer']);

        Question::editQuestion($id, $question, $answer_a, $answer_b, $answer_c, $answer_d, $correct_answer);

        $questions = Question::getAllQuestion();
        $topic_name = Topic::getTopicName();

        View::render('Admin/ManageQuestion/index.html', [
            'questions' => $questions,
            'topic_name' => $topic_name,
            'selected_field' => 'all',
        ]);
    }

}