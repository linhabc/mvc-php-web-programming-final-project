<?php

namespace App\Controllers;

use App\Models\Question;
use App\Models\Topic;
use \Core\View;

class ManageQuestion extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is loged in for example
        // return false;
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
        ]);
    }

    public function addAction()
    {
        $question = $_POST['question_detail'];
        $topic_id = $_POST['topic'];
        $answer_a = $_POST['answer_a'];
        $answer_b = $_POST['answer_b'];
        $answer_c = $_POST['answer_c'];
        $answer_d = $_POST['answer_d'];
        $correct_answer = $_POST['correct_answer'];

        Question::createQuestion($topic_id, -1, $question, $correct_answer, $answer_a, $answer_b, $answer_c, $answer_d);

        $questions = Question::getAllQuestion();
        $topic_name = Topic::getTopicName();

        View::render('Admin/ManageQuestion/index.html', [
            'questions' => $questions,
            'topic_name' => $topic_name,
        ]);
    }
}