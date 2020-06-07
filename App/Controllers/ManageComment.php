<?php

namespace App\Controllers;

use App\Models\Comment;
use \Core\View;

class ManageComment extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {
        $comments = Comment::getAll();

        View::render('Admin/ManageComment/index.html', [
            'comments' => $comments,
        ]);
    }
}