@extends('admin.layouts.core')
@section('layout')
<div class="page">
    @include('admin.panels.leftsidebar')
      <!-- Main Content-->
      <div class="main-content side-content pt-0">
        @include('admin.panels.header')
        <div class="container-fluid">
            @yield('page')
        </div>
      </div>
      <!-- End Main Content-->
    @include('admin.panels.rightsidebar')
    @include('admin.panels.footer')
</div> 
@endsection