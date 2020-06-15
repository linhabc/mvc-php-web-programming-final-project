function confirmDelete(id) {
    var r = confirm("Are you sure you want to delete?");
    if (r == true) {
        location.href = `?user/ManageQuestion/delete&id=${id}`;
    }
}

function alertSuccess() {
    alert('Edit success!');
}

function confirmLogout() {
    var r = confirm("Are you sure you want to logout?");
    if (r == true) {
        location.href = "?Authentication/index";
    }
}

var x = document.cookie;
var username = getCookie("username");

document.getElementById("hello-username").innerText = "Hello " + decodeURIComponent(username) + " ";