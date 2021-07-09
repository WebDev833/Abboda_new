@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')
<div class="main-content-mobile">
<div class="account">

<div class="container mt-65">
{!! Form::open(['class'=>'ps-form--account ps-tab-root','id'=>'register']) !!}



<div class="text-login-mobile pb-35">

<h6 class="color-medium text-center">{{ trans('front.create_an_account') }}</h6>
</div>

<div class="form-group">

<div class="form-label-group">
                        {!! Form::text('name', old('name'),
                            ["class"=>"form-control input-field-mobile ","id"=>"inputname","placeholder"=>trans('front.enter_your_name'),'required'=>'required']) !!}
                            <label for="inputname">Full Name</label>
                        </div>
                    <div class="form-label-group">
                        {!! Form::email('email', old('email'),
                        ["class"=>"form-control input-field-mobile ","id"=>"inputEmail","placeholder"=>trans('front.enter_your_email'),'required'=>'required']) !!}
                        <label for="inputEmail">Email address</label>
                    </div>
                    <div class="form-label-group">
                        {!! Form::number('phone', old('phone'), ['class'=>'form-control input-field-mobile ',"id"=>"inputphone","placeholder"=>trans('front.enter_your_phone'),'required'=>'required']) !!}
                        <label for="inputphone">Phone No</label>
                    </div>
                    <div class="form-label-group form-forgot">
                        {!! Form::password('password', ['class'=>'form-control input-field-mobile ',"id"=>"inputpassword",'placeholder'=>
                        trans('front.enter_your_password'),'required'=>'required']) !!}
                        <label for="inputpassword">Password</label>
                    </div>
                    <div class="form-label-group form-forgot">
                        {!! Form::password('password_confirmation', ['class'=>'form-control input-field-mobile ',"id"=>"inputcpassword",'placeholder'=>
                        trans('front.enter_password_confirm_text'),'required'=>'required']) !!}
                        <label for="inputcpassword">Re enter password</label>
                    </div>
                    
                <div class="form-group sign-in-btn">
                        <button type="submit"
                            class="sign-mobile btn btn-secondary" >REGISTER</button>
                      
                    </div>

{!! Form::close() !!}



<div class="register-now-text">
    <h5>Already have an account? <a class="color-primary" href="{{route('login')}}">Sign In</a></h5>
</div>
</div>


</div>
{{-- 
<div class="ps-my-account">
    <div class="container">
        {!! Form::open(['class'=>'ps-form--account ps-tab-root','id'=>'register']) !!}
        <ul class="ps-tab-list d-none">
            <li class="active"><a href="#sign-in">Login</a></li>
            <li><a href="#register">Register</a></li>
        </ul>
        <div class="ps-tabs" id="roms--register">
            <div class="ps-tab active" id="sign-up">
                <div class="ps-form__content">
                    <h5>{{ trans('front.create_an_account') }}</h5>
                    <div id="error-message" class="mt-3"></div>

                    <div class="form-group">
                        {!! Form::text('name', old('name'),
                        ["class"=>"form-control","placeholder"=>trans('front.enter_your_name'),'required'=>'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::email('email', old('email'),
                        ["class"=>"form-control","placeholder"=>trans('front.enter_your_email'),'required'=>'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::number('phone', old('phone'), ['class'=>'form-control',"placeholder"=>trans('front.enter_your_phone'),'required'=>'required']) !!}
                    </div>
                    <div class="form-group form-forgot">
                        {!! Form::password('password', ['class'=>'form-control','placeholder'=>
                        trans('front.enter_your_password'),'required'=>'required']) !!}
                    </div>
                    <div class="form-group form-forgot">
                        {!! Form::password('password_confirmation', ['class'=>'form-control','placeholder'=>
                        trans('front.enter_password_confirm_text'),'required'=>'required']) !!}
                    </div>
                    <div class="form-group submtit">
                        <button type="submit"
                            class="ps-btn ps-btn--fullwidth">{{ trans('front.register_button_text') }}</button>
                    </div>
                    <a href="{{route('login')}}" >{{ trans('front.already_have_an_account_text') }}</a>
                </div>
                <div class="ps-form__footer">
                    <p>{{ trans('front.connect_with_text') }} :</p>
                    <ul class="ps-list--social">
                        <li><a class="facebook" href="{{route('socialLogin',['provider'=>'facebook'])}}"><i class="fa fa-facebook"></i>
                                {{ trans('front.facebook_text') }}</a></li>
                        <li><a class="google" href="{{route('socialLogin',['provider'=>'google'])}}"><i class="fa fa-google-plus"></i>
                                {{ trans('front.google_text') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div> --}}
</div>
@endsection
@section('page-scripts')
<script>

$.ajaxSetup({

headers: {

    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

}

});
$("#register").submit(function(e){

e.preventDefault();


        var password = $("input[name=password]").val();

        var email = $("input[name=email]").val();
        var name = $("input[name=name]").val();
        var phone = $("input[name=phone]").val();
        var password_confirmation = $("input[name=password_confirmation]").val();
$.ajax({

type:'POST',

url:"{{ route('registerform') }}",

data:{password:password, email:email,name:name,phone:phone,password_confirmation:password_confirmation},


error:function (e) { //call when errro occured in the server
                $('.loading-custom').remove();
                $(".custom-message").remove();
                $(".custom-error").remove();
                var message=`<div class="alert alert-danger custom-error" id="success-alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Error! </strong> The given data was invalid.
              </div>`;
                 $("#error-message").html(message);
            },
            
            success: function (res) {
 
                
                
                window.location.href=  window.location.origin;

                 }


});

});


</script>
@endsection