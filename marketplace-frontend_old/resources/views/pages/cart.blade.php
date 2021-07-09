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
            <div class="table-responsive">
                <table class="table ps-table--shopping-cart">
                    <thead>
                        <tr>
                            <th>{{ trans('front.product_name') }}</th>
                            <th>{{ trans('front.price') }}</th>
                            <th>{{ trans('front.quantity') }}</th>
                            <th>{{ trans('front.total') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                        <tr>
                            <td>
                                <div class="ps-product--cart">
                                    <div class="ps-product__thumbnail"><a href="javascript:void(0);"><img
                                                src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                                title="{{ $item['name'] }}"
                                                onerror="this.src='{{ asset(config('roms.cart.defaultThumbImage'))}}';" /></a>
                                    </div>
                                    <div class="ps-product__content"><a
                                            href="javascript:void(0);">{{ $item['name'] }}</a>
                                    </div>
                                </div>
                            </td>
                            <td class="price">{{ romsProPrice($item['price']) }}</td>
                            <td>
                                <div class="form-group--number">
                                    <button class="down minus">-</button>
                                    <input class="form-control cartItemchange" type="text"
                                        value="{{ $item['quantity'] }}" readonly="readonly"
                                        data-cart-id="{{ $item['id']}}">
                                    <button class="up plus">+</button>
                                </div>
                            </td>
                            <td>{{ romsProPrice($item['total']) }}</td>
                            <td>
                                <a href="{{ route('cartitemdelete',[$item['id']]) }}"><i class="icon-cross"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            <div class="ps-section__cart-actions"><a class="ps-btn" href="{{ route('home') }}"><i
                        class="icon-arrow-left"></i> {{ trans('front.back_to_shop') }}</a>
                {{-- Do not show if no items in cart --}}
                {!! Form::open(['route'=>'updatecart','method'=>'POST','id'=>'updatecartform','class'=>'d-none']) !!}
                {!! Form::text('cartids',null,['id'=>'cartids']) !!}
                {!! Form::text('quantities',null,['id'=>'quantities']) !!}
                <button type="submit">Update cart</button>
                {!! Form::close() !!}
                @if ($cartItems)
                <a class="ps-btn ps-btn--outline" href="javascript:void(0);" id="updatecartbutton"><i
                        class="icon-sync"></i> {{ trans('front.update_cart') }}</a>
                @endif
            </div>
        </div>
        @if ($cartItems)
        <div class="ps-section__footer">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                    <a class="ps-btn ps-btn--fullwidth"
                        href="{{route('checkoutpage')}}">{{ trans('front.proceed_to_checkout') }}</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
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
@endsection
