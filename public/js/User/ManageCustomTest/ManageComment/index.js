function confirmDelete(id, testId) {
    var r = confirm("Are you sure you want to delete?");
    if (r == true) {
        location.href = `?user/ManageComment/delete&id=${id}&testId=${testId}`;
    }
}