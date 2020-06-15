<?php

namespace App\Controllers\User;

use App\Controllers\Authentication;

use App\Models\User;
use App\Models\Comment;
use \Core\View;

class CommentInfo extends \Core\Controller
{
    protected function before()
    {
        if(array_key_exists('uid', $_COOKIE)){
            $user = User::getUser($_COOKIE['uid']);
            if($user == NULL){
                Authentication::indexAction();
                return false; 
            }
        } else {
            Authentication::indexAction();
            return false; 
        } ;
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