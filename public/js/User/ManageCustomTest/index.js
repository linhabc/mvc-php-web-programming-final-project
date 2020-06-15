function confirmDelete(id) {
    var r = confirm("Are you sure you want to delete?");
    if (r == true) {
        location.href = `?user/ManageCustomTest/delete&id=${id}`;
    }
}

function viewQuestion(id) {
    location.href = `?user/ManageTestQuestion/index&id=${id}`;
}

function viewComment(id) {
    location.href = `?user/ManageComment/index&id=${id}`;
}

function viewUser(id) {
    location.href = `?user/ManageUser/index&id=${id}`;
}

function randomly() {
    location.href = `?user/CreateRandomly/index`;
}

function manually() {
    location.href = `?user/CreateManually/index`;
}