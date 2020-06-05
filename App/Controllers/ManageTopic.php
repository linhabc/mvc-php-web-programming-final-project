<?php

namespace App\Controllers;

use App\Models\Topic;
use \Core\View;

class ManageTopic extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {
        $topics = Topic::getAllTopic();

        View::render('Admin/ManageTopic/index.html', [
            'topics' => $topics,
        ]);
    }
}