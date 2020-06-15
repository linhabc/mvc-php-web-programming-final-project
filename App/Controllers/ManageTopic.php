<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Topic;
use \Core\View;

class ManageTopic extends \Core\Controller
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
        $topics = Topic::getAllTopic();

        View::render('Admin/ManageTopic/index.html', [
            'topics' => $topics,
        ]);
    }

    public function deleteAction()
    {

        $id = $_GET['id'];

        Topic::deleteTopic($id);

        $topics = Topic::getAllTopic();

        View::render('Admin/ManageTopic/index.html', [
            'topics' => $topics,
        ]);
    }

    public function addAction()
    {
        $name = htmlentities($_POST['name']);
        $description = htmlentities($_POST['description']);

        Topic::createTopic($name, $description);

        $topics = Topic::getAllTopic();

        View::render('Admin/ManageTopic/index.html', [
            'topics' => $topics,
        ]);
    }

    public function editAction()
    {
        $id = $_POST['id'];
        $name = htmlentities($_POST['name']);
        $description = htmlentities($_POST['description']);

        Topic::editTopic($id, $name, $description);

        $topics = Topic::getAllTopic();

        View::render('Admin/ManageTopic/index.html', [
            'topics' => $topics,
        ]);
    }
}