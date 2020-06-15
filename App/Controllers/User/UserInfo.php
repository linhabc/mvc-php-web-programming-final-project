<?php

namespace App\Controllers\User;

use App\Controllers\Authentication;

use App\Models\User;
use \Core\View;

class UserInfo extends \Core\Controller
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
        $users = User::getUser($userId);

        View::render('User/ManagePersonalInfo/UserInfo/index.html', [
            'users' => $users,
        ]);
    }

    public function deleteAction()
    {
        // print_r($_GET);

        $id = $_GET['id'];

        User::deleteUser($id);

        $users = User::getAll();

        View::render('User/ManagePersonalInfo/UserInfo/index.html', [
            'users' => $users,
        ]);
    }

    public function addAction()
    {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        User::createAdmin($email, $username, $password);

        $users = User::getAll();

        View::render('User/ManagePersonalInfo/UserInfo/index.html', [
            'users' => $users,
        ]);
    }

    public function editAction()
    {
        $id = $_POST['id'];
        $email = $_POST['email'];
        $username = $_POST['username'];

        User::editAdmin($id, $email, $username);

        $users = User::getAll();

        View::render('User/ManagePersonalInfo/UserInfo/index.html', [
            'users' => $users,
        ]);
    }
}