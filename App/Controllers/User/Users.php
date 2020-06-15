<?php

namespace App\Controllers\User;

use App\Controllers\Authentication;

use App\Models\User;
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
        $uid = $_COOKIE["uid"];

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