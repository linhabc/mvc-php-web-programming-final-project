<?php

namespace App\Controllers\User;

use App\Models\Question;
use \Core\View;

class QuickTest extends \Core\Controller
{

    /**
     * Before filter
     *
     * @return void
     */
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {

        $questions = Question::getRandomQuestion(10);

        View::render('User/DoQuickTest/index.html', [
            'questions' => $questions,
        ]);
    }

    public function doTestAction()
    {
        $nQuestions = 10;

        $questions = Question::getRandomQuestion2($nQuestions);

        View::render('User/DoQuickTest/do-test.html', [
            'questions' => $questions,
        ]);
    }

    public function resultAction()
    {
        $ids = array(1, 2);
        $questions = Question::getQuestionsByIds($ids);

        View::render('User/DoQuickTest/result.html', [
            'questions' => $questions,
        ]);
    }

    public function checkResultAction()
    {
        // echo ("-----");
        // $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        // echo ("-----");
        // echo ($actual_link);
        // echo ("AHEHEHE");

        // try {
        //     echo $_POST;
        // } catch (Exception $e) {
        //     $log = 'Caught exception: ' . $e->getMessage() . "\n";
        //     file_put_contents('/logs/' . date("j.n.Y") . '.txt', $log, FILE_APPEND);
        //     echo 'Caught exception: ' . $e->getMessage() . "\n";
        // }

        // $id = $_GET['id'];
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);

        $answers = (array) $data->answer;
        $ids = array();

        foreach ($answers as $answer) {
            $ids[] = (int) ((array) $answer)['0'];
        }

        $questions = Question::getQuestionsByIds($ids);

        $nCorrectAnswers = 0;
        $nInCorrectAnswers = 0;

        $nIsNotSet = 0;

        foreach ($answers as $index => $answer) {
            // if (isset(((array) $answer)['1']) && (strcasecmp($questions[$index]->answer, ((array) $answer)['1']) == 0)) {
            //     $nCorrectAnswers++;
            // } else {
            //     $nInCorrectAnswers--;
            // }
            if (!isset(((array) $answer)['1'])) {
                $nIsNotSet++;
                $nInCorrectAnswers--;
            } elseif (strcasecmp($questions[$index]->answer, ((array) $answer)['1']) == 0) {
                $nCorrectAnswers++;
            } else {
                $nInCorrectAnswers--;
            }
        }

        // echo json_encode($data);

        // echo json_encode($data["answer"] . size());

        // View::render('User/DoQuickTest/result.html', [
        //     // 'data' => ((array) $data->answer),
        //     'data' => ($nCorrectAnswers),
        // ]);
        echo $nCorrectAnswers;
    }

}
