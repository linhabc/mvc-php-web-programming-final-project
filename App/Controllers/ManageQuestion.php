<?php

namespace App\Controllers;

use App\Models\Question;
use App\Models\Topic;
use \Core\View;

class ManageQuestion extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {
        $questions = Question::getAllQuestion();
        $topic_name = Topic::getTopicName();

        View::render('Admin/ManageQuestion/index.html', [
            'questions' => $questions,
            'topic_name' => $topic_name,
        ]);
    }
}