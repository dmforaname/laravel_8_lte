@extends('layouts.admin')

@section('content')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Admin</h1>
          </div>
        </div>
      </div>
</section>

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Title</h3>
              </div>
              <div class="card-body">
                
                Welcome to admin page
                
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>
@endsection

@push('scripts')
<script>

$.when(checkToken()).done(function (ct) {

    
});

</script>
@endpush