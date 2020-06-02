<?php

namespace App\Controllers;

use \Core\View;
use App\Models\User;


class ManageUser extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {
        $users = User::getAll();

        View::render('Admin/ManageUser/index.html', [
            'users' => $users,
        ]);
    }
}