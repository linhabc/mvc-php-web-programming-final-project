<?php

namespace App\Controllers\User;

use App\Models\Question;
use App\Models\Test;
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

        View::render('User/DoGroupTest/index.html', []);

    }

    public function doTestAction()
    {

        $headerCookies = explode('; ', getallheaders()['Cookie']);
        $cookies = array();
        foreach ($headerCookies as $itm) {
            list($key, $val) = explode('=', $itm, 2);
            $cookies[$key] = $val;
        }
        $uid = (int) $cookies['uid'];

        $testCode = (int) ($this->route_params)["id"];

        View::render('User/DoGroupTest/do-test.html', [
            'testCode' => $testCode,
            'uid' => $uid,
            // 'questions' => $questions,
            // 'minute' => $minute,
            // 'second' => $second,
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

    public function checkCodeExistAction()
    {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);

        $testCodeStr = $data->testCode;

        if ($testCodeStr == "") {
            $existed = false;
        } else {
            $testCode = (int) $testCodeStr;

            $test = Test::getTest($testCode);

            if (!isset($test) || empty($test)) {
                $existed = false;
            } else {
                $existed = true;
            }
        }

        echo json_encode(array(
            "existed" => $existed,
        ));

    }

    public function checkResultAction()
    {
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

        echo json_encode(array(
            "total_questions" => count($answers),
            "correct_answers" => $nCorrectAnswers,
            "finished_at" => time(),
            "answers" => $questions,
        ));

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
