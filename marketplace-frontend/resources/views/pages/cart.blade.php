@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')
<div class="ps-section--shopping ps-shopping-cart">
    <div class="container">
        <div class="ps-section__header d-none">
            <h1>{{ trans('front.shopping_cart') }}</h1>
        </div>
        <div class="ps-section__content">
            @if (!$cartItems)
            <p class="roms--nocart-items">No Items in your carts.</p>
            @else
@php
$banner = $pageConfigs['store']->getFirstMedia('merchant_image');
    $storeimage='';
 if($banner){
    $storeimage=$banner->getUrl();
 }
@endphp
        <div class="cart-new">

            <div class="cart-store">
                <div class="s-img">
                    <img  src="{{$storeimage}}" onerror="this.src='{{ asset(config('roms.cart.defaultThumbImage'))}}';" / alt="">
                </div>
                <h6 class="s-title">{{$pageConfigs['store']->name}}</h6>
            </div>

            <div class="cart-products">
                 @foreach ($cartItems as $item)
                <div class="cart-product">
                    <div class="cart-item-left">
<!------
<div class="ps-product__thumbnail"><a href="javascript:void(0);"><img
src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
title="{{ $item['name'] }}"
onerror="this.src='{{ asset(config('roms.cart.defaultThumbImage'))}}';" /></a>
</div>
------>

                    <a href="javascript:void(0);">
                        <h6 class="cart-item-title">{{ $item['name'] }}</h6>
                    </a>
                     <div class="remove-item">
                             <a href="{{ route('cartitemdelete',[$item['id']]) }}"><i class="icon-cross"></i></a>
                         </div>
                    </div>
                     <div class="cart-item-right">
                         <div class="price text-bdy2">{{ romsProPrice($item['total']) }}</div>
                        
                        <div class="form-group--number qty">
                            <button class="down minus">-</button>
                            <input class="form-control cartItemchange" type="text"
                                value="{{ $item['quantity'] }}" readonly="readonly"
                                data-cart-id="{{ $item['id']}}">
                            <button class="up plus">+</button>
                        </div>
            
                     </div>

                </div>
                @endforeach
                
            </div>
            

        </div>
           
            @endif
            <div class="ps-section__cart-actions">
                <a class="ps-btn text-btn" href="{{ route('home') }}">
                <i class="icon-arrow-left"></i> {{ trans('front.back_to_shop') }}</a>
                {{-- Do not show if no items in cart --}}
                {!! Form::open(['route'=>'updatecart','method'=>'POST','id'=>'updatecartform','class'=>'d-none']) !!}
                {!! Form::text('cartids',null,['id'=>'cartids']) !!}
                {!! Form::text('quantities',null,['id'=>'quantities']) !!}
                <button type="submit">Update cart</button>
                {!! Form::close() !!}
                @if ($cartItems)
                <a class="ps-btn ps-btn--outline text-btn" href="javascript:void(0);" id="updatecartbutton"><i
                        class="icon-sync"></i> {{ trans('front.update_cart') }}</a>
                @endif
            </div>
        
        @if ($cartItems)
        <div class="ps-section__footer">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">

                    <a class="ps-btn ps-btn--fullwidth text-btn"
                        href="{{route('checkoutpage')}}">{{ trans('front.proceed_to_checkout') }}</a>
                </div>
            </div>
        </div>
        @endif
    </div>
    </div>
</div>
@endsection

@section('page-styles')
@endsection



@section('page-scripts')
<script type="text/javascript">
    $(document).on('click', '.plus', function () {
        if ($(this).prev().val()) {
            $(this).prev().val(+$(this).prev().val() + 1);
        }
    });
    $(document).on('click', '.minus', function () {
        if ($(this).next().val() > 1) {
            if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
        }
    });

    $(document).on('click', '#updatecartbutton', function () {
        var ids = '';
        var qtys = '';
        var sep = '';
        $('.cartItemchange').each(function () {
            ids += sep + $(this).attr('data-cart-id');
            qtys += sep + $(this).val();
            sep = ",";
        });
        $('#cartids').val(ids);
        $('#quantities').val(qtys);

        $('#updatecartform').submit();
    });

</script>
<style>
.ps-section__content {
    margin-top: 70px;
}
</style>
@endsection
