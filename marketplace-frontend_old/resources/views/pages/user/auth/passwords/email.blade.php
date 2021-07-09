@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')
<div class="ps-my-account">
    <div class="container">
        {!! Form::open(['route'=>'login', 'method'=>'POST','class'=>'ps-form--account ps-tab-root']) !!}
        <ul class="ps-tab-list d-none">
            <li class="active"><a href="#sign-in">Login</a></li>
            <li><a href="#register">Register</a></li>
        </ul>
        <div class="ps-tabs" id="roms--login">
            <div class="ps-tab active" id="sign-in">
                <div class="ps-form__content">
                    <h5>{{ trans('front.forgot_password_reset_text') }}</h5>
                    @include('panels.errors')
                    <div class="form-group">
                        {!! Form::email('email', old('email'),
                        ["class"=>"form-control","placeholder"=>trans('front.enter_your_email')]) !!}
                    </div>
                    <div class="form-group">
                        <button type="submit"
                            class="ps-btn ps-btn--fullwidth">{{ trans('front.send_reset_link_text') }}</button>
                    </div>
                    <a href="{{route('register')}}" class="d-block pb-5" >{{ trans('front.donot_have_an_account_text') }}</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
