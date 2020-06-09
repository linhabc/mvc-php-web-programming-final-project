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

// console.log('questions: -----------------');
// var div = document.getElementById("dom-target");
// var myData = div.textContent;
// console.log("_" + myData + "_");
// console.log('questions: -----------------');

function UserAction() {
    console.log(myAnswers);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            alert("Correct answer(s): " + this.responseText);
            showResult(this.responseText);
            // document.getElementById('result').innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "?user/QuickTest/checkResult&id=123", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send(JSON.stringify({ 'answer': [...myAnswers] }));
}

document.getElementById("btnSubmit").addEventListener('click', UserAction);

function showResult(resultResponse) {
    const result = JSON.parse(resultResponse)
    const total_questions = result['total_questions'];
    const correct_answers = result['correct_answers'];
    const finishedAt = result['finished_at'];
    const answers = result['answers'];

    // alert(total_questions + "-" + correct_answers + "-" + answers.length);

    document.getElementById('result').innerHTML =
        "<span> Scores: " + correct_answers/total_questions + "</span><br><span> Correct: "+ correct_answers+ " / " + total_questions + " </span><br><span>Finished at: "+ getDateFromTimestamp(finishedAt) +"</span><br><a href='#'>BACK</a>";

    window.scrollTo(0, 0); 

    console.log(answers);
    showAnswers(answers);
    disableAllRadioButton()
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