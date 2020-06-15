function test() {
    alert("test test test")
}

let myAnswers = new Map();

var container, inputs, index;

container = document.getElementById('questions-area');

inputs = container.getElementsByTagName('input');
for (index = 0; index < inputs.length; ++index) {
    // var radioBtn = inputs[index]
    // console.log(inputs[index].value)
    // console.log(radioBtn.value)
    myAnswers.set(inputs[index].name, null)

    inputs[index].addEventListener('click', function () {
        // console.log(this)
        console.log(this.name + " - " + this.value)

        myAnswers.set(this.name, this.value)

        console.log(myAnswers)

        const questionNo = this.id;
        console.log("tick-" + questionNo);
        document.getElementById('tick-' + questionNo).innerText = "✓";
    })

}

console.log(myAnswers);

var questionShortcutContainer = document.getElementById('question-shorcut');
shorcuts = questionShortcutContainer.getElementsByClassName('question-link');
for (index = 0; index < shorcuts.length; ++index) {

    shorcuts[index].addEventListener('click', function () {
        var _href = this.getAttribute('href');
        var questionNo = _href.substr(1);
        console.log(questionNo);
        document.getElementById(questionNo).scrollIntoView(true);
    })

}

function manualSubmit() {
    var conf = confirm("Are you sure to turn in?");
    if (conf == true) {
        clearInterval(cdID);
        submit();
    }
}

function submit() {
    var timeUsed = (init_min * 60 + init_sec) - ((min >= 0 ? min : 0) * 60 + (sec >= 0 ? sec : 0))

    console.log('timeUsed in seconds: ' + timeUsed);

    console.log(myAnswers);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // alert("Correct answer(s): " + this.responseText);
            showResult(this.responseText);
            // document.getElementById('result').innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "?user/QuickTest/checkResult&id=123", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send(JSON.stringify({
        'answer': [...myAnswers],
        'timeUsed': timeUsed
    }));
}

document.getElementById("btnSubmit").addEventListener('click', manualSubmit);

var duration = document.getElementById('timer').textContent;
console.log(duration);
var time = duration.split(' : ');
console.log(time);
var min = time[0] - 0;
var sec = time[1] - 0;
var init_min = min;
var init_sec = sec;
console.log(min + " - " + sec);
countdown();

function showResult(resultResponse) {
    const result = JSON.parse(resultResponse)
    const total_questions = result['total_questions'];
    const correct_answers = result['correct_answers'];
    const finishedAt = result['finished_at'];
    const answers = result['answers'];
    const completionTime = result['completion_time'];
    const score = Math.round(((correct_answers / total_questions * 10) + Number.EPSILON) * 100) / 100;
    // alert(total_questions + "-" + correct_answers + "-" + answers.length);

    document.getElementById('result').innerHTML =
        "<span> Score: " + score + " / 10</span><br>" +
        "<span> Correct: " + correct_answers + " / " + total_questions + " </span><br>" +
        "<span>Finished at: " + getDateFromTimestamp(finishedAt) + "</span><br>" +
        "<span>Completion time: " + convertSecondsToMinutes(completionTime) + "</span><br>" +
        "<button id='back-btn' class='back_btn' onclick='backToQuickTestIndex()'>BACK</button>";

    // document.getElementById('back-btn').className = 'back_btn';

    window.scrollTo(0, 0);

    console.log(answers);
    showAnswers(answers);
    hideSubmitButton();
    disableAllRadioButton();

}

function getDateFromTimestamp(timestamp) {
    var date = new Date(timestamp * 1000);
    return date.toString();
}

function showAnswers(answers) {
    for (i = 0; i < answers.length; i++) {
        const answer = answers[i];
        const id = answer['id'] + '-' + answer['answer'];
        console.log(id);
        var correct_anwser = document.getElementById(id)
        console.log(correct_anwser);
        correct_anwser.style.backgroundColor = "#2196F3";
    }
}

function disableAllRadioButton() {
    var x = document.getElementsByClassName("radio-btn");
    var i;
    for (i = 0; i < x.length; i++) {
        x[i].disabled = true;
    }
}

function hideSubmitButton() {
    document.getElementById("btnSubmit").style.visibility = 'collapse';
}

function countdown() {
    cdID = setInterval(function () {
        if (sec == 0) {
            min--;
            sec = 60;
        }
        sec--;
        if (min < 10) {
            min_text = '0' + min;
        } else {
            min_text = min;
        }
        if (sec < 10)
            sec_text = '0' + sec;
        else
            sec_text = sec;

        if (min < 0) {
            clearInterval(cdID);
            alert('Time out! The answers will be turned in automatically!');
            submit();
        }

        document.getElementById('timer').innerHTML = min_text + ' : ' + sec_text;

    }, 1000);
}

function convertSecondsToMinutes(nSeconds) {
    const minutes = Math.floor(nSeconds / 60)
    const remainder = nSeconds - (minutes * 60);

    if (minutes < 10) {
        minute = '0' + minutes;
    } else {
        minute = minutes;
    }

    if (remainder < 10) {
        second = '0' + remainder;
    } else {
        second = remainder;
    }

    return minute + " : " + second
}

function backToQuickTestIndex() {
    redirectTo('?user/QuickTest/index');
}