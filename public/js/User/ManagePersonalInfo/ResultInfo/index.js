function confirmDelete(userId, testId) {
    var r = confirm("Are you sure you want to delete?");
    if (r == true) {
      location.href = `?user/ManageUser/delete&userId=${userId},&testId=${testId}`;
    }
  }

function view(id) {
    location.href = `?user/QuestionInfo/index&id=${id}`;
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