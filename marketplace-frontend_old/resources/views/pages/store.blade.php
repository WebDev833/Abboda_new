@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp

@extends('layouts.static')
@section('content')
<div class="ps-vendor-store">
    <div class="container">
        <div class="ps-section__container roms--sidebar-container">
            <div class="ps-section__left roms--sidebar">
                <div class="ps-block--vendor">
                    <div class="ps-block__thumbnail"><img src="{{ $store['company']['image'] }}"
                            alt="{{ $store['company']['name']}}" title="{{ $store['company']['name']}}"
                            onerror="this.src='{{ asset(config('roms.store.defaultLogoImage'))}}';"></div>
                    <div class="ps-block__container">
                        <div class="ps-block__header">
                            <h4>{{ $store['company']['name'] }}</h4>
                            <select class="ps-rating" data-read-only="true">
                                @for ($rate = 0; $rate < 5; $rate++) @if($rate < $store['company']['rating']) <option
                                    value="1">1</option>
                                    @else
                                    <option value="2">2</option>
                                    @endif
                                    @endfor
                            </select>
                        </div>
                        <span class="ps-block__divider"></span>
                        <div class="ps-block__content">
                            <p>{{ $store['company']['description'] }}</p>
                            <span class="ps-block__divider"></span>
                            <p><strong>Address</strong> {{ $store['company']['address'] }}</p>
                        </div>
                        <div class="ps-block__footer d-none">
                            <p>Call us directly<strong>(+053) 77-637-3300</strong></p>
                            <p>or Or if you have any question</p><a class="ps-btn ps-btn--fullwidth" href="#">Contact
                                Seller</a>
                        </div>
                    </div>
                </div>
                <div class="ps-block--vendor">
                    <div class="ps-block__container">

                        <aside class="widget widget--vendor widget--open-time">
                            <h3 class="widget-title"><i class="icon-clock3"></i> Store Hours</h3>
                            <ul>
                                @foreach ($store['workdays'] as $workday)
                                <li><strong>{{ucfirst($workday['day'])}}
                                        :</strong><span>{{ romsStoreTime($workday['open_time'])}} -
                                        {{romsStoreTime($workday['close_time'])}}</span></li>
                                @endforeach
                            </ul>
                        </aside>
                        @if($store['categories'])
                        <aside class="widget widget--vendor">
                            <h3 class="widget-title">Store Categories</h3>
                            <ul class="ps-list--arrow">
                                @foreach ($store['categories'] as $category)
                                <li><a href="javascript:void(0);"
                                        data-cat-id="{{$category['id']}}">{{$category['name']}}</a></li>
                                @endforeach
                            </ul>
                        </aside>
                        @endif
                    </div>
                </div>
            </div>
            <div class="ps-section__right">
                  @if (!$store['company']['acceptingOrders'])
                    <div class="roms--not-accepting-orders">
                      <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Attention!</h4>
                        <p class="mb-1">This store is not accepting currently, please checkout other stores in the system. This store is not accepting currently, please checkout other stores in the system. This store is not accepting currently, please checkout other stores in the system.</p>
                        <hr/>
                        <p class="mb-3">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    </div>
                  @endif
                <div class="ps-shopping ps-tab-root">
                    <div class="ps-tabs">
                        <div class="ps-tab active" id="tab-2">
                          @if($store['categories'])
                            @foreach ($store['categories'] as $category)
                            @if ($category['products'])
                            @foreach ($category['products'] as $product)
                            {{-- {{romsShowProduct($product)}} --}}
                            <div class="ps-product ps-product--wide" data-cat-id="{{$category['id']}}">
                                <div class="ps-product__thumbnail"><a href="javascript:void(0);">
                                  <img src="{{ $product['image'] }}"
                            alt="{{ $product['name']}}" title="{{ $product['name']}}" onerror="this.src='{{ asset(config('roms.store.defaultProductImage'))}}';">
                            </a>
                                </div>
                                <div class="ps-product__container">
                                    <div class="ps-product__content"><a class="ps-product__title"
                                            href="javascript:void(0);">{{ $product['name']}}</a>
                                        <ul class="ps-product__desc">
                                            <li> Unrestrained and portable active stereo speaker</li>
                                            <li> Free from the confines of wires and chords</li>
                                            <li> 20 hours of portable capabilities</li>
                                            <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                            <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                        </ul>
                                    </div>
                                    <div class="ps-product__shopping">
                                        <p class="ps-product__price sale">{{ romsProPrice($product['price']) }}</p>

                                        <a class="ps-btn" href="{{ route('addtocartpage',[$product['id']])}}">Add to cart</a>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
