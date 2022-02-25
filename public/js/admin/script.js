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

    setCookie('sidebarMenu','close',24);
  }else{

    setCookie('sidebarMenu','open',24);
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
function setCookie(name, value, ex) {

  var expires = "";

  var date = new Date();
  date.setTime(date.getTime() + (ex * 60 * 60 * 1000));
  expires = "; expires=" + date.toUTCString();

  document.cookie = name + "=" + (value || "") + expires + "; path=/; "+ " SameSite=LAX;";
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

function onFocusForm(id,ms){
  setTimeout(function () {
      $("#"+id+"").focus();
  }, ms);
}

function eraseCookie(name) {   
  document.cookie = name+'=; Max-Age=-99999999;';  
}

$(function() {
  
  var token = getCookie('token')

  if (!token) {

    getToken()
  }

});

function getToken(){

  $.ajax({
    url : "/user/get-token",
    method : "GET",
    async : true,
    dataType : 'json',
    success: function(data){

      const now = new Date()
      
      setCookie('token',data.data,8)
      setCookie("token_ttl", now.getTime() + (8 * 60 * 60 * 1000),8)
    }
  });
}

$.ajaxSetup({
  headers: {
      'Authorization': 'Bearer '+getCookie('token')
  }
});

function checkToken(){

  return $.ajax({
    url : "/api/users-check",
    method : "GET",
    async : true,
    dataType : 'json',
    success: function(data){
      
      console.log('checkToken ',data.data)

      return data.data
      
    },
    error:function (data){

      getToken()
      location.reload()
    }
  });
}

function clickLogout()
{
  eraseCookie('token'); 
  document.getElementById('logout-form').submit();
}