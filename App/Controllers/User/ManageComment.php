<?php

namespace App\Controllers\User;

use App\Controllers\Authentication;

use App\Models\User;
use App\Models\Comment;
use \Core\View;

class ManageComment extends \Core\Controller
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
        $id = $_GET['id'];
        $comments = Comment::getCommentByTestCreateByUser($userId, $id);

        View::render('User/ManageCustomTest/ManageComment/index.html', [
            'comments' => $comments,
        ]);
    }

    public function deleteAction()
    {
        $userId = $_COOKIE["uid"];
        $testId = $_GET['testId'];
        $id = $_GET['id'];

        Comment::deleteComment($id);

        $comments = Comment::getCommentByTestCreateByUser($userId, $testId);

        View::render('User/ManageCustomTest/ManageComment/index.html', [
            'comments' => $comments,
        ]);
    }
}