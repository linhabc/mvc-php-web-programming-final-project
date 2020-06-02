<?php

namespace App\Controllers;

use \Core\View;

class Authentication extends \Core\Controller
{

    protected function before()
    {
        //echo "(before) ";
        //return false;
    }

    protected function after()
    {
        //echo " (after)";
    }

    public function indexAction()
    {

        View::render('Authentication/index.html');
    }
}