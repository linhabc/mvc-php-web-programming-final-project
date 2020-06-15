<?php

namespace App\Controllers\User;

use App\Controllers\Authentication;
use App\Models\Comment;
use App\Models\Question;
use App\Models\Result;
use App\Models\Test;
use App\Models\User;
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

        View::render('User/DoGroupTest/index.html', []);

    }

    public function doTestAction()
    {
        $uid = (int) $this->getValueFromCookie('uid');

        $testCode = (int) ($this->route_params)["id"];

        $result = Result::getResult($uid, $testCode);

        if ($result) {
            $redirectedURL = "?user/GroupTest/" . $testCode . "/result";
            View::render('/redirect-page.html', [
                'redirectURL' => $redirectedURL,
            ]);
            return;
        }

        $test = Test::getTest($testCode);

        $questions = Question::getQuestionByTestId($testCode);

        $minute = $test->duration;

        $second = '00';

        View::render('User/DoGroupTest/do-test.html', [
            'testCode' => $testCode,
            'uid' => $uid,
            'questions' => $questions,
            'minute' => $minute,
            'second' => $second,
            'test' => $test,
        ]);
    }

    public function resultAction()
    {
        $uid = (int) $this->getValueFromCookie('uid');

        $testCode = (int) ($this->route_params)["id"];

        $result = Result::getResult($uid, $testCode);

        if ($result) {
            // TODO User has done the test -> redirect to result page
            // echo $uid;
            // echo "<br>";
            // echo $testCode;
            // echo "<br>";
            // echo "This user has done this test<br>";
            // echo "<pre>";
            // var_dump($result);
            // echo "--------------<br>";
            // var_dump($allResult);
            // echo "--------------<br>";
            // var_dump($comments);
            // echo "</pre>";

            $allResults = Result::getResultsByTestId($testCode);

            $comments = Comment::findCommentsByTestId($testCode);

            $test = Test::getTest($testCode);

            View::render('User/DoGroupTest/result.html', [
                'test' => $test,
                'result' => $result,
                'allResults' => $allResults,
                'comments' => $comments,
            ]);

        } else {
            $redirectedURL = "?user/GroupTest/index";
            View::render('/redirect-page.html', [
                'redirectURL' => $redirectedURL,
            ]);
        }
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

        // $ids = array();

        // foreach ($answers as $answer) {
        //     $ids[] = (int) ((array) $answer)['0'];
        // }
        $testId = $data->testId;

        $questions = Question::getQuestionByTestId($testId);

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

        $newResult = new Result();
        $newResult->userId = (int) $this->getValueFromCookie('uid');
        $newResult->testId = (int) $this->getValueFromCookie('testId');
        $newResult->score = round(($nCorrectAnswers / count($questions)) * 10, 2);
        $newResult->rating = -1;
        $newResult->create_at = time();
        $newResult->time = $data->timeUsed;

        Result::createResultWithObject($newResult);

        echo json_encode(array(
            "total_questions" => count($answers),
            "correct_answers" => $nCorrectAnswers,
            "finished_at" => $newResult->create_at,
            "answers" => $questions,
            "completion_time" => $newResult->time,
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

    public function commentAction()
    {
        $uid = (int) $this->getValueFromCookie('uid');

        $testId = (int) ($this->route_params)["id"];

        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $comment = $data->comment;

        $createAt = time();
        $newCmtId = Comment::createCommment($testId, $uid, $comment, $createAt);

        $newComment = Comment::getCommentById($newCmtId);
        echo json_encode(array(
            "newComment" => $newComment,
        ));
    }
}
