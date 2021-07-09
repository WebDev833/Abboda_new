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
        {!! Form::open(['route'=>'register', 'method'=>'POST','class'=>'ps-form--account ps-tab-root']) !!}
        <ul class="ps-tab-list d-none">
            <li class="active"><a href="#sign-in">Login</a></li>
            <li><a href="#register">Register</a></li>
        </ul>
        <div class="ps-tabs" id="roms--register">
            <div class="ps-tab active" id="sign-up">
                <div class="ps-form__content">
                    <h5>{{ trans('front.create_an_account') }}</h5>
                    @include('panels.errors')

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
</div>
@endsection
