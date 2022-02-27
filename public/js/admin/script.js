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
  date.setTime(date.getTime() + (ex * 24 * 60 * 60 * 1000));
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

      checkTokenError()
    }
  }
});

function getToken(){

  return $.ajax({
    url : "/user/get-token",
    method : "GET",
    async : true,
    dataType : 'json',
    success: function(data){

      const now = new Date()
      
      var x = 30;
      setCookie('token',data.data,x)
      setCookie("token_ttl", now.getTime() + (x * 24 * 60 * 60 * 1000),x)
    }
  });
}

function setupHeader(){

  $.ajaxSetup({
    headers: {
        'Authorization': 'Bearer '+getCookie('token'),
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
}

setupHeader()

async function checkToken(){

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

        checkTokenError()
      //}, 2000);
    }
  });
}

function checkTokenError() {

  var token = getCookie('token')

  if (token) {

    eraseCookie('token')
    eraseCookie('token_ttl')
  }

  $.when(getToken()).done(function (gt) {

    if (gt)
      setupHeader()
  });   
}

function clickLogout()
{
  //document.getElementById('logout-form').submit();

  return $.ajax({
    url : "/api/logout",
    method : "POST",
    async : true,
    dataType : 'json',
    success: function(data){

      console.log('clickLogout')
      eraseCookie('token')
      eraseCookie('token_ttl')
      
      document.getElementById('logout-form').submit();
    },
    error:function (err){

      console.log(err)
    }
  });
}

function getDataTables(url,col) {

  console.log('getDataTables')

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

          reCallTable(url,col)
        }    
      }
    },
    columns: col
  });
}

function reCallTable(url,col) {

  $('.dataTables').DataTable().destroy();
  getDataTables(url,col)
}