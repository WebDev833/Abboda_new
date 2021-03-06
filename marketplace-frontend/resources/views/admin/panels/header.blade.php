<!-- Main Header-->
<div class="main-header side-header sticky">
  <div class="container-fluid">
    <div class="main-header-left">
      <a class="main-logo d-lg-none" href="{{route('admin.dashboard')}}">
      <img src="{{asset('admin-assets/images/abboda-logo.png')}}" class="header-brand-img desktop-logo" alt="logo">
      <img src="{{asset('admin-assets/images/icon.png')}}" class="header-brand-img icon-logo" alt="logo">
      </a>
      <a class="main-header-menu-icon" href="#" id="mainSidebarToggle"><span></span></a>
    </div>
    <div class="main-header-right">
      {{-- <div class="dropdown d-md-flex header-search">
        <a class="nav-link icon header-search">
          <i class="fe fe-search"></i>
        </a>
        <div class="dropdown-menu">
          <div class="main-form-search p-2">
            <input class="form-control" placeholder="Search" type="search">
            <button class="btn"><i class="fe fe-search"></i></button>
          </div>
        </div>
      </div> --}}
      <div class="dropdown d-md-flex">
        <a class="nav-link icon full-screen-link">
          <i class="fe fe-maximize fullscreen-button"></i>
        </a>
      </div>
      {{-- <div class="dropdown main-header-notification">
        <a class="nav-link icon" href="#">
          <i class="fe fe-bell"></i>
          <span class="pulse bg-danger"></span>
        </a>
        <div class="dropdown-menu">
          <div class="header-navheading">
            <p class="main-notification-text">You have 1 unread notification<span class="badge badge-pill badge-primary ml-3">View all</span></p>
          </div>
          <div class="main-notification-list">
            <div class="media new">
              <div class="main-img-user online"><img alt="avatar" src="assets/img/users/5.jpg"></div>
              <div class="media-body">
                <p>Congratulate <strong>Olivia James</strong> for New template start</p><span>Oct 15 12:32pm</span>
              </div>
            </div>
            <div class="media">
              <div class="main-img-user"><img alt="avatar" src="assets/img/users/2.jpg"></div>
              <div class="media-body">
                <p><strong>Joshua Gray</strong> New Message Received</p><span>Oct 13 02:56am</span>
              </div>
            </div>
            <div class="media">
              <div class="main-img-user online"><img alt="avatar" src="assets/img/users/3.jpg"></div>
              <div class="media-body">
                <p><strong>Elizabeth Lewis</strong> added new schedule realease</p><span>Oct 12 10:40pm</span>
              </div>
            </div>
          </div>
          <div class="dropdown-footer">
            <a href="#">View All Notifications</a>
          </div>
        </div>
      </div> --}}
      <div class="dropdown main-profile-menu">
        <a class="main-img-user" href="javascript:void(0);"><img alt="avatar" src="{{$adminImage}}" onerror="this.src='{{asset('admin-assets/images/admin/admin.png') }}'"></a>
        <div class="dropdown-menu">
          <div class="header-navheading">
            <h6 class="main-notification-title">{{$adminName}}</h6>
            <p class="main-notification-text">Administrator</p>
          </div>
          <a class="dropdown-item" href="{{route('admin.myprofile')}}">
            <i class="fe fe-user"></i> My Profile</a>
          <a class="dropdown-item" href="{{route('logout')}}">
            <i class="fe fe-power"></i> Logout</a>
        </div>
      </div>
      {{-- <div class="dropdown d-md-flex header-settings">
        <a href="#" class="nav-link icon" data-toggle="sidebar-right" data-target=".sidebar-right">
          <i class="fe fe-align-right"></i>
        </a>
      </div> --}}
    </div>
  </div>
</div>
<!-- End Main Header-->