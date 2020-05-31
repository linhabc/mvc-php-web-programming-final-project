<?php

namespace App\Controllers;

class Users extends \Core\Controller
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
        //echo 'User admin index';
        $users = User::getAll();
        //$users = User::getUser($id);

        View::renderTemplate('User/index.html', [
            'users' => $users,
        ]);
    }
}