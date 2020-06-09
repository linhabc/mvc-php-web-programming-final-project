<?php

namespace App\Controllers;

use App\Models\Topic;
use \Core\View;

class ManageTopic extends \Core\Controller
{
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
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
        $name = $_POST['name'];
        $description = $_POST['description'];

        Topic::createTopic($name, $description);

        $topics = Topic::getAllTopic();

        View::render('Admin/ManageTopic/index.html', [
            'topics' => $topics,
        ]);
    }

    public function editAction()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];

        Topic::editTopic($id, $name, $description);

        $topics = Topic::getAllTopic();

        View::render('Admin/ManageTopic/index.html', [
            'topics' => $topics,
        ]);
    }
}