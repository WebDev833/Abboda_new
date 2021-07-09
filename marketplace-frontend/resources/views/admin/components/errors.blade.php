@if (session('error'))
<div class="mb-3">
  <div class="alert alert-outline-danger mg-b-0" role="alert">
  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
  <span aria-hidden="true">×</span></button>
      <p class="mg-b-0">{{session('error')}}</p>
  </div>
</div>
@endif

@if ($errors->any())
<div class="mb-3">
  <div class="alert alert-outline-danger mg-b-0" role="alert">
  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
  <span aria-hidden="true">×</span></button>
    @foreach ($errors->all() as $error)
      <p class="mg-b-0">{{ $error }}</p>
    @endforeach
  </div>
</div>
@endif