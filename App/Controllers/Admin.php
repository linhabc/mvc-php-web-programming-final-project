<?php

namespace App\Controllers;

use \Core\View;

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
        View::renderTemplate('Admin/index.html');
    }
}