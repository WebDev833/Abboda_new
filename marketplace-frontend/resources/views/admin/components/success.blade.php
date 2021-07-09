@if ($message = Session::get('success'))
<div class="mb-3">
  <div class="alert alert-outline-success mg-b-0" role="alert">
  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
  <span aria-hidden="true">×</span></button>
      <p class="mg-b-0">{{ $message }}</p>
  </div>
</div>
@endif
