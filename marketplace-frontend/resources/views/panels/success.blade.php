@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
  <ul>
    <button type="button" class="close" data-dismiss="alert">×</button>
    <li>{{ $message }}</li>
  </ul>
</div>
@endif