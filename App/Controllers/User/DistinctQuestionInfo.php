<?php

namespace App\Controllers\User;

use App\Models\Test;
use App\Models\Topic;
use App\Models\Question;
use App\Models\TestQuestion;
use \Core\View;

class DistinctQuestionInfo extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
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