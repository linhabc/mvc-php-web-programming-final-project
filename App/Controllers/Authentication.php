<?php

namespace App\Controllers;

use App\Models\User;
use App\Controllers\User\Users;

use \Core\View;

class Authentication extends \Core\Controller
{

    protected function before()
    {

    }

    protected function after()
    {
        
    }

    public function indexAction()
    {

        View::render('Authentication/index.html');
    }

    public function signUpAction()
    {
        if(array_key_exists('email', $_POST) && array_key_exists('password', $_POST) && array_key_exists('userName', $_POST)){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userName = $_POST['userName'];

            $user = User::createUser($email, $userName, $password);

            Users::indexAction();

        } else {
            Authentication::indexAction();
        }
    }

    public function loginAction()
    {
        if(array_key_exists('email', $_POST) && array_key_exists('password', $_POST)){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = User::login($email, $password);

            if($user != NULL){
                if($user[0]['role'] == 'Admin'){
                    Admin::indexAction();
                } else if($user[0]['role'] == 'User'){
                    Users::indexAction();
                }
            } else {
                Authentication::indexAction();
            }
        } else {
            Authentication::indexAction();
        }
    }
}