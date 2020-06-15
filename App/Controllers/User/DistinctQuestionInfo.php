<?php

namespace App\Controllers\User;

use App\Controllers\Authentication;

use App\Models\User;
use App\Models\Test;
use App\Models\Topic;
use App\Models\Question;
use App\Models\TestQuestion;
use \Core\View;

class DistinctQuestionInfo extends \Core\Controller
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
        $userId = $_COOKIE["uid"];
        $tests = Question::getQuestionByUId($userId);

        View::render('User/ManagePersonalInfo/DistinctQuestionInfo/index.html', [
            'tests' => $tests,
        ]);
    }
}