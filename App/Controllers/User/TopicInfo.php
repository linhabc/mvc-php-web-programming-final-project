<?php

namespace App\Controllers\User;

use App\Models\Topic;
use \Core\View;

class TopicInfo extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {
        $userId = $_COOKIE["uid"];
        $topics = Topic::getTopicUid($userId);

        View::render('User/ManagePersonalInfo/TopicInfo/index.html', [
            'topics' => $topics,
        ]);
    }
}