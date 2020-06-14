
const rows = document.getElementById('table-id').getElementsByTagName('tr');
const nRows = rows.length - 1;

let currentPage = 1;
let maxRowsPerPage = 2;
let maxPage = 0;

setUpPagination(2)

function setUpPagination(maxRowsEachPage) {
    maxRowsPerPage = maxRowsEachPage;
    console.log('nRows: ' + nRows);
    console.log('maxRowsPerPage: ' + maxRowsPerPage);
    if (nRows <= maxRowsPerPage) {
        document.getElementById('pagination-container').style.visibility = "hidden";
        for(var i=0; i<rows.length; i++) {
            rows.item(i).style.visibility = 'visible';
        } 
        return;
    }

    document.getElementById('pagination-container').style.visibility = "visible";

    maxPage = Math.ceil(nRows / maxRowsPerPage);
    console.log(maxPage);

    var pageIndices = [...Array(maxPage).keys()].map(x => ++x);

    var ul = document.getElementById("pagination");
    var next = ul.children[ul.children.length-1];

    for(var i = 0; i < pageIndices.length; i++) {
        var li = document.createElement("li");
        li.setAttribute("id",'pi-' + (i+1));
        const pageIndex = document.createTextNode(pageIndices[i]);
        li.appendChild(pageIndex);
        li.addEventListener('click', function() {
            // console.log(this.firstChild.textContent);
            currentPage = this.firstChild.textContent;
            console.log(currentPage);
            showRows();
        })
        ul.insertBefore(li, next);
    }

    rows.item(0).style.visibility = 'visible';
    showRows();
}

function showRows() {
    hidePreRows();
    hideNextRows();
    showCurrentRows();
}

function hidePreRows() {
    const startIndex = (currentPage-2)*maxRowsPerPage + 1;
    if (startIndex <= 0) {
        return;
    }
    const lastIndex = startIndex + maxRowsPerPage - 1;
    console.log('hide pre from ' + startIndex + ' to ' +lastIndex);
    for(var i=startIndex; i<=lastIndex; i++) {
        rows.item(i).style.visibility = 'collapse';
    } 
}

function hideNextRows() {
    const startIndex = (currentPage)*maxRowsPerPage + 1;
    if (startIndex > nRows) {
        return;
    }
    let lastIndex = startIndex + maxRowsPerPage - 1;
    if (lastIndex > nRows) {
        lastIndex = nRows;
    }
    console.log('hide next from ' + startIndex + ' to ' +lastIndex);
    for(var i=startIndex; i<=lastIndex; i++) {
        rows.item(i).style.visibility = 'collapse';
    } 
}

function showCurrentRows() {
    const startIndex = (currentPage-1)*maxRowsPerPage + 1;
    let lastIndex = startIndex + maxRowsPerPage - 1;
    if (lastIndex > nRows) {
        lastIndex = nRows;
    }
    console.log('show from ' + startIndex + ' to ' +lastIndex);
    for(var i=startIndex; i<=lastIndex; i++) {
        console.log(rows.item(i));
        rows.item(i).style.visibility = 'visible';
    } 
}

function sendComment() {
    const pieces = window.location.href.split("/");
    const testId = pieces[pieces.length-2];
    // alert(testId);
    var comment = document.getElementById("input-cmt").value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            alert("Response: " + this.responseText);
            clearInputComment();
            const result = JSON.parse(this.responseText);
            showNewComment(result['newComment']);
        }
    };
    xhttp.open("POST", "?user/GroupTest/" + testId +"/comment", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send(JSON.stringify({ 'comment': comment }));
}

function clearInputComment() {
    document.getElementById("input-cmt").value = '';
}

function showNewComment(newComment) {
    let newDiv = document.createElement("div");
    newDiv.classList.add("user-comment-container");

    newDiv.innerHTML = "<div class='comment-user-detail'>" +
                            "<div class='userName'>" +
                                "<label>" + newComment['userName'] + "</label><br>" +
                            "</div>" +
                        "</div>" +
                        "<div class='comment-detail-container'>" +
                            "<div class='date'>" +
                                "<label> [" + newComment['create_at'] + "]</label><br>" +
                            "</div>" +
                            "<hr>" +
                            "<label>" + newComment['content'] + "</label><br>" +
                        "</div>" ;

    const container = document.getElementById('comment-area');
    container.insertBefore(newDiv, container.firstChild);
}
