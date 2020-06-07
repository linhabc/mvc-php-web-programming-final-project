function handleSideBarButton(event) {
  var navLink, i;
  navLink = document.getElementsByClassName("navLink");

  for (i = 0; i < navLink.length; i++) {
    navLink[i].className = navLink[i].className.replace(" active", "");
  }

  event.currentTarget.className += " active";
  return true;
}
