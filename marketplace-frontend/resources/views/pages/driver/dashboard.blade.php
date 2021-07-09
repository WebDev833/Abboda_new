@extends('pages.driver.driverlayout')

@section('drivermapsection')

@endsection 

@section('driverpage')
@include('panels.success')
@include('panels.errors')
<h5 class="mb-5" style="font-size: 20px;">Profile</h5>

@include('pages.driver.mylocation_html')
  
   
@endsection
@include('pages.driver.mylocation_js_css')
