 @auth

            @if (Auth::user()->userType(5))
            
            <li class="current-menu-item ">
            <a href="{{route('user.editProfilepage')}}">
            <span class="custom-icon"><img src="{{asset('images/icon/fa-user.png')}}"></span>
                 Profile
            </a>
            </li>

            <li class="current-menu-item "><a href="{{route('user.myorders')}}">
                <span class="custom-icon"><img src="{{asset('images/icon/fa-list-alt.png')}}"></span> My Orders</a>
            </li>
            
            <li class="current-menu-item "><a href="{{route('user.addressBook')}}"><span class="custom-icon"><img src="{{asset('images/icon/fa-location.png')}}"></span>Address Book</a></li>
            
             <!-- <li class="current-menu-item "><a href="{{route('user.dashboard')}}"><i class="fa fa-columns"></i> Dashboard</a></li> -->
            @endif            
            @if (Auth::user()->userType(4))
             <li class="current-menu-item "><a href="{{route('driver.editProfilepage')}}"><span class="custom-icon"><img src="{{asset('images/icon/fa-user.png')}}"></span> Profile</a></li>
             <li class="current-menu-item "><a href="{{route('driver.myorders')}}"><span class="custom-icon"><img src="{{asset('images/icon/fa-list-alt.png')}}"></span> My Order</a></li>
             <li class="current-menu-item "><a href="{{route('driver.myearnings')}}"><i class="fa fa-money custom-icon"></i> My Earnings</a></li>
            <li class="current-menu-item "><a href="{{route('driver.dashboard')}}"><i class="fa fa-columns custom-icon"></i> Dashboard</a></li>
            @endif            
            @if (Auth::user()->userType(3))
            <li class="current-menu-item "><a href="{{route('manager.editProfilepage')}}"><span class="custom-icon"><img src="{{asset('images/icon/fa-user.png')}}"></span> Profile</a></li>

            <li class="current-menu-item "><a href="{{route('manager.myorders')}}"><img src="{{asset('images/icon/fa-list-alt.png')}}"></span> My Order</a></li>
            <li class="current-menu-item "><a href="{{route('manager.ordersettlements')}}"><i class="fa fa-list-alt custom-icon"></i> Order Settlements</a></li>
             <li class="current-menu-item "><a href="{{route('manager.transactions')}}"><i class="fa fa-money custom-icon"></i> My Transactions</a></li>
             
            <li class="current-menu-item "><a href="{{route('manager.dashboard')}}"><i class="fa fa-columns custom-icon"></i> Dashboard</a></li>
            @endif
            @if (Auth::user()->userType(2))
            <li class="current-menu-item "><a href="{{route('admin.dashboard')}}"><i class="fa fa-columns custom-icon"></i> Admin</a></li>
            @endif
            <li class="current-menu-item "><a href="{{route('logout')}}"><span class="fa fa-sign-out custom-icon"></span> Sign Out</a></li>
            @endauth
            
          

        @if($menu->count())
         @foreach ($menu as $page)
         @if(strtolower($page['slug:'.App::getLocale()]) !='home')
         <li class="">
            <a href="{!!url($page['slug:'.App::getLocale()])!!}">{!! Admin::stringColumn($page['title:'.App::getLocale()]) !!}</a>
        </li>
        @endif
         @endforeach
        @endif