<?php

namespace App\Controllers\User;

use App\Controllers\Authentication;

use App\Models\User;
use App\Models\Topic;
use \Core\View;

class TopicInfo extends \Core\Controller
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
        $userId = $_COOKIE["uid"];
        $topics = Topic::getTopicUid($userId);

        View::render('User/ManagePersonalInfo/TopicInfo/index.html', [
            'topics' => $topics,
        ]);
    }
}