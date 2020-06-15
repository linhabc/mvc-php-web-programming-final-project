<?php

namespace App\Controllers\User;

use App\Controllers\Authentication;

use App\Models\User;
use \Core\View;

class ManagePersonalInfo extends \Core\Controller
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
        $users = User::getUser($userId);

        View::render('User/ManagePersonalInfo/UserInfo/index.html', [
            'users' => $users,
        ]);
    }
}