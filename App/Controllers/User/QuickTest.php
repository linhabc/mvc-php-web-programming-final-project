<?php

namespace App\Controllers\User;

use App\Models\Question;
use \Core\View;

class QuickTest extends \Core\Controller
{

    /**
     * Before filter
     *
     * @return void
     */
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {

        $questions = Question::getRandomQuestion(10);

        View::render('User/DoQuickTest/index.html', [
            'questions' => $questions,
        ]);
    }

    public function resultAction()
    {
        // $questions = Question::getRandomQuestion(10);

        View::render('User/DoQuickTest/result.html', [
            // 'questions' => $questions,
        ]);
    }

    public function checkResultAction()
    {
        echo ("-----");
        echo ($_POST);
        echo ("-----");
    }

}
