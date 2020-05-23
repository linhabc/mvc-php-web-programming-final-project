<?php

namespace App\Controllers;

use \Core\View;
use App\Models\User;
use App\Models\Question;
use App\Models\Topic;
use App\Models\Test;


class Admin extends \Core\Controller
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

        View::renderTemplate('Admin/index.html', [
            'users' => $users,
        ]);
    }
}