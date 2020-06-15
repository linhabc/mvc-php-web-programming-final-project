<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Test;
use App\Models\TestQuestion;
use \Core\View;

class ManageTest extends \Core\Controller
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