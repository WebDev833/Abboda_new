<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" >
    @include('admin.panels.head')
  <body>
    @include('admin.panels.preload')
    @yield('layout')
    @include('admin.panels.extras')
    @include('admin.panels.scripts')
  </body>
</html>