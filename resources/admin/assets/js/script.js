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
window.sideBarAction = function ()
{
  var bodyClass = document.body.className;

  if (bodyClass === "sidebar-mini"){

    window.setCookie('sidebarMenu','close',24);
  }else{

    window.setCookie('sidebarMenu','open',24);
  }  
}

// set cookie function
window.setCookie = function (name, value, ex) {

  var expires = "";

  var date = new Date();
  date.setTime(date.getTime() + (ex * 24 * 60 * 60 * 1000));
  expires = "; expires=" + date.toUTCString();

  document.cookie = name + "=" + (value || "") + expires + "; path=/; "+ " SameSite=LAX;";
}

// get cookie function
window.getCookie = function (name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) === ' ') c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
  }
  return null;
}

window.onFocusForm = function (id,ms){
  setTimeout(function () {
      $("#"+id+"").focus();
  }, ms);
}

window.eraseCookie = function (name) { 

  document.cookie = name+'=; Path=/; Max-Age=-99999999;';  
}
/*
$(function() {
  
  var token = getCookie('token')

  if (!token) {

    getToken()
  }

});
*/

$(function() {
  
  var token = getCookie('token_ttl')

  if (token){

    const now = new Date().getTime()
    const newToken = token - (48*60*60*1000)

    if (now > newToken) {

        window.checkTokenError()
    }
  }
});

window.getToken = function (){

  return $.ajax({
    url : "/user/get-token",
    method : "GET",
    async : true,
    dataType : 'json',
    success: function(data){

      const now = new Date()
      
      var x = 30;
      window.setCookie('token',data.data,x)
      window.setCookie("token_ttl", now.getTime() + (x * 24 * 60 * 60 * 1000),x)
      setTimeout(function () {

        mainLoad()
        }, 1000);
    }
  });
}

window.setupHeader = function (){

  $.ajaxSetup({
    headers: {
        'Authorization': 'Bearer '+window.getCookie('token'),
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
}

window.setupHeader()

window.checkToken = async function (){

  return $.ajax({
    url : "/api/users-check",
    method : "GET",
    async : true,
    dataType : 'json',
    success: function(data){
      
      return data.data
    },
    error:function (data){

      //setTimeout(function () {

        window.checkTokenError()
      //}, 2000);
    }
  });
}

window.checkTokenError = function () {

  var token = getCookie('token')

  if (token) {

    window.eraseCookie('token')
    window.eraseCookie('token_ttl')
  }

  $.when(window.getToken()).done(function (gt) {

    if (gt)
      window.setupHeader()
  });   
}

window.clickLogout = function ()
{
  //document.getElementById('logout-form').submit();

  return $.ajax({
    url : "/api/logout",
    method : "POST",
    async : true,
    dataType : 'json',
    success: function(data){

      window.eraseCookie('token')
      window.eraseCookie('token_ttl')
      
      document.getElementById('logout-form').submit();
    },
    error:function (err){

      console.log(err)
    }
  });
}

window.getDataTables = function (url,col) {

  $('.dataTables').DataTable({

    paging: true,
    lengthChange: false,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: {
      url: url,
      error: function (jqXHR, textStatus, errorThrown) {
         
        console.log(errorThrown)
        if(errorThrown === 'Unauthorized'){

            window.reCallTable(url,col)
        }    
      }
    },
    columns: col
  });
}

window.reCallTable = function (url,col) {

  $('.dataTables').DataTable().destroy();
  window.getDataTables(url,col)
}

// check sidebarmenu cookie
if (window.getCookie('sidebarMenu')){

    if (window.getCookie('sidebarMenu') === 'open'){

        $('body').addClass('sidebar-mini');
    }else{

        $('body').addClass('sidebar-mini sidebar-collapse');
    }
}