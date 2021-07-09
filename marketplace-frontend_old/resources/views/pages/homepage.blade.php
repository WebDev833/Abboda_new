@isset($pageConfigs)
    {!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
$topAreaList = Front::topAreaList()->pluck('name','id');
$topCompanyTypeList = Front::topCompanyTypeList()->pluck('name','id');
@endphp
@extends('layouts.home')
@section('content')

    {{-- <div class="ps-home-ads">
        <div class="ps-container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 "><a class="ps-collection" href="#"><img
                            src="img/collection/home-1/1.jpg" alt=""></a>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 "><a class="ps-collection" href="#"><img
                            src="img/collection/home-1/2.jpg" alt=""></a>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 "><a class="ps-collection" href="#"><img
                            src="img/collection/home-1/3.jpg" alt=""></a>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="ps-top-categories">
        <div class="ps-container">
            <h3>What we Deliver</h3>
            <div class="row">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 ">
                    <div class="ps-block--category"><a class="ps-block__overlay" href="shop-default.html"></a><img
                            src="img/categories/1.jpg" alt="">
                        <p>Electronics</p>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 ">
                    <div class="ps-block--category"><a class="ps-block__overlay" href="shop-default.html"></a><img
                            src="img/categories/2.jpg" alt="">
                        <p>Clothings</p>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 ">
                    <div class="ps-block--category"><a class="ps-block__overlay" href="shop-default.html"></a><img
                            src="img/categories/3.jpg" alt="">
                        <p>Computers</p>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 ">
                    <div class="ps-block--category"><a class="ps-block__overlay" href="shop-default.html"></a><img
                            src="img/categories/4.jpg" alt="">
                        <p>Home & Kitchen</p>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 ">
                    <div class="ps-block--category"><a class="ps-block__overlay" href="shop-default.html"></a><img
                            src="img/categories/5.jpg" alt="">
                        <p>Health & Beauty</p>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 ">
                    <div class="ps-block--category"><a class="ps-block__overlay" href="shop-default.html"></a><img
                            src="img/categories/6.jpg" alt="">
                        <p>Watches</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <div class="ps-section--vendor ps-vendor-milestone roms--home-section-steps">
            <div class="container">
                <div class="ps-section__header">
                    <p>How it works</p>
                    <h4>Easy to start selling online on ABBODA just 4 simple steps</h4>
                </div>
                <div class="ps-section__content">
                    <div class="ps-block--vendor-milestone">
                        <div class="ps-block__left">
                            <h4>Register and list your products</h4>
                            <ul>
                                <li>Register your business for free and create a product catalogue. Get free training on how to run your online business</li>
                                <li>Our ABBODA Advisors will help you at every step and fully assist you in taking your business online</li>
                            </ul>
                        </div>
                        <div class="ps-block__right"><img src="img/vendor/milestone-1.png" alt=""></div>
                        <div class="ps-block__number"><span>1</span></div>
                    </div>
                    <div class="ps-block--vendor-milestone reverse">
                        <div class="ps-block__left">
                            <h4>Receive orders and sell your product</h4>
                            <ul>
                                <li>Register your business for free and create a product catalogue. Get free training on how to run your online business</li>
                                <li>Our ABBODA Advisors will help you at every step and fully assist you in taking your business online</li>
                            </ul>
                        </div>
                        <div class="ps-block__right"><img src="img/vendor/milestone-2.png" alt=""></div>
                        <div class="ps-block__number"><span>2</span></div>
                    </div>
                    <div class="ps-block--vendor-milestone">
                        <div class="ps-block__left">
                            <h4>Package and ship with ease</h4>
                            <ul>
                                <li>Register your business for free and create a product catalogue. Get free training on how to run your online business</li>
                                <li>Our ABBODA Advisors will help you at every step and fully assist you in taking your business online</li>
                            </ul>
                        </div>
                        <div class="ps-block__right"><img src="img/vendor/milestone-3.png" alt=""></div>
                        <div class="ps-block__number"><span>3</span></div>
                    </div>
                    <div class="ps-block--vendor-milestone reverse">
                        <div class="ps-block__left">
                            <h4>Package and ship with ease</h4>
                            <ul>
                                <li>Register your business for free and create a product catalogue. Get free training on how to run your online business</li>
                                <li>Our ABBODA Advisors will help you at every step and fully assist you in taking your business online</li>
                            </ul>
                        </div>
                        <div class="ps-block__right"><img src="img/vendor/milestone-4.png" alt=""></div>
                        <div class="ps-block__number"><span>4</span></div>
                    </div>
                </div>
            </div>
        </div>

    {{-- <div class="ps-product-list ps-clothings">
        <div class="ps-container">
            <div class="ps-section__header">
                <h3>Consumer Electronics</h3>
                <ul class="ps-section__links">
                    <li><a href="shop-grid.html">New Arrivals</a></li>
                    <li><a href="shop-grid.html">Best seller</a></li>
                    <li><a href="shop-grid.html">Must Popular</a></li>
                    <li><a href="shop-grid.html">View All</a></li>
                </ul>
            </div>
            <div class="ps-section__content">
                <div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false"
                    data-owl-speed="10000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="7"
                    data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4"
                    data-owl-item-xl="6" data-owl-duration="1000" data-owl-mousedrag="on">
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/electronic/1.jpg" alt=""></a>
                            <div class="ps-product__badge">-16%</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Go Pro</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Marshall
                                    Kilburn Portable Wireless</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price sale">$567.99 <del>$670.00 </del></p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Marshall Kilburn Portable Wireless</a>
                                <p class="ps-product__price sale">$567.99 <del>$670.00 </del></p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/electronic/2.jpg" alt=""></a>
                            <div class="ps-product__badge hot">hot</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global
                                Office</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Xbox One
                                    Wireless Controller Black Color</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price">$101.99</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Xbox
                                    One Wireless Controller Black Color</a>
                                <p class="ps-product__price">$101.99</p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/electronic/3.jpg" alt=""></a>
                            <div class="ps-product__badge">-25%</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Young Shop</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Sound Intone
                                    I65 Earphone White Version</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>02</span>
                                </div>
                                <p class="ps-product__price sale">$42.00 <del>$60.00 </del></p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Sound
                                    Intone I65 Earphone White Version</a>
                                <p class="ps-product__price sale">$42.00 <del>$60.00 </del></p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/electronic/4.jpg" alt=""></a>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global
                                Office</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Samsung Gear
                                    VR Virtual Reality Headset</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price">$320.00</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Samsung Gear VR Virtual Reality Headset</a>
                                <p class="ps-product__price">$320.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/electronic/5.jpg" alt=""></a>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global
                                Office</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Samsung UHD
                                    TV 24inch</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price">$85.00</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Samsung UHD TV 24inch</a>
                                <p class="ps-product__price">$85.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/electronic/6.jpg" alt=""></a>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global
                                Store</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">EPSION
                                    Plaster Printer</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price">$92.00</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">EPSION
                                    Plaster Printer</a>
                                <p class="ps-product__price">$92.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/electronic/7.jpg" alt=""></a>
                            <div class="ps-product__badge">-46%</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Young Shop</a>
                            <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">LG
                                    White
                                    Front Load Steam Washer</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>02</span>
                                </div>
                                <p class="ps-product__price sale">$42.00 <del>$60.00 </del></p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">LG
                                    White Front Load Steam Washer</a>
                                <p class="ps-product__price sale">$42.00 <del>$60.00 </del></p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/electronic/8.jpg" alt=""></a>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Go Pro</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Edifier
                                    Powered Bookshelf Speakers</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>02</span>
                                </div>
                                <p class="ps-product__price">$42.00</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Edifier Powered Bookshelf Speakers</a>
                                <p class="ps-product__price">$42.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/electronic/9.jpg" alt=""></a>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Go Pro</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Amcrest
                                    Security Camera in White Color</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>02</span>
                                </div>
                                <p class="ps-product__price">$42.00</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Amcrest Security Camera in White Color</a>
                                <p class="ps-product__price">$42.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/electronic/10.jpg" alt=""></a>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Go Pro</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Amcrest
                                    Security Camera in White Color</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>02</span>
                                </div>
                                <p class="ps-product__price">$42.00</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Amcrest Security Camera in White Color</a>
                                <p class="ps-product__price">$42.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ps-product-list ps-clothings">
        <div class="ps-container">
            <div class="ps-section__header">
                <h3>Apparels & Clothings</h3>
                <ul class="ps-section__links">
                    <li><a href="shop-grid.html">New Arrivals</a></li>
                    <li><a href="shop-grid.html">Best seller</a></li>
                    <li><a href="shop-grid.html">Must Popular</a></li>
                    <li><a href="shop-grid.html">View All</a></li>
                </ul>
            </div>
            <div class="ps-section__content">
                <div class="ps-carousel--responsive owl-slider" data-owl-auto="true" data-owl-loop="true"
                    data-owl-speed="10000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="true" data-owl-item="7"
                    data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="2" data-owl-item-lg="4"
                    data-owl-item-xl="6" data-owl-duration="1000" data-owl-mousedrag="on">
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/clothing/1.jpg" alt=""></a>
                            <div class="ps-product__badge">-16%</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Young Shop</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Herschel
                                    Leather Duffle Bag In Brown Color</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price sale">$567.99 <del>$670.00 </del></p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Herschel Leather Duffle Bag In Brown Color</a>
                                <p class="ps-product__price sale">$567.99 <del>$670.00 </del></p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/clothing/2.jpg" alt=""></a>
                            <div class="ps-product__badge out-stock">Out Of Stock</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global
                                Office</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Unero
                                    Military Classical Backpack</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price">$101.99</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Unero
                                    Military Classical Backpack</a>
                                <p class="ps-product__price">$101.99</p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/clothing/3.jpg" alt=""></a>
                            <div class="ps-product__badge">-25%</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Young Shop</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Rayban
                                    Rounded Sunglass Brown Color</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>02</span>
                                </div>
                                <p class="ps-product__price sale">$42.00 <del>$60.00 </del></p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Rayban
                                    Rounded Sunglass Brown Color</a>
                                <p class="ps-product__price sale">$42.00 <del>$60.00 </del></p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/clothing/4.jpg" alt=""></a>
                            <div class="ps-product__badge out-stock">Out Of Stock</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global
                                Office</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Sleeve Linen
                                    Blend Caro Pane Shirt</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price">$320.00</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Sleeve
                                    Linen Blend Caro Pane Shirt</a>
                                <p class="ps-product__price">$320.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/clothing/5.jpg" alt=""></a>
                            <div class="ps-product__badge out-stock">Out Of Stock</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global
                                Office</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Men’s Sports
                                    Runnning Swim Board Shorts</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price">$85.00</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Men’s
                                    Sports Runnning Swim Board Shorts</a>
                                <p class="ps-product__price">$85.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/clothing/6.jpg" alt=""></a>
                            <div class="ps-product__badge out-stock">Out Of Stock</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global
                                Store</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Paul’s Smith
                                    Sneaker InWhite Color</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price">$92.00</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Paul’s
                                    Smith Sneaker InWhite Color</a>
                                <p class="ps-product__price">$92.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/clothing/7.jpg" alt=""></a>
                            <div class="ps-product__badge">-46%</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Young Shop</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">MVMTH
                                    Classical Leather Watch In Black</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>02</span>
                                </div>
                                <p class="ps-product__price sale">$42.00 <del>$60.00 </del></p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">MVMTH
                                    Classical Leather Watch In Black</a>
                                <p class="ps-product__price sale">$42.00 <del>$60.00 </del></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ps-product-list ps-garden-kitchen">
        <div class="ps-container">
            <div class="ps-section__header">
                <h3>Home, Garden & Kitchen</h3>
                <ul class="ps-section__links">
                    <li><a href="shop-grid.html">New Arrivals</a></li>
                    <li><a href="shop-grid.html">Best seller</a></li>
                    <li><a href="shop-grid.html">Must Popular</a></li>
                    <li><a href="shop-grid.html">View All</a></li>
                </ul>
            </div>
            <div class="ps-section__content">
                <div class="ps-carousel--responsive owl-slider" data-owl-auto="true" data-owl-loop="true"
                    data-owl-speed="10000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="true" data-owl-item="7"
                    data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4"
                    data-owl-item-xl="6" data-owl-duration="1000" data-owl-mousedrag="on">
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/home/1.jpg" alt=""></a>
                            <div class="ps-product__badge">-16%</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Young Shop</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Korea Long
                                    Sofa Fabric In Blue Navy Color</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price sale">$567.99 <del>$670.00 </del></p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Korea
                                    Long Sofa Fabric In Blue Navy Color</a>
                                <p class="ps-product__price sale">$567.99 <del>$670.00 </del></p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/home/2.jpg" alt=""></a>
                            <div class="ps-product__badge out-stock">Out Of Stock</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global
                                Office</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Aroma Rice
                                    Cooker</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price">$101.99</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Aroma
                                    Rice Cooker</a>
                                <p class="ps-product__price">$101.99</p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/home/3.jpg" alt=""></a>
                            <div class="ps-product__badge">-25%</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Young Shop</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Simple
                                    Plastice Chair In White Color</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>02</span>
                                </div>
                                <p class="ps-product__price sale">$42.00 <del>$60.00 </del></p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Simple
                                    Plastice Chair In White Color</a>
                                <p class="ps-product__price sale">$42.00 <del>$60.00 </del></p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/home/4.jpg" alt=""></a>
                            <div class="ps-product__badge out-stock">Out Of Stock</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global
                                Office</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Korea Fabric
                                    Chair In Brown Colorr</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price">$320.00</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Korea
                                    Fabric Chair In Brown Colorr</a>
                                <p class="ps-product__price">$320.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/home/5.jpg" alt=""></a>
                            <div class="ps-product__badge out-stock">Out Of Stock</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global
                                Office</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Set 14-Piece
                                    Knife From KichiKit</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price">$85.00</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Set
                                    14-Piece Knife From KichiKit</a>
                                <p class="ps-product__price">$85.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/home/6.jpg" alt=""></a>
                            <div class="ps-product__badge out-stock">Out Of Stock</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global
                                Store</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Magic Bullet
                                    NutriBullet Pro 900 Series
                                    Blender</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>01</span>
                                </div>
                                <p class="ps-product__price">$92.00</p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Magic
                                    Bullet NutriBullet Pro 900 Series
                                    Blender</a>
                                <p class="ps-product__price">$92.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img
                                    src="img/products/home/7.jpg" alt=""></a>
                            <div class="ps-product__badge">-46%</div>
                            <ul class="ps-product__actions">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i
                                            class="icon-bag2"></i></a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal"
                                        data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i
                                            class="icon-heart"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i
                                            class="icon-chart-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">Young Shop</a>
                            <div class="ps-product__content"><a class="ps-product__title"
                                    href="product-default.html">Letter
                                    Printed Cushion Cover Cotton</a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select><span>02</span>
                                </div>
                                <p class="ps-product__price sale">$42.00 <del>$60.00 </del></p>
                            </div>
                            <div class="ps-product__content hover"><a class="ps-product__title"
                                    href="product-default.html">Letter
                                    Printed Cushion Cover Cotton</a>
                                <p class="ps-product__price sale">$42.00 <del>$60.00 </del></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="ps-home-ads">
        <div class="ps-container">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 "><a class="ps-collection" href="#"><img
                            src="img/collection/home-1/ad-1.jpg" alt=""></a>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 "><a class="ps-collection" href="#"><img
                            src="img/collection/home-1/ad-2.jpg" alt=""></a>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
