@extends('layouts.core')
@section('page')

<div class="ps-page--single" id="">
  @include('panels.breadcrumb')
    {{-- @include('sections.siteFeatures') --}}
    {{-- @include('sections.dealOfDay') --}}
    @yield('content')
    {{-- @include('sections.downloadApp') --}}
</div>
@include('sections.newsletter')
@endsection

