@php
$catglist = [
[
'id' => 1,
'slug' => url('restaurants'),
'name' => 'Restaurants',
],
[
'id' => 2,
'slug' => url('grocery-stores'),
'name' => 'Grocery Stores',
],
[
'id' => 3,
'slug' => url('medical-stores'),
'name' => 'Medical Stores',
],
];
@endphp
{{-- desk header --}}
<header class="header header--photo" data-sticky="true">
    {{-- logo  --}}
    <a class="ps-logo" href="{{ url('') }}"><img src="{{ asset('images/abboda-logo.png') }}" alt=""></a>
    <div class="header__content">
        {{-- menu --}}
        <ul class="menu">
            <li class="">
                <a href="{{ url('/') }}">Home</a><span class="sub-toggle"></span>
            </li>
            <li class="">
                <a href="{{ route('aboutus') }}">About Us</a><span class="sub-toggle"></span>
            </li>
            <li class="">
                <a href="{{ route('aboutus') }}">Our Services</a><span class="sub-toggle"></span>
            </li>
            <li class="">
                <a href="{{ route('contactus') }}">Contact Us</a><span class="sub-toggle"></span>
            </li>
        </ul>
        {{-- language block --}}
        <div class="header__actions">
            <div class="header__language">
              <i class="icon-network"></i>
                {!! Form::select('language', [
                  'en'=>'English',
                  'ar'=>'Arabic'
                  ], (Session::has('language')) ? Session::get('language') : 'en', ['class'=>'ps-select roms--language','data-url'=>route('switchlang')]) !!}
            </div>
            {{-- cart top block --}}
            <div class="ps-cart--mini">
                <a class="header__extra" href="{{route('cartpage')}}">
                    @auth
                    @if (Auth::user()->userType(5))
                    <i class="icon-bag2"></i><span><i>{{Auth::user()->getCartCount()}}</i></span>
                    @else
                    <i class="icon-bag2"></i><span><i>0</i></span>
                    @endif
                    @endauth
                    @guest
                    <i class="icon-bag2"></i><span><i>0</i></span>
                    @endguest
                </a>
            </div>
            {{-- User top Block --}}
            @auth
            <div class="ps-block--user-header">
                <div class="ps-block__left"><i class="icon-user"></i></div>
                <div class="ps-block__right">
                    @if (Auth::user()->userType(5))
                    <a href="{{route('user.dashboard')}}">Profile</a>
                    @endif
                    @if (Auth::user()->userType(4))
                    <a href="{{route('driver.dashboard')}}">Profile</a>
                    @endif
                    @if (Auth::user()->userType(3))
                    <a href="{{route('manager.dashboard')}}">Profile</a>
                    @endif
                    @if (Auth::user()->userType(2))
                    <a href="{{route('admin.dashboard')}}">Profile</a>
                    @endif
                    / <a href="{{route('logout')}}">logout</a>
                </div>
            </div>
            @endauth
            @guest
            <div class="ps-block--user-header">
                <div class="ps-block__left"><i class="icon-user"></i></div>
                <div class="ps-block__right">
                    <a href="{{route('login')}}">{{ trans('front.top_login_text') }}</a> /
                    <a href="{{route('register')}}">Register</a>
                </div>
            </div>
            @endguest


        </div>
    </div>
</header>
{{-- mobile header --}}
<header class="header header--mobile header--mobile-photo" data-sticky="true">
    <div class="navigation--mobile">
        <div class="navigation__left">
            <a class="ps-logo" href="{{ url('/') }}"><img src="{{ asset('images/abboda-logo.png') }}" alt=""></a>
        </div>
        <div class="navigation__right">
            <div class="header__actions">

                {{-- Only language in th eheader with left logo --}}

                <div class="header__language">
                  {{-- <i class="icon-network"></i> --}}
                    {!! Form::select('language', [
                      'en'=>'English',
                      'ar'=>'Arabic'
                      ], (Session::has('language')) ? Session::get('language') : 'en', ['class'=>'ps-select roms--language','data-url'=>route('switchlang')]) !!}
                </div>
            </div>
        </div>
    </div>
</header>
{{-- <div class="ps-panel--sidebar" id="cart-mobile">
    <div class="ps-panel__header">
        <h3>Shopping Cart</h3>
    </div>
    <div class="navigation__content">
        <div class="ps-cart--mobile">
            <div class="ps-cart__content">
                <div class="ps-product--cart-mobile">
                    <div class="ps-product__thumbnail"><a href="#"><img src="{{ asset('img/products/clothing/7.jpg') }}"
                                alt=""></a>
                    </div>
                    <div class="ps-product__content"><a class="ps-product__remove" href="#"><i
                                class="icon-cross"></i></a><a href="product-default.html">MVMTH Classical Leather Watch
                            In Black</a>
                        <p><strong>Sold by:</strong> YOUNG SHOP</p><small>1 x $59.99</small>
                    </div>
                </div>
            </div>
            <div class="ps-cart__footer">
                <h3>Sub Total:<strong>$59.99</strong></h3>
                <figure><a class="ps-btn" href="shopping-cart.html">View Cart</a><a class="ps-btn"
                        href="checkout.html">Checkout</a></figure>
            </div>
        </div>
    </div>
</div>
</div> --}}
<div class="ps-panel--sidebar" id="roms--user-sidebar-mobile">
    <div class="ps-panel__header">
        <h3>{{ trans('front.user_area_mobile_text') }}</h3>
    </div>
    <div class="ps-panel__content">
        <ul class="menu--mobile">
            @auth
            @if (Auth::user()->userType(5))
            <li class="current-menu-item "><a href="{{route('user.dashboard')}}">Profile</a></li>
            @endif            
            @if (Auth::user()->userType(4))
            <li class="current-menu-item "><a href="{{route('driver.dashboard')}}">Profile</a></li>
            @endif            
            @if (Auth::user()->userType(3))
            <li class="current-menu-item "><a href="{{route('manager.dashboard')}}">Profile</a></li>
            @endif
            @if (Auth::user()->userType(2))
            <li class="current-menu-item "><a href="{{route('admin.dashboard')}}">Profile</a></li>
            @endif
            <li class="current-menu-item "><a href="{{route('logout')}}">logout</a></li>
            @endauth
            @guest
            <li class="current-menu-item "><a href="{{route('login')}}">Login</a></li>
            <li class="current-menu-item "><a href="{{route('register')}}">Register</a></li>
            @endguest
        </ul>
    </div>
</div>
<div class="ps-panel--sidebar" id="roms--categories-sidebar-mobile">
    <div class="ps-panel__header">
        <h3>{{ trans('front.shop_by_department') }}</h3>
    </div>
    <div class="ps-panel__content">
        <ul class="menu--mobile">
            @foreach ($catglist as $item)
            <li class="current-menu-item "><a href="{{$item['slug']}}">{{$item['name']}}</a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<!--include search-sidebar-->
<div class="ps-panel--sidebar" id="menu-mobile">
    <div class="ps-panel__header">
        <h3>Menu</h3>
    </div>
    <div class="ps-panel__content">
        <ul class="menu--mobile">
          <li class="">
            <a href="{{ url('/') }}">Home</a>
          </li>
          <li class="">
            <a href="{{ route('aboutus') }}">About Us</a>
          </li>
          <li class="">
            <a href="{{ route('aboutus') }}">Our Services</a>
          </li>
          <li class="">
            <a href="{{ route('contactus') }}">Contact Us</a>
          </li>            
        </ul>
    </div>
</div>
<div class="navigation--list">
    <div class="navigation__content">
        <a class="navigation__item ps-toggle--sidebar" href="#menu-mobile">
            <i class="icon-menu"></i><span> {{ trans('front.menu_text') }}</span></a>
        <a class="navigation__item ps-toggle--sidebar" href="#roms--categories-sidebar-mobile">
            <i class="icon-list4"></i><span> {{ trans('front.categories_text') }}</span></a>
        <a class="navigation__item" href="{{route('cartpage')}}">
            <i class="icon-bag2"></i>
            <span> {{ trans('front.cart_text') }}</span></a>

        <a class="navigation__item ps-toggle--sidebar" href="#roms--user-sidebar-mobile">
            <i class="icon-user"></i><span> {{ trans('front.user_text') }}</span></a>

    </div>
</div>


@php
return true;
@endphp

<header class="header header--roms" data-sticky="true">
    <div class="header__top">
        <div class="ps-container">
            <div class="header__left">
                <div class="menu--product-categories">
                    <div class="menu__toggle"><i class="icon-menu"></i><span>
                            {{ trans('front.shop_by_department') }}</span></div>
                    <div class="menu__content">
                        <ul class="menu--dropdown">
                            @isset($topCompanyTypeList)
                            @foreach($topCompanyTypeList as $name)
                            <li class="current-menu-item"><a href="{{ str_replace(' ','-',Str::lower($name)) }}"><i
                                        class="icon-star"></i>{{ $name }}</a>
                            </li>
                            @endforeach
                            @endisset
                        </ul>
                    </div>
                </div><a class="ps-logo" href="{{ url('') }}"><img src="{{ asset('images/abboda-logo.png') }}"
                        alt=""></a>
            </div>
            <div class="header__center">
                {{ Form::open(array('route' => 'search','class'=>'ps-form--quick-search','method'=>'GET')) }}
                <div class="form-group--icon">
                    <i class="icon-chevron-down"></i>
                    <span class="wsg-serach-label">{{ trans('front.select_area') }}</span>
                    {!! Form::select('area', $topAreaList, NULL, [
                    'class' => 'form-control',
                    'required' => 'required',
                    ]) !!}
                </div>
                <div class="form-group--icon">
                    <i class="icon-chevron-down"></i>
                    <span class="wsg-serach-label">{{ trans('front.select_comptype') }}</span>
                    {!! Form::select('type', $topCompanyTypeList, NULL, [
                    'class' => 'form-control',
                    'required' => 'required',
                    ]) !!}
                </div>
                {{-- <div class="form-group-keyword">
                      <span class="wsg-serach-label">Enter your Keyword</span>
                      <input class="form-control" type="text" placeholder="Enter your keyword..." required="required" >
                    </div> --}}

                <input class="form-control" type="text" name="keyword"
                    placeholder="{{ trans('front.enter_your_keyword') }}">
                <button>{{ trans('front.search_botton_text') }}</button>
                {!! Form::close() !!}
            </div>
            <div class="header__right">
                <div class="header__actions">
                    {{-- <a class="header__extra" href="#"><i
                            class="icon-chart-bars"></i><span><i>0</i></span></a>
                  <a class="header__extra"
                        href="#"><i class="icon-heart"></i><span><i>0</i></span></a> --}}
                    <div class="ps-cart--mini"><a class="header__extra" href="{{ route('cartpage') }}"><i
                                class="icon-bag2"></i><span><i>0</i></span></a>
                        {{-- <div class="ps-cart__content">
                            <div class="ps-cart__items">
                                <div class="ps-product--cart-mobile">
                                    <div class="ps-product__thumbnail"><a href="#"><img
                                                src="img/products/clothing/7.jpg" alt=""></a>
                                    </div>
                                    <div class="ps-product__content"><a class="ps-product__remove" href="#"><i
                                                class="icon-cross"></i></a><a href="product-default.html">MVMTH
                                            Classical Leather Watch In Black</a>
                                        <p><strong>Sold by:</strong> YOUNG SHOP</p><small>1 x $59.99</small>
                                    </div>
                                </div>
                                <div class="ps-product--cart-mobile">
                                    <div class="ps-product__thumbnail"><a href="#"><img
                                                src="img/products/clothing/5.jpg" alt=""></a>
                                    </div>
                                    <div class="ps-product__content"><a class="ps-product__remove" href="#"><i
                                                class="icon-cross"></i></a><a href="product-default.html">Sleeve
                                            Linen Blend Caro Pane Shirt</a>
                                        <p><strong>Sold by:</strong> YOUNG SHOP</p><small>1 x $59.99</small>
                                    </div>
                                </div>
                            </div>
                            <div class="ps-cart__footer">
                                <h3>Sub Total:<strong>$59.99</strong></h3>
                                <figure><a class="ps-btn" href="shopping-cart.html">View Cart</a><a
                                        class="ps-btn" href="checkout.html">Checkout</a></figure>
                            </div>
                        </div> --}}
                    </div>
                    <div class="ps-block--user-header">
                        <div class="ps-block__left"><i class="icon-user"></i></div>
                        <div class="ps-block__right"><a href="my-account.html">{{ trans('front.top_login_text') }}</a><a
                                href="my-account.html">{{ trans('front.top_register_text') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navigation">
        <div class="ps-container">
            <div class="navigation__left">
                <div class="menu--product-categories">
                    <div class="menu__toggle"><i class="icon-menu"></i><span>
                            {{ trans('front.shop_by_department') }}</span></div>
                    <div class="menu__content">
                        <ul class="menu--dropdown">
                            @isset($topCompanyTypeList)
                            @foreach($topCompanyTypeList as $name)
                            <li class="current-menu-item"><a href="{{ str_replace(' ','-',Str::lower($name)) }}"><i
                                        class="icon-star"></i>{{ $name }}</a>
                            </li>
                            @endforeach
                            @endisset
                        </ul>
                    </div>
                </div>
            </div>
            <div class="navigation__right">
                <ul class="menu">
                    <li class=""><a href="{{ url('') }}">Home</a><span class="sub-toggle"></span>
                    </li>
                    <li class=""><a href="{{ route('aboutus') }}">About Us</a><span class="sub-toggle"></span>
                    </li>
                    <li class=""><a href="{{ route('ourservices') }}">Our Services</a><span class="sub-toggle"></span>
                    </li>


                    <li class=""><a href="{{ route('contactus') }}">Contact Us</a><span class="sub-toggle"></span>
                    </li>
                </ul>
                <ul class="navigation__extra">
                    <li><a href="#">{{ trans('front.become_a_partner') }}</a></li>
                    <li><a href="#">{{ trans('front.welcome_to_abboda') }}</a></li>
                    {{-- <li>
                        <div class="ps-dropdown"><a href="#">US Dollar</a>
                            <ul class="ps-dropdown-menu">
                                <li><a href="#">Us Dollar</a></li>
                                <li><a href="#">Euro</a></li>
                            </ul>
                        </div>
                    </li> --}}
                    <li>
                        <div class="ps-dropdown language"><a href="#"><img src="{{ asset('img/flag/en.png') }}"
                                    alt="">English</a>
                            <ul class="ps-dropdown-menu">
                                <li><a href="#"><img src="{{ asset('img/flag/germany.png') }}" alt=""> Germany</a></li>
                                <li><a href="#"><img src="{{ asset('img/flag/fr.png') }}" alt=""> Arabic</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<header class="header header--mobile roms" data-sticky="true">
    <div class="header__top">
        <div class="header__left">
            <p>Welcome to ABBODA Online Shopping Store !</p>
        </div>
        <div class="header__right">
            <ul class="navigation__extra">
                <li><a href="#">{{ trans('front.become_a_partner') }}</a></li>
                <li><a href="#">Welcome to ABBODA</a></li>
                {{-- <li>
                    <div class="ps-dropdown"><a href="#">US Dollar</a>
                        <ul class="ps-dropdown-menu">
                            <li><a href="#">Us Dollar</a></li>
                            <li><a href="#">Euro</a></li>
                        </ul>
                    </div>
                </li> --}}
                <li>
                    <div class="ps-dropdown language"><a href="#"><img src="{{ asset('img/flag/en.png') }}"
                                alt="">English</a>
                        <ul class="ps-dropdown-menu">
                            <li><a href="#"><img src="{{ asset('img/flag/germany.png') }}" alt=""> Germany</a></li>
                            <li><a href="#"><img src="{{ asset('img/flag/fr.png') }}" alt=""> Arabic</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="navigation--mobile">
        <div class="navigation__left"><a class="ps-logo" href="{{ url('') }}"><img
                    src="{{ asset('img/logo_light.png') }}" alt=""></a>
        </div>
        <div class="navigation__right">
            <div class="header__actions">
                <div class="ps-cart--mini"><a class="header__extra" href="#"><i
                            class="icon-bag2"></i><span><i>0</i></span></a>
                    <div class="ps-cart__content">
                        <div class="ps-cart__items">
                            <div class="ps-product--cart-mobile">
                                <div class="ps-product__thumbnail"><a href="#"><img src="img/products/clothing/7.jpg"
                                            alt=""></a>
                                </div>
                                <div class="ps-product__content"><a class="ps-product__remove" href="#"><i
                                            class="icon-cross"></i></a><a href="product-default.html">MVMTH
                                        Classical Leather Watch In Black</a>
                                    <p><strong>Sold by:</strong> YOUNG SHOP</p><small>1 x $59.99</small>
                                </div>
                            </div>
                            <div class="ps-product--cart-mobile">
                                <div class="ps-product__thumbnail"><a href="#"><img src="img/products/clothing/5.jpg"
                                            alt=""></a>
                                </div>
                                <div class="ps-product__content"><a class="ps-product__remove" href="#"><i
                                            class="icon-cross"></i></a><a href="product-default.html">Sleeve
                                        Linen Blend Caro Pane Shirt</a>
                                    <p><strong>Sold by:</strong> YOUNG SHOP</p><small>1 x $59.99</small>
                                </div>
                            </div>
                        </div>
                        <div class="ps-cart__footer">
                            <h3>Sub Total:<strong>$59.99</strong></h3>
                            <figure><a class="ps-btn" href="shopping-cart.html">View Cart</a><a class="ps-btn"
                                    href="checkout.html">Checkout</a></figure>
                        </div>
                    </div>
                </div>
                <div class="ps-block--user-header">
                    <div class="ps-block__left"><i class="icon-user"></i></div>
                    <div class="ps-block__right"><a href="my-account.html">Login</a><a
                            href="my-account.html">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ps-search--mobile">
        <form class="ps-form--search-mobile" action="https://www.websoftgeeks.com/html/martfury/{{ url('') }}"
            method="get">
            <div class="form-group--nest">
                <input class="form-control" type="text" placeholder="Search something...">
                <button><i class="icon-magnifier"></i></button>
            </div>
        </form>
    </div>
</header>
<div class="ps-panel--sidebar" id="cart-mobile">
    <div class="ps-panel__header">
        <h3>Shopping Cart</h3>
    </div>
    <div class="navigation__content">
        <div class="ps-cart--mobile">
            <div class="ps-cart__content">
                <div class="ps-product--cart-mobile">
                    <div class="ps-product__thumbnail"><a href="#"><img src="{{ asset('img/products/clothing/7.jpg') }}"
                                alt=""></a>
                    </div>
                    <div class="ps-product__content"><a class="ps-product__remove" href="#"><i
                                class="icon-cross"></i></a><a href="product-default.html">MVMTH Classical
                            Leather Watch In Black</a>
                        <p><strong>Sold by:</strong> YOUNG SHOP</p><small>1 x $59.99</small>
                    </div>
                </div>
            </div>
            <div class="ps-cart__footer">
                <h3>Sub Total:<strong>$59.99</strong></h3>
                <figure><a class="ps-btn" href="shopping-cart.html">View Cart</a><a class="ps-btn"
                        href="checkout.html">Checkout</a></figure>
            </div>
        </div>
    </div>
</div>
<div class="ps-panel--sidebar" id="navigation-mobile">
    <div class="ps-panel__header">
        <h3>Categories</h3>
    </div>
    <div class="ps-panel__content">
        <ul class="menu--mobile">
            <li class="current-menu-item "><a href="#">Hot Promotions</a>
            </li>
            <li class="current-menu-item menu-item-has-children has-mega-menu"><a href="#">Consumer
                    Electronic</a><span class="sub-toggle"></span>
                <div class="mega-menu">
                    <div class="mega-menu__column">
                        <h4>Electronic<span class="sub-toggle"></span></h4>
                        <ul class="mega-menu__list">
                            <li class="current-menu-item "><a href="#">Home Audio &amp; Theathers</a>
                            </li>
                            <li class="current-menu-item "><a href="#">TV &amp; Videos</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Camera, Photos &amp; Videos</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Cellphones &amp; Accessories</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Headphones</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Videosgames</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Wireless Speakers</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Office Electronic</a>
                            </li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <h4>Accessories &amp; Parts<span class="sub-toggle"></span></h4>
                        <ul class="mega-menu__list">
                            <li class="current-menu-item "><a href="#">Digital Cables</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Audio &amp; Video Cables</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Batteries</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="current-menu-item "><a href="#">Clothing &amp; Apparel</a>
            </li>
            <li class="current-menu-item "><a href="#">Home, Garden &amp; Kitchen</a>
            </li>
            <li class="current-menu-item "><a href="#">Health &amp; Beauty</a>
            </li>
            <li class="current-menu-item "><a href="#">Yewelry &amp; Watches</a>
            </li>
            <li class="current-menu-item menu-item-has-children has-mega-menu"><a href="#">Computer &amp;
                    Technology</a><span class="sub-toggle"></span>
                <div class="mega-menu">
                    <div class="mega-menu__column">
                        <h4>Computer &amp; Technologies<span class="sub-toggle"></span></h4>
                        <ul class="mega-menu__list">
                            <li class="current-menu-item "><a href="#">Computer &amp; Tablets</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Laptop</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Monitors</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Networking</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Drive &amp; Storages</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Computer Components</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Security &amp; Protection</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Gaming Laptop</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Accessories</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="current-menu-item "><a href="#">Babies &amp; Moms</a>
            </li>
            <li class="current-menu-item "><a href="#">Sport &amp; Outdoor</a>
            </li>
            <li class="current-menu-item "><a href="#">Phones &amp; Accessories</a>
            </li>
            <li class="current-menu-item "><a href="#">Books &amp; Office</a>
            </li>
            <li class="current-menu-item "><a href="#">Cars &amp; Motocycles</a>
            </li>
            <li class="current-menu-item "><a href="#">Home Improments</a>
            </li>
            <li class="current-menu-item "><a href="#">Vouchers &amp; Services</a>
            </li>
        </ul>
    </div>
</div>
<div class="navigation--list">
    <div class="navigation__content"><a class="navigation__item ps-toggle--sidebar" href="#menu-mobile"><i
                class="icon-menu"></i><span> Menu</span></a><a class="navigation__item ps-toggle--sidebar"
            href="#navigation-mobile"><i class="icon-list4"></i><span> Categories</span></a><a
            class="navigation__item ps-toggle--sidebar" href="#search-sidebar"><i class="icon-magnifier"></i><span>
                Search</span></a><a class="navigation__item ps-toggle--sidebar" href="#cart-mobile"><i
                class="icon-bag2"></i><span>
                Cart</span></a></div>
</div>
<div class="ps-panel--sidebar" id="search-sidebar">
    <div class="ps-panel__header">
        <form class="ps-form--search-mobile" action="https://www.websoftgeeks.com/html/martfury/{{ url('') }}"
            method="get">
            <div class="form-group--nest">
                <input class="form-control" type="text" placeholder="Search something...">
                <button><i class="icon-magnifier"></i></button>
            </div>
        </form>
    </div>
    <div class="navigation__content"></div>
</div>
<div class="ps-panel--sidebar" id="menu-mobile">
    <div class="ps-panel__header">
        <h3>Menu</h3>
    </div>
    <div class="ps-panel__content">
        <ul class="menu--mobile">
            <li class="menu-item-has-children"><a href="{{ url('') }}">Home</a><span class="sub-toggle"></span>
                <ul class="sub-menu">
                    <li class="current-menu-item "><a href="{{ url('') }}">Marketplace Full Width</a>
                    </li>
                    <li class="current-menu-item "><a href="homepage-2.html">Home Auto Parts</a>
                    </li>
                    <li class="current-menu-item "><a href="homepage-10.html">Home Technology</a>
                    </li>
                    <li class="current-menu-item "><a href="homepage-9.html">Home Organic</a>
                    </li>
                    <li class="current-menu-item "><a href="homepage-3.html">Home Marketplace V1</a>
                    </li>
                    <li class="current-menu-item "><a href="homepage-4.html">Home Marketplace V2</a>
                    </li>
                    <li class="current-menu-item "><a href="homepage-5.html">Home Marketplace V3</a>
                    </li>
                    <li class="current-menu-item "><a href="homepage-6.html">Home Marketplace V4</a>
                    </li>
                    <li class="current-menu-item "><a href="homepage-7.html">Home Electronic</a>
                    </li>
                    <li class="current-menu-item "><a href="homepage-8.html">Home Furniture</a>
                    </li>
                    <li class="current-menu-item "><a href="homepage-kids.html">Home Kids</a>
                    </li>
                    <li class="current-menu-item "><a href="homepage-photo-and-video.html">Home photo and
                            picture</a>
                    </li>
                </ul>
            </li>
            <li class="menu-item-has-children has-mega-menu"><a href="shop-default.html">Shop</a><span
                    class="sub-toggle"></span>
                <div class="mega-menu">
                    <div class="mega-menu__column">
                        <h4>Catalog Pages<span class="sub-toggle"></span></h4>
                        <ul class="mega-menu__list">
                            <li class="current-menu-item "><a href="shop-default.html">Shop Default</a>
                            </li>
                            <li class="current-menu-item "><a href="shop-default.html">Shop Fullwidth</a>
                            </li>
                            <li class="current-menu-item "><a href="shop-categories.html">Shop Categories</a>
                            </li>
                            <li class="current-menu-item "><a href="shop-sidebar.html">Shop Sidebar</a>
                            </li>
                            <li class="current-menu-item "><a href="shop-sidebar-without-banner.html">Shop
                                    Without Banner</a>
                            </li>
                            <li class="current-menu-item "><a href="shop-carousel.html">Shop Carousel</a>
                            </li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <h4>Product Layout<span class="sub-toggle"></span></h4>
                        <ul class="mega-menu__list">
                            <li class="current-menu-item "><a href="product-default.html">Default</a>
                            </li>
                            <li class="current-menu-item "><a href="product-extend.html">Extended</a>
                            </li>
                            <li class="current-menu-item "><a href="product-full-content.html">Full Content</a>
                            </li>
                            <li class="current-menu-item "><a href="product-box.html">Boxed</a>
                            </li>
                            <li class="current-menu-item "><a href="product-sidebar.html">Sidebar</a>
                            </li>
                            <li class="current-menu-item "><a href="product-default.html">Fullwidth</a>
                            </li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <h4>Product Types<span class="sub-toggle"></span></h4>
                        <ul class="mega-menu__list">
                            <li class="current-menu-item "><a href="product-default.html">Simple</a>
                            </li>
                            <li class="current-menu-item "><a href="product-default.html">Color Swatches</a>
                            </li>
                            <li class="current-menu-item "><a href="product-image-swatches.html">Images
                                    Swatches</a>
                            </li>
                            <li class="current-menu-item "><a href="product-countdown.html">Countdown</a>
                            </li>
                            <li class="current-menu-item "><a href="product-multi-vendor.html">Multi-Vendor</a>
                            </li>
                            <li class="current-menu-item "><a href="product-instagram.html">Instagram</a>
                            </li>
                            <li class="current-menu-item "><a href="product-affiliate.html">Affiliate</a>
                            </li>
                            <li class="current-menu-item "><a href="product-on-sale.html">On sale</a>
                            </li>
                            <li class="current-menu-item "><a href="product-video.html">Video Featured</a>
                            </li>
                            <li class="current-menu-item "><a href="product-groupped.html">Grouped</a>
                            </li>
                            <li class="current-menu-item "><a href="product-out-stock.html">Out Of Stock</a>
                            </li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <h4>Woo Pages<span class="sub-toggle"></span></h4>
                        <ul class="mega-menu__list">
                            <li class="current-menu-item "><a href="shopping-cart.html">Shopping Cart</a>
                            </li>
                            <li class="current-menu-item "><a href="checkout.html">Checkout</a>
                            </li>
                            <li class="current-menu-item "><a href="whishlist.html">Whishlist</a>
                            </li>
                            <li class="current-menu-item "><a href="compare.html">Compare</a>
                            </li>
                            <li class="current-menu-item "><a href="order-tracking.html">Order Tracking</a>
                            </li>
                            <li class="current-menu-item "><a href="my-account.html">My Account</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="menu-item-has-children has-mega-menu"><a href="#">Pages</a><span class="sub-toggle"></span>
                <div class="mega-menu">
                    <div class="mega-menu__column">
                        <h4>Basic Page<span class="sub-toggle"></span></h4>
                        <ul class="mega-menu__list">
                            <li class="current-menu-item "><a href="about-us.html">About Us</a>
                            </li>
                            <li class="current-menu-item "><a href="contact-us.html">Contact</a>
                            </li>
                            <li class="current-menu-item "><a href="faqs.html">Faqs</a>
                            </li>
                            <li class="current-menu-item "><a href="comming-soon.html">Comming Soon</a>
                            </li>
                            <li class="current-menu-item "><a href="404-page.html">404 Page</a>
                            </li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <h4>Vendor Pages<span class="sub-toggle"></span></h4>
                        <ul class="mega-menu__list">
                            <li class="current-menu-item "><a href="become-a-vendor.html">Become a Vendor</a>
                            </li>
                            <li class="current-menu-item "><a href="vendor-store.html">Vendor Store</a>
                            </li>
                            <li class="current-menu-item "><a href="vendor-dashboard-free.html">Vendor Dashboard
                                    Free</a>
                            </li>
                            <li class="current-menu-item "><a href="vendor-dashboard-pro.html">Vendor Dashboard
                                    Pro</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="menu-item-has-children has-mega-menu"><a href="#">Blogs</a><span class="sub-toggle"></span>
                <div class="mega-menu">
                    <div class="mega-menu__column">
                        <h4>Blog Layout<span class="sub-toggle"></span></h4>
                        <ul class="mega-menu__list">
                            <li class="current-menu-item "><a href="blog-grid.html">Grid</a>
                            </li>
                            <li class="current-menu-item "><a href="blog-list.html">Listing</a>
                            </li>
                            <li class="current-menu-item "><a href="blog-small-thumb.html">Small Thumb</a>
                            </li>
                            <li class="current-menu-item "><a href="blog-left-sidebar.html">Left Sidebar</a>
                            </li>
                            <li class="current-menu-item "><a href="blog-right-sidebar.html">Right Sidebar</a>
                            </li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <h4>Single Blog<span class="sub-toggle"></span></h4>
                        <ul class="mega-menu__list">
                            <li class="current-menu-item "><a href="blog-detail.html">Single 1</a>
                            </li>
                            <li class="current-menu-item "><a href="blog-detail-2.html">Single 2</a>
                            </li>
                            <li class="current-menu-item "><a href="blog-detail-3.html">Single 3</a>
                            </li>
                            <li class="current-menu-item "><a href="blog-detail-4.html">Single 4</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
