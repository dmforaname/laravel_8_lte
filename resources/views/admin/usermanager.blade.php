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
                      <input type="text" class="form-control" id="id" name="id" hidden>
                      <input type="text" class="form-control" id="nameView" name="name" placeholder="Enter First Name" maxlength="50">
                      <small class="text-danger" id="firstNameEditError"></small>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-12">
                      <input type="email" id="emailView" name="email"  placeholder="Enter Email" class="form-control">
                      <small class="text-danger" id="emailEditError"></small>
                  </div>
              </div>
              <div class="form-group">
                  <label for="role" class="col-sm-4 control-label">Role</label>
                  <div class="col-sm-12">
                      <input type="text" class="form-control" id="roleView" name="role" placeholder="Enter Role" maxlength="50">
                      <small class="text-danger" id="roleError"></small>
                  </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              
              <button type="submit" class="btn btn-primary btn-submit">Edit</button>
            </div>
            </form>
        </div>
    </div>
</div>   
<!-- end edit modal -->
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
<script>

var columns = [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'roles', name: 'roles'},
    ];
var url = "{{ route('users.index') }}";

$( "#collapsedCard" ).click(function() {

    onFocusForm("userName",200);
});

$.when(checkToken())
  .always(function (ct) {

      getDataTables(url,columns)
  });

$(document).ready(function() {

  $('.dataTables tbody').on('click', 'tr', function () {

    $("#overlay").fadeIn();　
    
    trId = $(this).attr('id');
    console.log('click ID : ',trId)
    // Send delete data to backend
    $.ajax({
      method : "GET",
      url:"/api/users/"+trId,
      success: function (data) {

          var data = data.data
          $("#overlay").fadeOut();
          $('#modalHeading').html("Edit User");
          $('#ajaxModal').modal('show');
          $('#id').val(data.id);
          $('#nameView').val(data.name).prop('disabled', true);
          $('#emailView').val(data.email).prop('disabled', true);
          $('#roleView').val(data.role).prop('disabled', true);
      },
      error: function (data) {
          
          // Get error data
          console.log('Error:', data);
      }
    });
  });
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