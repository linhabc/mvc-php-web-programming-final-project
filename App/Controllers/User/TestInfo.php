<?php

namespace App\Controllers\User;

use App\Models\Test;
use \Core\View;

class TestInfo extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {
        $tests = Test::getAllTest();

        View::render('User/ManagePersonalInfo/TestInfo/index.html', [
            'tests' => $tests,
        ]);
    }

    public function deleteAction()
    {

        $id = $_GET['id'];

        Test::deleteTest($id);

        $tests = Test::getAllTest();

        View::render('User/ManagePersonalInfo/TestInfo/index.html', [
            'tests' => $tests,
        ]);
    }
}