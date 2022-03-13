@extends('layouts.admin')
@section('content')

    <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>User Manager</h1>
              </div>
            </div>
          </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <!-- add data -->
            <div class="card collapsed-card" ref="collapsedCard">
                <div class="card-header btn" data-card-widget="collapse" id="collapsedCard">
                    <h3 class="card-title">Add New User</h3>
                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body" >
                  <form method="POST" enctype="multipart/form-data" id="formInsert" action="javascript:void(0)"> 
                      <div class="form-group col-12">
                          <div class="row">
                            
                            <div class="form-group col-6">
                                <label>Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter User Full Name" required>
                                <small class="text-danger" id="emailStoreError"></small>
                            </div>   
                            <div class="form-group col-6">
                                <label>Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required minlength="6">
                                <small class="text-danger" id="passwordStoreError"></small>
                            </div>   
                          </div>
                          <div class="row">
                            <div class="form-group col-6">
                                <label>User Full Name</label>
                                <input type="text" class="form-control" id="userName" name="name" placeholder="Enter User Full Name" required minlength="3">
                                <small class="text-danger" id="nameStoreError"></small>
                            </div>   
                            <div class="form-group col-6">
                              <label>Role</label>
                              <select class="form-control" id="role" name="role" required></select>
                              <small class="text-danger" id="roleStoreError"></small>
                            </div>   
                          </div>    
                      </div>
                      <div class="form-group col-6">
                          <button 
                          type="submit" 
                          class="btn btn-primary btn-flat"
                          id="storeButton"
                          >Submit</button>
                          
                      </div>
                  </form>
                </div>
            </div>
           
            <!-- display data -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Title</h3>
              </div>
              <div class="card-body">
                
              <table class="table table-sm table-bordered table-hover table-striped dataTables">
                <thead class="thead-dark">
                    <tr>
                      <th class="noField">No</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
                
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>

@endsection

@push('modals')
<!-- edit modal --> 
<div class="modal fade" id="ajaxModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" id="formEdit" action="javascript:void(0)" >  
            <div class="modal-body">
              <div class="form-group">
                  <label for="name" class="col-sm-4 control-label">Name</label>
                  <div class="col-sm-12">
                      <input type="text" class="form-control" id="uuid" name="uuid" hidden>
                      <input type="text" class="form-control" id="nameView" name="name" placeholder="Enter First Name" required minlength="3">
                      <small class="text-danger" id="nameError"></small>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-12">
                      <input type="email" id="emailView" name="email"  placeholder="Enter Email" class="form-control" required>
                      <small class="text-danger" id="emailError"></small>
                  </div>
              </div>
              <div class="form-group">
                  <label for="role" class="col-sm-4 control-label">Role</label>
                  <div class="col-sm-12">
                      <select class="form-control" id="roleView" name="role" required></select>
                      <small class="text-danger" id="roleError"></small>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger resetPassword">Reset Password</button>
              <button type="button" id="edit-button" class="btn btn-primary" onclick="event.preventDefault(); clickEdit();">Edit</button>
              <button type="submit" id="save-button" class="btn btn-success">Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>   
<!-- /.edit modal -->

<!-- resetPassword --> 
<div class="modal fade" id="modalNewPassword" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalHeadingResetPassword"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" id="formResetPassword" action="javascript:void(0)" >  
            <div class="modal-body">
              <div class="form-group">
                  <label class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-12">
                      <input type="email" id="emailConfirm" placeholder="Enter Email" class="form-control">
                  </div>
              </div>
              <div class="form-group">
                  <label for="name" class="col-sm-12 control-label">New Password</label>
                  <div class="col-sm-12">
                      <input type="password" class="form-control" id="newPassword" name="password" placeholder="Enter New Password" required minlength="6">
                      <small class="text-danger" id="newPasswordError"></small>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-12 control-label">Confirm New Password</label>
                  <div class="col-sm-12">
                      <input type="password" class="form-control" id="confirmNewPassword" name="password_confirmation"  placeholder="Enter Confirm New Password" required minlength="6">
                      <!--<small class="text-danger" id="confirmNewPasswordError"></small>-->
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success resetPasswordSubmit">Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>   
<!-- /.resetPassword -->
@endpush

@push('scripts')

<script>
$("#overlay").fadeIn()
var columns = [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'roles', name: 'roles'},
    ];
var url = "{{ route('UsersApi.index') }}";

$( "#collapsedCard" ).click(function() {

    onFocusForm("email",200);
});

mainLoad()

function mainLoad()
{
  $.when(checkToken())
  .done(function (ct) {

      getDataTables(url,columns)
      listRoles(null)
      $("#overlay").fadeOut()
  });
}

$(document).ready(function() {

  $('.dataTables tbody').on('click', 'tr', function () {

    $("#overlay").fadeIn();　
    $("#save-button").hide();
    $(".resetPassword").show();
    
    trId = $(this).attr('id');
    // console.log('click ID : ',trId)
    // Send delete data to backend
    $.ajax({
      method : "GET",
      url:"/api/users/"+trId,
      success: function (data) {

        var data = data.data

        $.when(listRoles(data.role))
        .always(function (d) {

          $("#overlay").fadeOut();
          $('#modalHeading').html("Edit User");
          $('#ajaxModal').modal('show');
          $('#uuid').val(data.uuid);
          $('#nameView').val(data.name).prop('disabled', true);
          $('#emailView').val(data.email).prop('disabled', true);
          $('#roleView').prop('disabled', true);
          $("#edit-button").show();
          $('.resetPassword').attr('id', data.uuid+'|'+data.email);
        });
      },
      error: function (data) {
          
          // Get error data
          $("#overlay").fadeOut()
          toastr.error('Failed To Load Data')
          console.log('Error:', data);
      }
    });
  });
});

function clickEdit()
{
  $('#nameView').prop('disabled', false);
  $('#emailView').prop('disabled', false);
  $('#roleView').prop('disabled', false);
  $("#edit-button").hide();
  $("#save-button").show();
  $(".resetPassword").hide();
}

function listRoles(role)
{
  return $.ajax({
      
      url : "{{ route('UsersApi.listRoles') }}",
      method : "GET",
      async : true,
      dataType : 'json',
      success: function(data){

        var data = data.data
        
        var html = ''
        html += '<option value="" disabled selected>Select your option</option>';
        var i;
        for(i=0; i<data.length; i++){
            html += '<option value='+data[i]+'>'+data[i]+'</option>';
        }

        if (role){

          $('#roleView').html(html);
          // Set selected value
          $('#roleView').val(role)
        }else{

          $('#role').html(html);
        }
        
      }
  });
}

// Send edited data to backend
$("#formEdit").submit(function(e){

  e.preventDefault();
  $('#save-button').prop('disabled', true);
  var uuid = $("input[name=uuid]").val();
  var formData = new FormData(this);

  // Send form value to backend
  $.ajax({

    type:'POST',
    url:"/api/users/"+uuid,
    headers: {"X-HTTP-Method-Override": "PUT"},
    data: formData,
    cache:false,
    contentType: false,
    processData: false,  
    success:function(data){

      // Hide ajax modal
      $('#ajaxModal').modal('hide')
      // Success message
      toastr.success(data.message)
      // Reload datatable
      $('.dataTables').DataTable().ajax.reload(null, false)
    },
    error:function (e){

      editError(e.responseJSON.errors)
    }
  });
});

function editError(err)
{
  $('#nameError').text(err?err.name:"")
  $('#emailError').text(err?err.email:"")
  $('#roleError').text(err?err.role:"")
  $('#save-button').prop('disabled', false)
}

// Clear error status after close modal
$('#ajaxModal').on('hidden.bs.modal', function () {

  // reset form
  editError()
});

// Send new data to backend
$("#formInsert").submit(function(e){

  storeError()

  e.preventDefault();
  var formData = new FormData(this);

  $.ajax({

    type:'POST',
    url:"{{ route('UsersApi.store') }}",
    data: formData,
    cache:false,
    contentType: false,
    processData: false,  
    success:function(data){

      toastr.success(data.message)
      $("#formInsert").trigger("reset");
      $('.dataTables').DataTable().ajax.reload()
      $('#storeButton').prop('disabled', false);
    },
    error:function (e){

      var err = e.responseJSON.errors

      storeError(err)
    }
  });
});

function storeError(err){

  $('#nameStoreError').text(err?err.name:"")
  $('#emailStoreError').text(err?err.email:"")
  $('#roleStoreError').text(err?err.role:"")
  $('#passwordStoreError').text(err?err.password:"")
  $('#storeButton').prop('disabled',err?false:true);
}

$(document).ready(function() {

  $('.resetPassword').on('click', function () {
    
    const getId = $('.resetPassword').attr('id')  
    const newArr = getId.split("|")
    const id = newArr[0]
    const email = newArr[1]

    $('#ajaxModal').modal('hide');
    $('#modalNewPassword').modal('show');
    $('#modalHeadingResetPassword').html("Reset Password");
    $('#emailConfirm').val(email).prop('readonly',true)
    $('.resetPasswordSubmit').attr('id', id);
  });
});

// Send new data to backend
$("#formResetPassword").submit(function(e){

  e.preventDefault();
  $('.resetPasswordSubmit').prop('disabled',true)
  $('#newPasswordError').text('')
  var uuid = $('.resetPasswordSubmit').attr('id');
  var formData = new FormData(this);

  $.ajax({

    type:'POST',
    headers: {"X-HTTP-Method-Override": "PUT"},
    url:"/api/users/password-reset/"+uuid,
    data: formData,
    cache:false,
    contentType: false,
    processData: false,  
    success:function(data){

      // Hide ajax modal
      $('#modalNewPassword').modal('hide')
      // Success message
      toastr.success(data.message)
      $('.resetPasswordSubmit').prop('disabled',false)
    },
    error:function (e){

      $('#newPasswordError').text(e.responseJSON.errors.password)
      $('.resetPasswordSubmit').prop('disabled',false)
    }
  });
});

$('#modalNewPassword').on('hidden.bs.modal', function () {

  $('#newPassword').val('')
  $('#confirmNewPassword').val('')
  $('#newPasswordError').text('')
});
</script>
@endpush

@push('styles')

  <style> 
    .noField {
      width: 7%;
    }
  </style>
@endpush