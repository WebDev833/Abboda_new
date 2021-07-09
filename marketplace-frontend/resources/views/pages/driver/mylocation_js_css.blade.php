@section('page-styles')
<style>
/* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
#maplocation {
  height: 300px;
}
.btn-on-map {
    position: absolute;
    z-index: 2;
    margin-left: auto;
    margin-right: auto;
    left: 0;
    right: 0;
    top: 60%;
    text-align: center;
}
</style>
@endsection

@section('page-scripts')
<script>
 
let map;
var infoWindow;

function updateLocation(formsub='',isOnline='',alertmessage=true) {

//if OFfline
if(isOnline == 0){
    $(".latitude").val(0);
    $(".longitude").val(0);
    if(formsub !=''){
    $(".isOnline").val(isOnline);
      $("#"+formsub).submit();
    }
}

  // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => { 
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };
//get address
  const geocoder = new google.maps.Geocoder();
  geocoder.geocode({ location: pos }, (results, status) => {
            //console.log(status);
        if (status === "OK") {
          if (results[0]) {
            console.log(pos.lat);
            console.log(pos.lng);

            //console.log(results); // console.log(results[0].formatted_address);
            $(".latitude").val(pos.lat);
            $(".longitude").val(pos.lng);
            if(formsub !=''){
            $(".isOnline").val(isOnline);
              $("#"+formsub).submit();
            }
            if (marker && marker.setMap) {
                marker.setMap(null);
            }
             var marker= new google.maps.Marker({
              position: pos,
              map: map,
              icon: '/images/markericon.png',
              //title: results[0].formatted_address,
              });
             //marker.setPosition(pos);
            infoWindow.setPosition(pos);
            infoWindow.setContent(results[0].formatted_address);
           // infoWindow.open(map,marker); //showing marker text or label
            map.setCenter(pos);
          } else {
            if(alertmessage)
              window.alert("No results found");
          }
        } else {
          if(alertmessage)
            window.alert("Geocoder failed due to: " + status);
        }
      });///goe code end

        },
        () => { //on error
          
          if(alertmessage)
            alert('You have blocked Abboda from tracking your location. To use this, change your location settings in browser.');
        
        }
      );
    } else {
      // Browser doesn't support Geolocation
       if(alertmessage)
        alert('geolocation is not enabled on this browser');
      //handleLocationError(false, infoWindow, map.getCenter());
    }
}



function initMapStore() {

  const styles = {
  default: [],
  silver: [
    {
      elementType: "geometry",
      stylers: [{ color: "#f5f5f5" }],
    },
    {
      elementType: "labels.icon",
      stylers: [{ visibility: "off" }],
    },
    {
      elementType: "labels.text.fill",
      stylers: [{ color: "#616161" }],
    },
    {
      elementType: "labels.text.stroke",
      stylers: [{ color: "#f5f5f5" }],
    },
    {
      featureType: "administrative.land_parcel",
      elementType: "labels.text.fill",
      stylers: [{ color: "#bdbdbd" }],
    },
    {
      featureType: "poi",
      elementType: "geometry",
      stylers: [{ color: "#eeeeee" }],
    },
    {
      featureType: "poi",
      elementType: "labels.text.fill",
      stylers: [{ color: "#757575" }],
    },
    {
      featureType: "poi.park",
      elementType: "geometry",
      stylers: [{ color: "#e5e5e5" }],
    },
    {
      featureType: "poi.park",
      elementType: "labels.text.fill",
      stylers: [{ color: "#9e9e9e" }],
    },
    {
      featureType: "road",
      elementType: "geometry",
      stylers: [{ color: "#ffffff" }],
    },
    {
      featureType: "road.arterial",
      elementType: "labels.text.fill",
      stylers: [{ color: "#757575" }],
    },
    {
      featureType: "road.highway",
      elementType: "geometry",
      stylers: [{ color: "#dadada" }],
    },
    {
      featureType: "road.highway",
      elementType: "labels.text.fill",
      stylers: [{ color: "#616161" }],
    },
    {
      featureType: "road.local",
      elementType: "labels.text.fill",
      stylers: [{ color: "#9e9e9e" }],
    },
    {
      featureType: "transit.line",
      elementType: "geometry",
      stylers: [{ color: "#e5e5e5" }],
    },
    {
      featureType: "transit.station",
      elementType: "geometry",
      stylers: [{ color: "#eeeeee" }],
    },
    {
      featureType: "water",
      elementType: "geometry",
      stylers: [{ color: "#c9c9c9" }],
    },
    {
      featureType: "water",
      elementType: "labels.text.fill",
      stylers: [{ color: "#9e9e9e" }],
    },
  ],
};
  
  map = new google.maps.Map(document.getElementById("maplocation"), {
    center: { lat: 32.756188595366794, lng: -111.66789864711848 },
    zoom: 14,
    clickableIcons: false,
    mapTypeControl: false,
    disableDefaultUI: true,

//    draggable:false,
  });
   
var heatmapData = [
  new google.maps.LatLng(32.2217429, -110.926479),
  new google.maps.LatLng(31.505074, 74.332032),
];

var heatmap = new google.maps.visualization.HeatmapLayer({ data : heatmapData});
heatmap.setMap(map);
  heatmap.set("radius", heatmap.get("radius") ? null : 20);
 const gradient = [
    "rgba(0, 255, 255, 0)",
    "rgba(0, 255, 255, 1)",
    "rgba(0, 191, 255, 1)",
    "rgba(0, 127, 255, 1)",
    "rgba(0, 63, 255, 1)",
    "rgba(0, 0, 255, 1)",
    "rgba(0, 0, 223, 1)",
    "rgba(0, 0, 191, 1)",
    "rgba(0, 0, 159, 1)",
    "rgba(0, 0, 127, 1)",
    "rgba(63, 0, 91, 1)",
    "rgba(127, 0, 63, 1)",
    "rgba(191, 0, 31, 1)",
    "rgba(255, 0, 0, 1)",
  ];
 // heatmap.set("gradient", heatmap.get("gradient") ? null : gradient);
  map.setOptions({ styles: styles['silver'] });
  infoWindow = new google.maps.InfoWindow();

  updateLocation('','',false);

}
function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(
    browserHasGeolocation
      ? "Error: The Geolocation service failed."
      : "Error: Your browser doesn't support geolocation."
  );
  infoWindow.open(map);
}  
</script>
@endsection