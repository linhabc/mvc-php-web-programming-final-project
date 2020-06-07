<?php

namespace App\Controllers;

use App\Models\Question;
use App\Models\Topic;
use App\Models\User;
use \Core\View;

class Admin extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {
        $users = User::getAll();
        $questions = Question::getAllQuestion();
        $topics = Topic::getAllTopic();

        View::render('Admin/index.html', [
            'users' => $users,
            'questions' => $questions,
            'topics' => $topics,
        ]);
    }
}
