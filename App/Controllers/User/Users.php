<?php

namespace App\Controllers\User;

use App\Models\Comment;
use App\Models\Question;
use App\Models\Test;
use App\Models\Topic;
use \Core\View;

class Users extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public static function indexAction()
    {
        $questions = Question::getAllQuestion();
        $topics = Topic::getAllTopic();
        $tests = Test::getAllTest();
        $comments = Comment::getAll();

        View::render('User/index.html', [
            'questions' => $questions,
            'topics' => $topics,
            'tests' => $tests,
            'comments' => $comments,
        ]);
    }
}