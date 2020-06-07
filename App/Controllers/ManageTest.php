<?php

namespace App\Controllers;

use App\Models\Test;
use App\Models\Topic;
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
        $topics = Topic::getTopicName();

        View::render('Admin/ManageTest/index.html', [
            'tests' => $tests,
            'topics' => $topics,
        ]);
    }
}