<?php

namespace App\Controllers\User;

use App\Controllers\Authentication;
use App\Models\Question;
use App\Models\Topic;
use App\Models\User;
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
        if (array_key_exists('uid', $_COOKIE)) {
            $user = User::getUser($_COOKIE['uid']);
            if ($user == null) {
                Authentication::indexAction();
                return false;
            }
        } else {
            Authentication::indexAction();
            return false;
        };
    }

    public function indexAction()
    {

        $topics = Topic::getTopicName();

        View::render('User/DoQuickTest/index.html', [
            'topics' => $topics,
        ]);
    }

    public function doTestAction()
    {
        $nQuestions = (int) $_POST["nQuestions"];
        $topic = (int) $_POST["topic"];

        if ($topic == -1) {
            $questions = Question::getRandomQuestion2($nQuestions);
        } else {
            $questions = Question::getRandomQuestionsByTopicId($topic, $nQuestions);
        }

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
            "completion_time" => $data->timeUsed,
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
