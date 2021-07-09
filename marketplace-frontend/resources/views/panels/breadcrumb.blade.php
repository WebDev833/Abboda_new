@if (isset($frontSettings) && $frontSettings['breadcrumb'] === TRUE)
<div class="ps-breadcrumb">
    <div class="container">

    	<div class="row">
    	<div class="col-md-6">
	        <ul class="breadcrumb">
	            <li><a href="{{ url('') }}">Home</a></li>
	            <li>{{ $frontSettings['title'] }}</li>
	        </ul>
    	</div>

        <div class="col-md-6">
        	
        	@if (Session::has('deliverydetails.address'))
       		<i class="fa fa-map-marker"></i>  {{ Session::get('deliverydetails.address') }}   	
        	@endif
        </div>

    </div>

    </div>
</div>
@endif
