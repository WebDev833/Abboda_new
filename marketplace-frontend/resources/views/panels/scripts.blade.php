    <script src="{{ asset('plugins/jquery-1.12.4.min.js')}}"></script>
    <script src="{{ asset('plugins/popper.min.js')}}"></script>
    <script src="{{ asset('plugins/owl-carousel/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('plugins/bootstrap4/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('plugins/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{ asset('plugins/masonry.pkgd.min.js')}}"></script>
    <script src="{{ asset('plugins/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery.matchHeight-min.js')}}"></script>
    <script src="{{ asset('plugins/slick/slick/slick.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-bar-rating/dist/jquery.barrating.min.js')}}"></script>
    <script src="{{ asset('plugins/slick-animation.min.js')}}"></script>
    <script src="{{ asset('plugins/lightGallery-master/dist/js/lightgallery-all.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('plugins/sticky-sidebar/dist/sticky-sidebar.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery.slimscroll.min.js')}}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    @yield('vendor-scripts')
    <script type="text/javascript">
    //favicon
    var link = document.querySelector("link[rel~='icon']");

        link = document.createElement('link');
        link.rel = 'icon';
        document.getElementsByTagName('head')[0].appendChild(link);
      link.href = '{{ asset('/images/favicon.png?v=1')}}';
      @auth
      var usertype={{Auth::user()->user_type}};
      var isOnline={{Auth::user()->isOnline}};
      var IsActiveOrder={{Front::IsactiveOrder(Auth::user()->id,Auth::user()->user_type)}};
      @endauth
      @guest
      var usertype=0;
      var isOnline=0;
      var IsActiveOrder=0;
      @endguest
      
    </script>

    <!-- custom scripts-->
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <script
      src="https://maps.googleapis.com/maps/api/js?key=@php echo env('GOOGLE_MAP_KEY')@endphp &callback=initAutocomplete&libraries=visualization,places&v=weekly"
      defer
    ></script>

    <script src="{{ asset('js/main.js')}}"></script>
    <script src="{{ asset('js/custom.js?v=2')}}"></script>

<script>
// This example adds a search box to a map, using the Google Place Autocomplete
// feature. People can enter geographical searches. The search box will return a
// pick list containing a mix of places and predicted search terms.
// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

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

function initAutocomplete() {

//class base MAP
AutomcompeleteAddress('autocomplete');
///ID base map
  if(document.getElementById("map")){
  const map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 0, lng: 0 },
    zoom: 4,
    mapTypeId: "roadmap",
  });
  // Create the search box and link it to the UI element.
  const input = document.getElementById("pac-input");
  const searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
  // Bias the SearchBox results towards current map's viewport.
  map.addListener("bounds_changed", () => {
    searchBox.setBounds(map.getBounds());
  });
  let markers = [];
  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener("places_changed", () => {
    const places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }
    // Clear out the old markers.
    markers.forEach((marker) => {
      marker.setMap(null);
    });
    markers = [];
    // For each place, get the icon, name and location.
    const bounds = new google.maps.LatLngBounds();
    places.forEach((place) => {
      if (!place.geometry) {
        console.log("Returned place contains no geometry");
        return;
      }
      const icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25),
      };
      // Create a marker for each place.
      markers.push(
        new google.maps.Marker({
          map,
          icon,
          title: place.name,
          position: place.geometry.location,
          draggable:true,
        })
      );

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
        
      }
      $("#latitude").val(place.geometry.location.lat());
      $("#longitude").val(place.geometry.location.lng());
    });
    map.fitBounds(bounds);
    
  });
  }
    if( typeof initMapStore === "function") initMapStore();

}

function geocodeLatLng(geocoder, map, infowindow,lat,lon,action) {
 // const input = document.getElementById("latlng").value;
//  const latlngStr = input.split(",", 2);
  const latlng = {
    lat: parseFloat(lat),
    lng: parseFloat(lon),
  };
  geocoder.geocode({ location: latlng }, (results, status) => {

            console.log(status);
            console.log('action-> ',action);
    if (status === "OK") {
      if (results[0]) {
        /*map.setZoom(11);
        const marker = new google.maps.Marker({
          position: latlng,
          map: map,
        });*/
    $(".user-current-address-show").val(results[0].formatted_address);
        console.log(results);
        console.log(results[0].formatted_address);
/*        infowindow.setContent(results[0].formatted_address);
        infowindow.open(map, marker);
*/
      } else {
        window.alert("No results found");
      }
    } else {
      window.alert("Geocoder failed due to: " + status);
    }
  });
}
</script>

    @yield('page-scripts')
