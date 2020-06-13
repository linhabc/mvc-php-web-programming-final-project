<?php

namespace App\Controllers\User;

use App\Models\Result;
use \Core\View;

class ManageUser extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
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