<meta name="csrf-token" content="{{ csrf_token() }}" />
@isset($pageConfigs)
    {!! Front::updatePageConfig($pageConfigs) !!}
@endisset

@extends('layouts.core')
@section('page')
<div class="section">
        @php
            $Deliver_with_abboda=Front::GetWidget('Deliver_with_abboda');

            
        @endphp
            @if(isset($Deliver_with_abboda))
            
            {!! $Deliver_with_abboda->getTranslation('body',App::getLocale()) !!}
          
                @else
                <img src="{{asset('images/restaurant-sample.png')}}"> 
                @endif

                
      </div>

      <div class="container mt-10">
   
      <form action="{{ route('deliverpost') }}" method="POST" enctype="multipart/form-data" class="ps-tab-root">
      @include('panels.success')
    @include('panels.errors')
      @csrf

      <input type="hidden" name="uuid" value="<?php echo time();?>">
      <input type="hidden" name="uuid1" value="<?php echo rand();?>">
      <input type="hidden" name="uuid2" value="<?php echo rand();?>">
      
      <input type="hidden" name="file" value="{!!config('medialibrary.icons_folder')!!}">
<div class="text-login-mobile mt-20 mb-20">

<h6 class="color-medium">Deliver With Abboda</h6>
</div>
<div class="row">

<div class="col-6">
<div class="form-label-group">

                     <input class="input-field-mobile form-control" id="inputEmail" type="email"  name="email">
                        <label for="inputEmail">Email address<span class="text-danger">*</span></label>
                    </div>
                    <div class="form-label-group">

                     <input class="input-field-mobile form-control" id="phone"  type="text" name="mobilenumber">

                        <label for="phone">Mobile Phone<span class="text-danger">*</span></label>
                    </div>
                    <div class="form-label-group">

                     <input class="input-field-mobile form-control" id="fullname"  type="text" name="fullname">
                        <label for="fullname">Full Name<span class="text-danger">*</span></label>
                    </div>
                   
                    <div class="form-label-group">

                     <input class="input-field-mobile form-control" id="idnum"  type="text" name="idnumber">
                        <label for="idnum">ID Number<span class="text-danger">*</span></label>
                    </div>
                  
                    <div class="form-label-group">

                     <input class="input-field-mobile form-control" id="socialnumber"  type="text" name="socialnumber">
                        <label for="socialnumber">Social Security Number<span class="text-danger">*</span></label>
                    </div>
                    <div class="form-label-group">

<select name="vehicle_type" class="input-field-mobile form-control">
<option value="">Select Vehicle Type...</option>
<option value="Car">Car</option>
<option value="Motorcycle">Motorcycle</option>
<option value="Bike">Bike</option>
<option value="Truck">Truck</option>
</select>
   <label for="vehicle">Vehicle Type<span class="text-danger">*</span></label>
</div>
                    </div>
                    <div class="col-6">
                    <div class="form-group">
                    <label class="color-medium" for="inputSpentBudget">Image ID:<span class="text-danger">*</span></label>        
<input class=" form-control" name="imageid" type="file"  style="padding: 8px ;">
</div>
<div class="form-group">
                    <label class="color-medium" for="inputSpentBudget" >Car Register:</label>   

<input class=" form-control" name="carregister" type="file"  style="padding: 8px ;">
</div>

<div class="form-group">
                    <label class="color-medium" for="inputSpentBudget" >Car Insurance:</label>  

<input class=" form-control" name="car_insurance" type="file"  style="padding: 8px ;">
</div>
</div>
</div>
                    <!-- <div class="form-group my-8">
                  <label for="terms-check" class="check-input-control d-flex align-items-center">
                    
                    <input class="form-check-input mr-5" type="checkbox" name="agree" required="" id="tes-checrmk">
                    <span class="mb-0 font-size-5 text-bali-gray">I agree to the  
                      
                     <a href="/terms-page.html" class="text-blue-3 ">Terms &amp; Conditions</a></span>
                  </label>
                </div> -->

                <div class="form-group sign-in-btn">
                        <button type="submit"
                            class="sign-mobile btn btn-danger" style="width : auto ;">SUBMIT</button>
                      
                    </div>





</form>
</div>

<div class="ps-top-slider wsg-section-wrapper wsg-sec-py onlydesktop">
  <div class="ps-container">
    <div class="row">
      <div class="col-md-6">
        <div class="wsg-block-image">
          <img src="{{asset('images/make_money.png')}}">
        </div>
      </div>
      <div class="col-md-6 m-auto">
        <div class="wsg-block-text ml-50">
          <h4>Get the best food and<br> drinks to your door-step</h4>
          <div class="wsg-content">
            <p>Find your favorite and your needs and we will deliver it to you within hour. Reliable trained fleet available anytime anywhere to provide convenience. All at your fingertips.
            </p>
            <a href="#" class="btn btn-primary text-btn">Read More</a>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="ps-top-slider wsg-section-wrapper wsg-sec-py onlydesktop">
  <div class="ps-container">
    <div class="row">
   
      <div class="col-md-6 m-auto">
        <div class="wsg-block-text ">
          <h4>Get the best food and<br> drinks to your door-step</h4>
          <div class="wsg-content">
            <p>Find your favorite and your needs and we will deliver it to you within hour. Reliable trained fleet available anytime anywhere to provide convenience. All at your fingertips.
            </p>
            <a href="#" class="btn btn-primary text-btn">Read More</a>

          </div>
        </div>
      </div>
           <div class="col-md-6">
        <div class="wsg-block-image">
          <img src="{{asset('images/Image12.jpg')}}">
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

