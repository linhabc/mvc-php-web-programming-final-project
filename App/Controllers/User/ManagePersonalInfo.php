<?php

namespace App\Controllers\User;

use App\Models\User;
use \Core\View;

class ManagePersonalInfo extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
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