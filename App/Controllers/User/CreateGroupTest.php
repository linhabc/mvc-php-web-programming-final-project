<?php

namespace App\Controllers\User;

use App\Models\Test;
use \Core\View;

class CreateGroupTest extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {
        $tests = Test::getAllTest();

        View::render('User/CreateGroupTest/index.html', [
            'tests' => $tests,
        ]);
    }
}