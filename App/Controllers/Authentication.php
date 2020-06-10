<?php

namespace App\Controllers;

use App\Controllers\User\Users;
use App\Models\Comment;
use App\Models\Question;
use App\Models\Test;
use App\Models\Topic;
use App\Models\User;
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
        if (array_key_exists('email', $_POST) && array_key_exists('password', $_POST) && array_key_exists('userName', $_POST)) {
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
        if (array_key_exists('email', $_POST) && array_key_exists('password', $_POST)) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = User::login($email, $password);

            if ($user != null) {
                if ($user[0]['role'] == 'Admin') {
                    self::openAdminHomePage($user[0]);
                } else if ($user[0]['role'] == 'User') {
                    self::openUserHomePage($user[0]);
                }
            } else {
                Authentication::indexAction();
            }
        } else {
            Authentication::indexAction();
        }
    }

    public function openAdminHomePage($admin)
    {
        $users = User::getAll();
        $questions = Question::getAllQuestion();
        $topics = Topic::getAllTopic();
        $tests = Test::getAllTest();
        $comments = Comment::getAll();
        $user = array();
        $user["id"] = $admin["id"];
        $user["email"] = $admin["email"];
        $user["username"] = $admin["username"];
        $user["role"] = $admin["role"];

        View::render('Admin/index.html', [
            'users' => $users,
            'questions' => $questions,
            'topics' => $topics,
            'tests' => $tests,
            'comments' => $comments,
            'user' => $user,
        ]);
    }

    public function openUserHomePage($mUser)
    {
        $questions = Question::getAllQuestion();
        $topics = Topic::getAllTopic();
        $tests = Test::getAllTest();
        $comments = Comment::getAll();
        $user = array();
        $user["id"] = $mUser["id"];
        $user["email"] = $mUser["email"];
        $user["username"] = $mUser["username"];
        $user["role"] = $mUser["role"];

        View::render('User/index.html', [
            'questions' => $questions,
            'topics' => $topics,
            'tests' => $tests,
            'comments' => $comments,
            'user' => $user,
        ]);
    }
}
