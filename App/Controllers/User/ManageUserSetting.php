<?php

namespace App\Controllers\User;

use App\Controllers\Authentication;

use App\Models\User;
use \Core\View;

class ManageUserSetting extends \Core\Controller
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
        $uid = (int) $this->getValueFromCookie('uid');
        $users = User::getUser($uid);

        View::render('User/ManageUserSetting/index.html', [
            'users' => $users,
        ]);
    }

    public function editAction()
    {
        $uid = (int) $this->getValueFromCookie('uid');
        $username = htmlentities($_POST['username']);
        $password = htmlentities($_POST['password']);
        if ("" == $password) {
            User::editUserName($uid, $username);
        } else {
            $password = password_hash($password, PASSWORD_BCRYPT);
            User::editUser($uid, $username, $password);
        }

        $users = User::getUser($uid);

        View::render('User/ManageUserSetting/index.html', [
            'users' => $users,
        ]);
    }

    private function getCookie()
    {
        $headerCookies = explode('; ', getallheaders()['Cookie']);
        $cookie = array();
        foreach ($headerCookies as $itm) {
            list($key, $val) = explode('=', $itm, 2);
            $cookie[$key] = $val;
        }
        return $cookie;
    }

    private function getValueFromCookie($name)
    {
        return ($this->getCookie())[$name];
    }
}