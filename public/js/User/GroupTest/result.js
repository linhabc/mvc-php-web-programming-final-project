
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