function checkTestCode() {
    var testCode = document.getElementById("testCode").value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // alert("Response: " + this.responseText);
            const result = JSON.parse(this.responseText);
            const existed = result['existed'];
            if (existed) {
                redirectTo(`?user/GroupTest/${testCode}/dotest`);
            } else {
                alert('Test code NOT existed!');
            }
        }
    };
    xhttp.open("POST", "?user/GroupTest/checkCodeExist", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send(JSON.stringify({ 'testCode': testCode }));
}

