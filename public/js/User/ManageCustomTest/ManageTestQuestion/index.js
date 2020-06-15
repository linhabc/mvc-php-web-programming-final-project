function confirmDelete(test_id, question_id) {
    var r = confirm("Are you sure you want to delete?");
    if (r == true) {
        location.href = `?user/ManageTestQuestion/delete&test_id=${test_id}&question_id=${question_id}`;
    }
}