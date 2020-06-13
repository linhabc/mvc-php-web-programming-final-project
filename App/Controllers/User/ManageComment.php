<?php

namespace App\Controllers\User;

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
        $userId = $_COOKIE["uid"];
        $comments = Comment::getCommentByTestCreateByUser($userId);

        View::render('User/ManageCustomTest/ManageComment/index.html', [
            'comments' => $comments,
        ]);
    }

    public function deleteAction()
    {
        $userId = $_COOKIE["uid"];
        $id = $_GET['id'];

        Comment::deleteComment($id);

        $comments = Comment::getCommentByTestCreateByUser($userId);

        View::render('User/ManageCustomTest/ManageComment/index.html', [
            'comments' => $comments,
        ]);
    }
}