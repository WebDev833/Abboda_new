@extends('layouts.core')
@section('page')
<div id="homepage-1">
    @include('sections.homeSlider')
    {{-- @include('sections.siteFeatures') --}}
    @yield('content')    
    {{-- @include('sections.downloadApp') --}}
    @include('sections.newsletter')
</div>
@endsection
