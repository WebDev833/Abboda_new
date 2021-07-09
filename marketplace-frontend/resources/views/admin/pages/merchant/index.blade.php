<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@extends('admin.layouts.page')
@section('page')
<!-- Page Header -->
<div class="page-header">
  <div>
    <h2 class="main-content-title tx-24 mg-b-5">{{$pageConfigs['title']}}</h2>
    @if ($pageConfigs['breadcrumb'])
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{$pageConfigs['title']}}</li>
    </ol>
    @endif
  </div>
  <div class="btn btn-list">
   <a class="btn ripple btn-primary add-media" href="{{route('admin.addmerchant')}}"><i class="fe fe-file-plus"></i> Add Merchant</a>
 </div>
</div>
<!-- End Page Header -->
<!-- Row -->
<div class="row">
<div class="col-sm-12 col-xl-12 col-lg-12">
  <div class="card custom-card">
    <div class="card-body">
      <div>
        <h6 class="card-title mb-1">Merchant List</h6>
        <p class="text-muted card-sub-title">Below is the list of Merchants.</p>
      </div>
      @include('admin.components.errors')
      @include('admin.components.success')
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap mb-0 data-table">
          <thead>
            <tr>
              <th># ID</th>
              <!-- <th>Area Name</th> -->
              <th>merchant Name</th>
              <th>Updated at</th>
              <th>URL</th>
              <th>Locations</th>
              <th>Status</th>
              <th>Store</th>
              <th>Action</th>
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
<!-- End Row -->
@endsection


@section('page-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.merchants') }}",
        columns: [
            {data: 'id', name: 'id'},   
            // {data: 'area.name', name: 'area.name'},
            {data: 'name', name: 'name'},
            {data: 'updatedate', name: 'updated_at'},
            {data: 'url', name: 'url'},
            {data: 'locations', name: 'locations'},
            {data: 'status', name: 'status'},
            {data: 'store', name: 'store'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@endsection