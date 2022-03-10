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
                  <form method="POST" enctype="multipart/form-data" id="formInsert" action="javascript:void(0)" > 
                      <div class="form-group col-12">
                          <div class="row">
                            <div class="form-group col-6">
                                <label>User Full Name</label>
                                <input type="text" class="form-control" id="userName" name="name" placeholder="Enter User Full Name">
                                <small class="text-danger" id="nameError"></small>
                            </div>   
                          </div>    
                      </div>
                      <div class="form-group col-6">
                          <button 
                          type="button" 
                          ref="submitButton"
                          class="btn btn-primary btn-flat"
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
                      <input type="text" class="form-control" id="nameView" name="name" placeholder="Enter First Name" maxlength="50">
                      <small class="text-danger" id="nameError"></small>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-12">
                      <input type="email" id="emailView" name="email"  placeholder="Enter Email" class="form-control">
                      <small class="text-danger" id="emailError"></small>
                  </div>
              </div>
              <div class="form-group">
                  <label for="role" class="col-sm-4 control-label">Role</label>
                  <div class="col-sm-12">
                      <select class="form-control" id="roleView" name="role"></select>
                      <small class="text-danger" id="roleError"></small>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="edit-button" class="btn btn-primary" onclick="event.preventDefault(); clickEdit();">Edit</button>
              <button type="submit" id="save-button" class="btn btn-success">Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>   
<!-- /.edit modal -->
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
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

    onFocusForm("userName",200);
});

mainLoad()

function mainLoad()
{
  $.when(checkToken())
  .done(function (ct) {

      getDataTables(url,columns)
      $("#overlay").fadeOut()
  });
}

$(document).ready(function() {

  $('.dataTables tbody').on('click', 'tr', function () {

    $("#overlay").fadeIn();　
    $("#save-button").hide();
    
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
        
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
            html += '<option value='+data[i]+'>'+data[i]+'</option>';
        }
        $('#roleView').html(html);
        // Set selected value
        $('#roleView').val(role)
      }
  });
}

// Send edited data to backend
$("#formEdit").submit(function(e){

  e.preventDefault();
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
      $('.dataTables').DataTable().ajax.reload()
    },
    error:function (e){

      var err = e.responseJSON.errors

      // Show error status on edit form
      $('#nameError').text(err.name)
      $('#emailError').text(err.email)
      $('#roleError').text(err.role)
    }
  });
});

// Clear error status after close modal
$('#ajaxModal').on('hidden.bs.modal', function () {

  $('#emailError').text('')
  $('#nameError').text('')
  $('#roleError').text('')
});

</script>
@endpush

@push('styles')

  <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <style> 
    .noField {
      width: 5%;
    }
  </style>
@endpush