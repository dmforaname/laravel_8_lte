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
                    <h3 class="card-title">Add New Department</h3>
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

$.when(checkToken()).done(function (ct) {

      getDataTables(url,columns)

  }).fail(function () {

    setTimeout(function () {

      getDataTables(url,columns)
    }, 5000);
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