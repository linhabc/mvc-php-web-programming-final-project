function confirmDelete(id) {
    var r = confirm("Are you sure you want to delete?");
    if (r == true) {
        location.href = `?user/QuestionInfo/delete&id=${id}`;
    }
}

function confirmLogout() {
    var r = confirm("Are you sure you want to logout?");
    if (r == true) {
        location.href = "?Authentication/index";
    }
}

function alertSuccess() {
    alert('Edit success!');
}


var x = document.cookie;
var username = getCookie("username");

document.getElementById("hello-username").innerText = "Hello " + decodeURIComponent(username) + " ";