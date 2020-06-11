<?php

namespace App\Controllers\User;

use App\Models\Question;
use \Core\View;

class GroupTest extends \Core\Controller
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
        if (array_key_exists('testCode', $_POST)) {
            $testID = $_POST['testCode'];
        } else {
            $testID = -1;
        }

        View::render('User/DoGroupTest/index.html', [
            'testID' => $testID,
        ]);
    }

    public function doTestAction()
    {
        $nQuestions = $_POST["nQuestions"];

        $questions = Question::getRandomQuestion2($nQuestions);

        $min = $_POST["minute"];
        $sec = 0;

        if ($min < 10) {
            $minute = '0' . (string) $min;
        } else {
            $minute = (string) $min;
        }

        if ($sec < 10) {
            $second = '0' . (string) $sec;
        } else {
            $second = (string) $sec;
        }

        View::render('User/DoQuickTest/do-test.html', [
            'questions' => $questions,
            'minute' => $minute,
            'second' => $second,
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

        usort($answers, array($this, 'cmp'));

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
            $questions[$index]->student_anwser = ((array) $answer)['1'];

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

        echo json_encode(array(
            "total_questions" => count($answers),
            "correct_answers" => $nCorrectAnswers,
            "finished_at" => time(),
            "answers" => $questions,
        ));

        // View::render('User/DoQuickTest/result.html', [
        //     // 'data' => ((array) $data->answer),
        //     'data' => ($answers),
        // ]);
        // echo $nCorrectAnswers;
    }

    public function cmp($answer_1, $answer_2)
    {
        $id1 = (int) ((array) $answer_1)['0'];
        $id2 = (int) ((array) $answer_2)['0'];
        if ($id1 == $id2) {
            return 0;
        }
        return ($id1 < $id2) ? -1 : 1;
    }

}