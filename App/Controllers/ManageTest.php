<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Models\Test;
use App\Models\TestQuestion;
use \Core\View;

class ManageTest extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {
        $tests = Test::getAllTest();

        View::render('Admin/ManageTest/index.html', [
            'tests' => $tests,
        ]);
    }

    public function deleteAction()
    {

        $id = $_GET['id'];

        Test::deleteTest($id);
        TestQuestion::deleteAllTestQuestion($id);
        Comment::deleteAllCommentByTestId($id);

        $tests = Test::getAllTest();

        View::render('Admin/ManageTest/index.html', [
            'tests' => $tests,
        ]);
    }
}