<?php

namespace App\Controllers\User;

use App\Models\Comment;
use \Core\View;

class CommentInfo extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {
        $userId = $_COOKIE["uid"];
        $comments = Comment::getCommentUid($userId);

        View::render('User/ManagePersonalInfo/CommentInfo/index.html', [
            'comments' => $comments,
        ]);
    }

    public function deleteAction()
    {
        $userId = $_COOKIE["uid"];
        $id = $_GET['id'];

        Comment::deleteComment($id);

        $comments = Comment::getCommentUid($userId);

        View::render('User/ManagePersonalInfo/CommentInfo/index.html', [
            'comments' => $comments,
        ]);
    }
}