<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Models\Test;
use App\Models\User;
use \Core\View;

class ManageUser extends \Core\Controller
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
        $users = User::getAll();

        View::render('Admin/ManageUser/index.html', [
            'users' => $users,
        ]);
    }

    public function deleteAction()
    {
        // print_r($_GET);

        $id = $_GET['id'];

        User::deleteUser($id);
        Comment::deleteAllCommentByUserId($id);
        Test::deleteTestByUserId($id);

        $users = User::getAll();

        View::render('Admin/ManageUser/index.html', [
            'users' => $users,
        ]);
    }

    public function addAction()
    {
        $email = htmlentities($_POST['email']);
        $username = htmlentities($_POST['username']);
        $password = htmlentities($_POST['password']);

        User::createAdmin($email, $username, $password);

        $users = User::getAll();

        View::render('Admin/ManageUser/index.html', [
            'users' => $users,
        ]);
    }

    public function editAction()
    {
        $id = $_POST['id'];
        $email = htmlentities($_POST['email']);
        $username = htmlentities($_POST['username']);

        User::editAdmin($id, $email, $username);

        $users = User::getAll();

        View::render('Admin/ManageUser/index.html', [
            'users' => $users,
        ]);
    }
}