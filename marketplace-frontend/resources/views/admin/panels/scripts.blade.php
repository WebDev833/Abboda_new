<!-- Jquery js-->
<script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap js-->
<script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Ionicons js-->
{{-- <script src="{{ asset('admin-assets/plugins/ionicons/ionicons.js') }}"></script> --}}

<!-- Rating js-->
<script src="{{ asset('admin-assets/plugins/rating/jquery.rating-stars.js') }}"></script>

<!-- Flot Chart js-->
<script src="{{ asset('admin-assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('admin-assets/js/chart.flot.sampledata.js') }}"></script>
<!-- Chart.Bundle js-->
<script src="{{ asset('admin-assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
<!-- Peity js-->
<script src="{{ asset('admin-assets/plugins/peity/jquery.peity.min.js') }}"></script>
<!-- Jquery-Ui js-->
<script src="{{ asset('admin-assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<!-- Jquery.mCustomScrollbar js-->
<script src="{{ asset('admin-assets/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>


<!-- Perfect-scrollbar js-->
<script src="{{ asset('admin-assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

<!-- Sidemenu js-->
<script src="{{ asset('admin-assets/plugins/sidemenu/sidemenu.js') }}"></script>

<!-- Sidebar js-->
<script src="{{ asset('admin-assets/plugins/sidebar/sidebar.js') }}"></script>

<!-- Sticky js-->
<script src="{{ asset('admin-assets/js/sticky.js') }}"></script>

<!-- Switcher js-->
<script src="{{ asset('admin-assets/switcher/js/switcher.js') }}"></script>
<!----- Google map--------->
<script
      src="https://maps.googleapis.com/maps/api/js?key=@php echo env('GOOGLE_MAP_KEY')@endphp &callback=initAutocomplete&libraries=visualization,places&v=weekly"
      defer
    ></script>


<!-- Custom js-->
<script src="{{ asset('admin-assets/js/custom.js') }}"></script>
{{-- Admin js --}}
<script src="{{ asset('admin-assets/js/admin.js') }}"></script>
<script type="text/javascript">

  function initAutocomplete() {
    //class base MAP
    AutomcompeleteAddress('autocomplete');
  }
  function AutomcompeleteAddress(autocompleteinput){

    var acInputs = document.getElementsByClassName(autocompleteinput);
    if(acInputs){
    for (var i = 0; i < acInputs.length; i++) {

        var autocomplete = new google.maps.places.Autocomplete(acInputs[i]);
        autocomplete.inputId = acInputs[i].id;
  
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
          console.log(this.getPlace());

          $("."+autocompleteinput).val(this.getPlace().formatted_address);
          $(".latitude").val( this.getPlace().geometry.location.lat());
        $(".longitude").val( this.getPlace().geometry.location.lng());
        });
    }
  }
}

</script>
@yield('vendor-scripts')

@yield('page-scripts')