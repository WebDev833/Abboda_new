@if (isset($frontSettings) && $frontSettings['breadcrumb'] === TRUE)
<div class="ps-breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ url('') }}">Home</a></li>
            <li>{{ $frontSettings['title'] }}</li>
        </ul>
    </div>
</div>
@endif
