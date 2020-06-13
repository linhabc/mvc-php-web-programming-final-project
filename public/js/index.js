function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
}

function redirectTo(url) {
  location.href = `${url}`;
}

function confirmLogout() {
  var r = confirm("Are you sure you want to logout?");
  if (r == true) {
      location.href = "?Authentication/index";
  }
}