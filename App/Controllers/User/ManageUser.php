<?php

namespace App\Controllers\User;

use App\Controllers\Authentication;

use App\Models\User;
use App\Models\Result;
use \Core\View;

class ManageUser extends \Core\Controller
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
        $id = $_GET['id'];
        $users = Result::getResultByTestId($id);

        View::render('User/ManageCustomTest/ManageUser/index.html', [
            'users' => $users,
        ]);
    }

    public function deleteAction()
    {      
        $userId = $_GET['userId'];
        $testId = $_GET['testId'];

        Result::deleteResult($userId);

        $users = Result::getResultByTestId($testId);

        View::render('User/ManageCustomTest/ManageUser/index.html', [
            'users' => $users,
        ]);
    }
}