let myQuestionsIdSet = new Set()
const checkboxs = document.getElementsByClassName('checkbox')
for (var i = 0; i<checkboxs.length; i++) {
    let checkbox = checkboxs[i];
    checkbox.addEventListener('change', (event) => {
        console.log(checkbox.id);
        if (event.target.checked) {
            myQuestionsIdSet.add(checkbox.id);
        } else {
            myQuestionsIdSet.delete(checkbox.id);
        }
        console.log(myQuestionsIdSet);
        document.getElementById('question').value = Array.from(myQuestionsIdSet).join(' ');
    })
}

function refreshTable() {
    const questionType = document.getElementById("ques-type").value;
    const topicId = document.getElementById("topic-name").value;

    console.log(questionType + " - " + topicId);

    const allRows = document.getElementsByClassName('content-row');
    if (questionType == "all") {
        if (topicId == "all") {
            for (let row of allRows) {
                row.style.visibility='visible';
            }
        } else {
            for (let row of allRows) {
                let classList = row.className.split(' ');
                console.log(classList);
                let rowTopicId = (classList[1].split('-'))[1];
                if (rowTopicId == topicId) {
                    row.style.visibility='visible';
                } else {
                    row.style.visibility='collapse';
                }

            }
        }
    } else { // $questionType == "your"
        let currentUID = getCookie('uid');
        if (topicId == "all") {
            for (let row of allRows) {
                let classList = row.className.split(' ');
                let rowUID = (classList[1].split('-'))[0];
                if (rowUID == currentUID) {
                    row.style.visibility='visible';
                } else {
                    row.style.visibility='collapse';
                }
            }
        } else {
            for (let row of allRows) {
                let classList = row.className.split(' ');
                let rowUID = (classList[1].split('-'))[0];
                let rowTopicId = (classList[1].split('-'))[1];
                if (rowUID == currentUID && rowTopicId == topicId) {
                    row.style.visibility='visible';
                } else {
                    row.style.visibility='collapse';
                }
            }
        }
    }
} 
