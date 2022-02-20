/** add active class and stay opened when selected */
var url = window.location;

// for sidebar menu entirely but not cover treeview
$('ul.nav-sidebar a').filter(function() {
    return this.href == url;
}).addClass('active');

// for treeview
$('ul.nav-treeview a').filter(function() {
    return this.href == url;
}).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');

// set cookie on sidebar click
function sideBarAction()
{
  var bodyClass = document.body.className;

  if (bodyClass === "sidebar-mini"){

    setCookie('sidebarMenu','close');
  }else{

    setCookie('sidebarMenu','open');
  }  
}

// check sidebarmenu cookie
if (getCookie('sidebarMenu')){

  if (getCookie('sidebarMenu') === 'open'){

    $('body').addClass('sidebar-mini');
  }else{

    $('body').addClass('sidebar-mini sidebar-collapse');
  }
}

// set cookie function
function setCookie(name, value) {

  var expires = "";

  var date = new Date();
  date.setTime(date.getTime() + (2 * 60 * 60 * 1000));
  expires = "; expires=" + date.toUTCString();

  document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

// get cookie function
function getCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) === ' ') c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
  }
  return null;
}