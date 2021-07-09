@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')
<div class="ps-about-intro">
    <div class="container">
      @if ($pageConfigs['data']['success'])
        <div class="ps-section__header text-center order-confirmation-content success">
            <i class="fa fa-5x fa-check-circle"></i>
            <h3>Order Placed Successfully!</h3>            
            <p>Thank you for your order! Your order is being processed and will be completed within 3-6 hours. You will receive an email confirmation when your order is completed.</p>
            <br/>
            <a href="{{route('user.myorders')}}" class="ps-btn">View Orders</a>
        </div>
      @else
         <div class="ps-section__header text-center order-confirmation-content error">
            <i class="fa fa-5x fa-times-circle"></i>
            <h3>Sorry!! Error Placing Order!</h3>            
            <p>If you are going to use of Lorem Ipsum need to be sure there isn't hidden of text. If you are going to use of Lorem Ipsum need to be sure there isn't hidden of text. If you are going to use of Lorem Ipsum need to be sure there isn't hidden of text. If you are going to use of Lorem Ipsum need to be sure there isn't hidden of text</p>
            <br/>
            <a href="{{route('user.myorders')}}" class="ps-btn">View Orders</a>
        </div>
      @endif
    </div>
</div>
@endsection
