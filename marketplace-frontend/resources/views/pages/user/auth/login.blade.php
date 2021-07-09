<meta name="csrf-token" content="{{ csrf_token() }}" />

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

<div class="container">
{!! Form::open(['class'=>'ps-form--account ps-tab-root form-signin','id'=>'loginform']) !!}



<div class="text-login-mobile mt-20 mb-20">

<h6 class="color-medium text-center">Login to your account</h6>
</div>
<div id="error-message" class="mt-3"></div>
<div class="form-label-group">

                        {!! Form::email('email', old('email'),
                        ["class"=>"input-field-mobile form-control","id"=>"inputEmail","placeholder"=>trans('front.enter_your_email')]) !!}
                        <label for="inputEmail">Email address</label>
                    </div>
                    <div class="form-label-group form-forgot">
                        {!! Form::password('password', ['class'=>'input-field-mobile  form-control','id'=>'password-field','placeholder'=>
                        trans('front.enter_your_password')]) !!}
                        
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        <label for="password-field">Password</label>
                    </div>
                    <div class="form-group  d-none">
                        <div class="ps-checkbox">
                            {!! Form::checkbox('remember',old('remember') ? 'checked' : 'checked',old('remember') ? 'checked' :
                            'checked', ["id"=>"remember-me","class"=>"form-control"]) !!}
                            <label for="remember-me">{{ trans('front.login_remember_me_text') }}</label>
                        </div>
                    </div>
                    <div class="forget-password"> <a href="{{ route('forgotpasswordpage')}}" class="color-medium text-bdy2">Forget Password?</a>
                </div>
                <div class="form-group sign-in-btn">
                        <button type="submit"
                            class="sign-mobile btn btn-danger" >SIGN IN</button>
                      
                    </div>

{!! Form::close() !!}
<div class="signin-bottom">
<div class="connect-text">
<p>or connect with</p>

</div>

<div class="connect-buttons pb-100">
<a  class="google-btn" type="button" href="{{route('socialLogin',['provider'=>'google'])}}"><img src="{{asset('images/google-icon.png')}}"> GOOGLE</a>
<a  class="google-btn" type="button" href="{{route('socialLogin',['provider'=>'facebook'])}}"><img src="{{asset('images/fb-icon.png')}}"> FACEBOOK</a>
</div>

<div class="register-now-text">
    <h5>New to Abboda? <a class="color-primary" href="{{route('register')}}"> Register now</a></h5>
</div>
</div>

</div>


</div>
{{--<div class="ps-my-account">
    <div class="container">
        {!! Form::open(['class'=>'ps-form--account ps-tab-root','id'=>'loginform']) !!}
        <ul class="ps-tab-list d-none">
            <li class="active"><a href="#sign-in">Login</a></li>
            <li><a href="#register">Register</a></li>
        </ul>
        <div class="ps-tabs" id="roms--login">
            <div class="ps-tab active" id="sign-in">
                <div class="ps-form__content">
                    <h5>{{ trans('front.log_in_to_your_account') }}</h5>
                    <div id="error-message" class="mt-3"></div>
                    <div class="form-group">
                        {!! Form::email('email', old('email'),
                        ["class"=>"form-control","placeholder"=>trans('front.enter_your_email')]) !!}
                    </div>
                    <div class="form-group form-forgot">
                        {!! Form::password('password', ['class'=>'form-control','placeholder'=>
                        trans('front.enter_your_password')]) !!}
                        <a href="{{ route('forgotpasswordpage')}}">{{ trans('front.login_forgot_text') }}</a>
                    </div>
                    <div class="form-group">
                        <div class="ps-checkbox">
                            {!! Form::checkbox('remember',old('remember') ? 'checked' : '',old('remember') ? 'checked' :
                            '', ["id"=>"remember-me","class"=>"form-control"]) !!}
                            <label for="remember-me">{{ trans('front.login_remember_me_text') }}</label>
                        </div>
                    </div>
                    <div class="form-group submtit">
                        <button type="submit"
                            class="ps-btn ps-btn--fullwidth" >{{ trans('front.login_button_text') }}</button>
                      
                    </div>
                    <a href="{{route('register')}}" >{{ trans('front.donot_have_an_account_text') }}</a>
                </div>
                <div class="ps-form__footer">
                    <p>{{ trans('front.connect_with_text') }} :</p>
                    <ul class="ps-list--social">
                        <li><a class="facebook" href="{{route('socialLogin',['provider'=>'facebook'])}}"><i class="fa fa-facebook"></i> {{ trans('front.facebook_text') }}</a></li>
                        <li><a class="google" href="{{route('socialLogin',['provider'=>'google'])}}">
                            <img src="{{asset('/images/google_icon.png')}}"> {{ trans('front.google_text') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>--}}
</div>
@endsection
@section('page-scripts')
<script>
$(".toggle-password").click(function() {

$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});
$.ajaxSetup({

headers: {

    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

}

});
$("#loginform").submit(function(e){

e.preventDefault();


        var password = $("input[name=password]").val();

        var email = $("input[name=email]").val();
$.ajax({

type:'POST',

url:"{{ route('loginPost') }}",

data:{password:password, email:email},


error:function (e) { //call when errro occured in the server
                $('.loading-custom').remove();
                $(".custom-message").remove();
                $(".custom-error").remove();
                var message=`<div class="alert alert-danger custom-error" id="success-alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Error! </strong> The Information You Enter Is Incorrect.
              </div>`;
                 $("#error-message").html(message);
            },
            
            success: function (res) {
 
                
                
                window.location.href = res; 

                 }


});

});
</script>
@endsection