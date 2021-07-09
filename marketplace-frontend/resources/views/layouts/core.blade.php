<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" >
   

    @include('panels.head')
  <body>
        @include('panels.menu')
        @yield('page')
        @include('panels.footer')
        @include('panels.extras')
    @include('panels.scripts')
  </body>
</html>