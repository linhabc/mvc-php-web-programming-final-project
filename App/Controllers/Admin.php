<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Question;
use App\Models\Test;
use App\Models\Topic;
use \Core\View;

class Admin extends \Core\Controller
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

    public static function indexAction()
    {
        $users = User::getAll();
        $questions = Question::getAllQuestion();
        $topics = Topic::getAllTopic();
        $tests = Test::getAllTest();
        $comments = Comment::getAll();

        View::render('Admin/index.html', [
            'users' => $users,
            'questions' => $questions,
            'topics' => $topics,
            'tests' => $tests,
            'comments' => $comments,
        ]);
    }
}