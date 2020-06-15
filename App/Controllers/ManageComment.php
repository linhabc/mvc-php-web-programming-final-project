<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Models\User;
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
        $comments = Comment::getAll();

        View::render('Admin/ManageComment/index.html', [
            'comments' => $comments,
        ]);
    }

    public function deleteAction()
    {

        $id = $_GET['id'];

        Comment::deleteComment($id);

        $comments = Comment::getAll();

        View::render('Admin/ManageComment/index.html', [
            'comments' => $comments,
        ]);
    }
}