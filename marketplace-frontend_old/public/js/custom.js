(function ($) {

  /**
   * User Location - get from Geolocation
   */
  if ("geolocation" in navigator) {
  // check if geolocation is supported/enabled on current browser
  navigator.geolocation.getCurrentPosition(
   function success(position) {
     // for when getting location is a success
     console.log('latitude', position.coords.latitude, 
                 'longitude', position.coords.longitude);
    getAddress(position.coords.latitude,position.coords.longitude)
   },
  function error(error_message) {
    // for when getting location results in an error
    console.error('An error has occured while retrieving' +
                  'location', error_message)
    ipLookUp()
  });
} else {
  // geolocation is not supported
  // get your location some other way
  console.log('geolocation is not enabled on this browser')
  ipLookUp()
}

/**
 * Third party API for IP info lookup.
 */
function ipLookUp()
{
  // Now leave it blank.
  return false; 
}

/**
 * Get Address from Lat lon.
 */
function getAddress(lat,lon)
{
  //Now leave it blank.
  return false;
}

/**
 * function dev address, lat and lon
 */
//function 

  /**
   * Language switcher
   */
 $(document).on('change','.roms--language',function(e){
    var url = $(this).data('url');
    var lang = $(this).val();
    window.location.href = url +'/'+ lang;
  });

    if(typeof availableTags !== 'undefined' && $( ".main-search" ).length)
    {
      $( ".main-search" ).autocomplete({
        source: availableTags,
        minLength: 2
      });
    }


      // scroll to aurocomplete. 

    // $(document).on('click',".main-search",function() {
    // $('html, body').animate({
    //     scrollTop: $(".main-search").offset().top-100
    // }, 500);
    // });


})(jQuery);