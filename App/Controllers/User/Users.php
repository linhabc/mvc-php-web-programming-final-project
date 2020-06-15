<?php

namespace App\Controllers\User;

use App\Models\Comment;
use App\Models\Question;
use App\Models\Test;
use App\Models\Topic;
use App\Models\Result;
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
        $uid = $_COOKIE["uid"];

        // Phụng update result để lấy nốt questions và topics
        $questions = Result::getResultQuestion($uid);
        $topics = Result::getResultTopic($uid);
        
        $tests = Result::getResultUid($uid);
        $comments = Comment::getCommentUid($uid);

        View::render('User/index.html', [
            'questions' => $questions,
            'topics' => $topics,
            'tests' => $tests,
            'comments' => $comments,
        ]);
    }
}