<!-- Sidemenu -->
<div class="main-sidebar main-sidebar-sticky side-menu">
  <div class="sidemenu-logo">
    <a class="main-logo" href="{{route('admin.dashboard')}}">
      <img src="{!!$adminLogo ?? ''!!}" class="header-brand-img desktop-logo h-auto" alt="Abboda">
      {{-- <img src="{{asset('admin-assets/images/abboda-logo.png')}}" class="header-brand-img desktop-logo h-auto" alt="logo"> --}}
      <img src="{!!$iconLogo ?? ''!!}" class="header-brand-img icon-logo" alt="Abboda">
      {{-- <img src="{{asset('admin-assets/img/brand/logo-light.png')}}" class="header-brand-img desktop-logo theme-logo" alt="logo">
      <img src="{{asset('admin-assets/img/brand/icon-light.png')}}" class="header-brand-img icon-logo theme-logo" alt="logo"> --}}
    </a>
  </div>
  <div class="main-sidebar-body">
    <ul class="nav">
      <li class="nav-label">Dashboard</li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.dashboard')}}"><i class="fe fe-airplay"></i><span class="sidemenu-label">Dashboard</span></a>
      </li>
      <li class="nav-label">Media</li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.medias')}}"><i class="fe fe-camera"></i><span class="sidemenu-label">Media Library</span></a>
      </li>
     {{-- <li class="nav-label">Content</li>
      <li class="nav-item">
        <a class="nav-link with-sub" href="#"><i class="fe fe-box"></i><span class="sidemenu-label">Dynamic Pages</span><i class="angle fe fe-chevron-right"></i></a>
        <ul class="nav-sub">
          <li class="nav-sub-item">
            <a class="nav-sub-link" href="{{route('admin.addpage')}}">Create Page</a>
          </li>
          <li class="nav-sub-item">
            <a class="nav-sub-link" href="{{route('admin.allpages')}}">All Pages</a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.allstaticpages')}}"><i class="fe fe-award"></i><span class="sidemenu-label">Static Pages</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link with-sub" href="#"><i class="fe fe-box"></i><span class="sidemenu-label">Page Sections</span><i class="angle fe fe-chevron-right"></i></a>
        <ul class="nav-sub">
          <li class="nav-sub-item">
            <a class="nav-sub-link" href="{{route('admin.addsection')}}">Create Section</a>
          </li>
          <li class="nav-sub-item">
            <a class="nav-sub-link" href="{{route('admin.allsections')}}">All Sections</a>
          </li>
        </ul>
      </li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.widgets.index')}}"><i class="fe fe-airplay"></i><span class="sidemenu-label">Widgets</span></a>
      </li>--}}
      {{-- <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.menus')}}"><i class="fe fe-airplay"></i><span class="sidemenu-label">Menus</span></a>
      </li> --}}
      <li class="nav-label">Users</li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.managers')}}"><i class="fe fe-user"></i><span class="sidemenu-label">Managers</span></a>
      </li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.drivers')}}"><i class="fe fe-user"></i><span class="sidemenu-label">Drivers</span></a>
      </li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.customers')}}"><i class="fe fe-user"></i><span class="sidemenu-label">Customers</span></a>
      </li>
      <li class="nav-label">Region</li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.areas')}}"><i class="fe fe-map-pin"></i><span class="sidemenu-label">Areas</span></a>
      </li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.areamanagers')}}"><i class="fe fe-users"></i><span class="sidemenu-label">Area Managers</span></a>
      </li>
      <li class="nav-label">Marketplace</li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.merchants')}}"><i class="fe fe-briefcase"></i><span class="sidemenu-label">Merchants</span></a>
      </li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.categories')}}"><i class="fe fe-grid"></i><span class="sidemenu-label">Categories</span></a>
      </li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.workdays')}}"><i class="fe fe-clock"></i><span class="sidemenu-label">Workdays</span></a>
      </li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.products')}}"><i class="fe fe-box"></i><span class="sidemenu-label">Products</span></a>
      </li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.orders')}}"><i class="fe fe-shopping-cart"></i><span class="sidemenu-label">Orders</span></a>
      </li>
      {{-- <li class="nav-label">Finance</li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.transactions.index')}}"><i class="fe fe-dollar-sign"></i><span class="sidemenu-label">Transactions</span></a>
      </li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.settlements.index')}}"><i class="fe fe-pocket"></i><span class="sidemenu-label">Order Settlements</span></a>
      </li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.onlinepayments')}}"><i class="icon ion-md-cash"></i><span class="sidemenu-label">Online Payments</span></a>
      </li> --}}
      <li class="nav-label">Settings</li>
      <li class="nav-item show">
        <a class="nav-link" href="{{route('admin.frontsettings')}}"><i class="fe fe-settings"></i><span class="sidemenu-label">Front Settings</span></a>
      </li>
    </ul>
  </div>
</div>
<!-- End Sidemenu -->
