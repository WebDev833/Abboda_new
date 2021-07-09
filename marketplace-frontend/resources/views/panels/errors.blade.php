@if (session('error'))
<div class="alert alert-danger mb-4">
    <ul>
        <button type="button" class="close" data-dismiss="alert">×</button>
        <li class="mb-2">{{session('error')}}</li>
    </ul>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger mb-4">
    <ul>
        <button type="button" class="close" data-dismiss="alert">×</button>
        @foreach ($errors->all() as $error)
        <li class="mb-2">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif