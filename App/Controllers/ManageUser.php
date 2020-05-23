<?php

namespace App\Controllers;

use \Core\View;
use App\Models\User;


class ManageUser extends \Core\Controller
{

    /**
     * Before filter
     *
     * @return void
     */
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {
        $users = User::getAll();

        View::renderTemplate('Admin/ManageUser/index.html', [
            'users' => $users,
        ]);
    }
}