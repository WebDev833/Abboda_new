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
        <div class="ps-section__header">
            <h4>Welcome to ABBODA</h4>
            <h3>We connect millions of buyers and sellers around the world, empowering people & creating economic
                opportunity for all.</h3>
            <p>Within our markets, millions of people around the world connect, both online and offline, to make, sell
                and buy unique goods. We also offer a wide range of Seller Services and tools that help creative
                entrepreneurs start, manage and scale their businesses. Our mission is to reimagine commerce in ways
                that build a more fulfilling and lasting world, and we’re committed to using the power of business to
                strengthen communities and empower people.</p>
        </div>
        <div class="ps-section__content">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6 ">
                    <div class="ps-block--icon-box"><i class="icon-cube"></i>
                        <h4>45M</h4>
                        <p>Product for sale</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6 ">
                    <div class="ps-block--icon-box"><i class="icon-store"></i>
                        <h4>1.8M</h4>
                        <p>Sellers Active on ABBODA </p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6 ">
                    <div class="ps-block--icon-box"><i class="icon-bag2"></i>
                        <h4>30.6M</h4>
                        <p>Buyer active on ABBODA </p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6 ">
                    <div class="ps-block--icon-box"><i class="icon-cash-dollar"></i>
                        <h4>$2.46M</h4>
                        <p>Annual gross merchandise sales</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--include ../../partials/pages/about-us/milestone-->
<div class="ps-our-team">
    <div class="container">
        <div class="ps-section__header">
            <h3>Meet Our Leaders</h3>
        </div>
        <div class="ps-section__content">
            <figure>
                <div class="ps-block--ourteam"><img src="{{ asset('img/users/our-team/1.jpg') }}" alt="">
                    <div class="ps-block__content">
                        <h4>Robert Downey Jr</h4>
                        <p>CEO Fouder</p>
                        <ul>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </figure>
            <figure>
                <div class="ps-block--ourteam"><img src="{{ asset('img/users/our-team/2.jpg') }}" alt="">
                    <div class="ps-block__content">
                        <h4>Robert Downey Jr</h4>
                        <p>CEO Fouder</p>
                        <ul>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </figure>
            <figure>
                <div class="ps-block--ourteam"><img src=" {{ asset('img/users/our-team/3.jpg') }} "alt="">
                    <div class="ps-block__content">
                        <h4>Robert Downey Jr</h4>
                        <p>CEO Fouder</p>
                        <ul>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </figure>
            <figure>
                <div class="ps-block--ourteam"><img src="{{ asset('img/users/our-team/4.jpg') }}" alt="">
                    <div class="ps-block__content">
                        <h4>Robert Downey Jr</h4>
                        <p>CEO Fouder</p>
                        <ul>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </figure>
            <figure>
                <div class="ps-block--ourteam"><img src=" {{ asset('img/users/our-team/5.jpg') }} "alt="">
                    <div class="ps-block__content">
                        <h4>Robert Downey Jr</h4>
                        <p>CEO Fouder</p>
                        <ul>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </figure>
            <figure>
                <div class="ps-block--ourteam"><img src="{{ asset('img/users/our-team/6.jpg') }}" alt="">
                    <div class="ps-block__content">
                        <h4>Robert Downey Jr</h4>
                        <p>CEO Fouder</p>
                        <ul>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </figure>
            <figure>
                <div class="ps-block--ourteam"><img src="{{ asset('img/users/our-team/7.jpg') }}" alt="">
                    <div class="ps-block__content">
                        <h4>Robert Downey Jr</h4>
                        <p>CEO Fouder</p>
                        <ul>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </figure>
            <figure data-mh="our-team">
                <div class="ps-block--ourteam blank"><a href="#">Become <br> member in <br> team</a></div>
            </figure>
        </div>
    </div>
</div>
<div class="ps-about-awards">
    <div class="container">
        <div class="ps-section__header">
            <h4>Awards & Recognition</h4>
            <p>Industry leaders and influencers recognize Overstock as one of the most trust worthy retail companies in
                the U.S., ranking high for both customer and employee satisfaction.</p>
        </div>
        <div class="ps-section__content">
            <div class="owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="15000" data-owl-gap="0"
                data-owl-nav="false" data-owl-dots="false" data-owl-item="5" data-owl-item-xs="3" data-owl-item-sm="3"
                data-owl-item-md="3" data-owl-item-lg="4" data-owl-duration="1500" data-owl-mousedrag="off"><a
                    href="#"><img src="{{ asset('img/awards/1.png') }}" alt=""></a><a href="#"><img src="img/awards/2.png"
                        alt=""></a><a href="#"><img src="{{ asset('img/awards/3.png') }}" alt=""></a><a href="#"><img
                        src="img/awards/4.png" alt=""></a><a href="#"><img src="{{ asset('img/awards/5.png') }}" alt=""></a></div>
        </div>
    </div>
</div>
@endsection
