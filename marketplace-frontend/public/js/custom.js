(function ($) {



$.fn.initgeolocation=function(action=false){
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
      if(action){
        $('#latitude').val(position.coords.latitude);
        $('#longitude').val(position.coords.longitude);
        $('.latitude').val(position.coords.latitude);
        $('.longitude').val(position.coords.longitude);

        

        getAddress(position.coords.latitude,position.coords.longitude,action);
      }
   },
  function error(error_message) {
    // for when getting location results in an error
    console.log(action);
    if(action){
    alert('You have blocked Abboda from tracking your location. To use this, change your location settings in browser.');
    }
    console.error('An error has occured while retrieving ' +
                  'location', error_message)
    ipLookUp()
  });
} else {
  // geolocation is not supported
  // get your location some other way
  console.log('geolocation is not enabled on this browser')
  ipLookUp()
}
}

 $.fn.initgeolocation();

 $(".user-current-address").click(function(){

      $.fn.initgeolocation(true);
    });

/**
 * Third party API for IP info lookup.
 */
function ipLookUp()
{
  // Now leave it blank.
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

 $(document).on('click','.morelink',function(e){
      $(this).hide();
  $(this).siblings(".footlinkshow").show();
  $(this).siblings(".lesslink").show();
});

  $(document).on('click','.lesslink',function(e){
      $(this).hide();
  $(this).siblings(".footlinkshow").hide();
  $(this).siblings(".morelink").show();

});


//My Earning page see more button
 $(document).on('click','.showmore',function(e){
      $(this).hide();
  $(this).siblings(".contentshow").show();
  $(this).siblings(".moredetail").show();
});

  $(document).on('click','.moredetail',function(e){
      $(this).hide();
  $(this).siblings(".contentshows").show();
  // $(this).siblings(".moredetail").hide();

});


 $(document).on('change','.roms--country',function(e){
    var url = $(this).data('url');
//console.log(url);
    var count_id = $(this).val();
    window.location.href = "/"+ url +'/?country='+ count_id;
  });

  if(typeof availableTags !== 'undefined' && $( ".main-search" ).length)
    {
      $( ".main-search" ).autocomplete({
        source: availableTags,
        minLength: 2
      });
    }


  // Make sure sw are supported
if ('serviceWorker' in navigator) { 
  window.addEventListener('load', () => {
    navigator.serviceWorker
      .register('./sw_cached_site.js')
      .then(reg => console.log('Service Worker: Registered (site)' ))
      .catch(err => console.log(`Service Worker: Error: ${err}`));
  });
}


///PWA insaltion script
var deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {  
 // Prevent the mini-infobar from appearing on mobile   // e.preventDefault();     // Stash the event so it can be triggered later. 
     deferredPrompt = e;
    // Update UI notify the user they can install the PW // showInstallPromotion();    //console.log(`'beforeinstallprompt' event was fired.`);
  });
//var buttonInstall=document.getElementsByClassName("");
document.querySelector('.appinstall_apple').addEventListener('click', async () => { 
  deferredPrompt.prompt(); 
  const { outcome } = await deferredPrompt.userChoice;
});
document.querySelector('.appinstall_andriod').addEventListener('click', async () => { 
  deferredPrompt.prompt(); 
  const { outcome } = await deferredPrompt.userChoice;
});



var navbar = document.getElementById("foodmenu");
if(navbar !=null)
  var sticky = navbar.offsetTop;

$(function() {
window.onscroll = function() {
          if(navbar !=null)
            foodMenuSticky();
        };
});
function foodMenuSticky() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}

StatuAutoUpdate();
})(jQuery);

//ready end..


function StatuAutoUpdate(){

  let getGeolocation = new Promise(function(myResolve, myReject) {
  
   if ("geolocation" in navigator) {
  // check if geolocation is supported/enabled on current browser
  navigator.geolocation.getCurrentPosition(
       function success(position) {
            myResolve(position);
       },
      function error(error_message) {
        myReject('You have blocked Abboda from tracking your location. To use this, change your location settings in browser.');    
      });
    } else {
      myReject('geolocation is not enabled on this browser');
    }
    });
console.log(usertype);
    if(isOnline ===1 && usertype === 4){

      
       getGeolocation.then(
          function(result) {//success primises

              $.ajax({
                  url:'/driver/status-Auto-Update',
                  type:'get',
                  data:{'lat':result.coords.latitude,'lon':result.coords.longitude},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              beforeSend:function(){stupdate= false;}}
              ).done(function(data){

                if(!data.error){
                    //driver current location update
                     if( typeof updateLocation === "function") updateLocation('','',false);//location page dashboard etc..
                     //get order detail location
                     if(typeof getDestiantionLocation === "function") getDestiantionLocation();//order detail page
                    }
                if (typeof relcall !== 'undefined') {
                  clearTimeout(relcall);
                }
              var relcall=setTimeout(function(){  StatuAutoUpdate(); }, 30000);
              }).fail(function(jqXHR,ajaxOptions,thrownError){ });
              //console.log(result);//resolve
            },
            function(error) {console.log(error);}
          );//then end
    }else if(usertype === 5){
      
        if(typeof getDestiantionLocation === "function") getDestiantionLocation();//order detail page
        if(IsActiveOrder > 0)
          getUpdatestatus();
    }
console.log('StatuAutoUpdate');
}

function getUpdatestatus(){

            $.ajax({
              url:'/user/status-Auto-Update',
              type:'get',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend:function(){stupdate= false;}}
            ).done(function(data){
                
                if(data){
                  $.each(data, function( index, item ) {
                  toastr.info('<div>'+item.message+' <a class="btn btn-primary" href="/user/order-details/'+item.order_id+'">View Detail</a></div><div></div>', item.title,
                   {timeOut: 30*5000,positionClass: "toast-bottom-right",newestOnTop: true,closeButton: true,
});
                });  
                }                
                if (typeof relcall !== 'undefined') {
                  clearTimeout(relcall);
                }
                var relcall=setTimeout(function(){  StatuAutoUpdate(); }, 30000);

              console.log(data);
            }).fail(function(jqXHR,ajaxOptions,thrownError){ });
}
function ratingAndBgImageset(){
    $("select.ps-rating").each(function () {
            var readOnly;
            if ($(this).attr("data-read-only") == "true") {
                readOnly = true;
            } else {
                readOnly = false;
            }
            $(this).barrating({
                theme: "fontawesome-stars",
                readonly: readOnly,
                emptyValue: "0",
            });
        });

     var databackground = $("[data-background]");
        databackground.each(function () {
            if ($(this).attr("data-background")) {
                var image_path = $(this).attr("data-background");
                $(this).css({
                    background: "url(" + image_path + ")",
                });
            }
        });
  }


/**
 * Get Address from Lat lon.
 */
function getAddress(lat,lon,action=false)
{
  // get address by lati longi
  const geocoder = new google.maps.Geocoder();
  const infowindow = new google.maps.InfoWindow();
  if (typeof(map) != "undefined"){var map=null;}
  geocodeLatLng(geocoder, map, infowindow,lat,lon,action);

  return true;
}

function infiniteScroll(page){

  var url_string = window.location.href;
var url = new URL(url_string);
var keyword = url.searchParams.get("keyword");

       let pagination_loader='<div class="loader"></div>';
       if(typeof keyword === 'undefined' || keyword === null){
var search = page;
       }
       else{
         var search = page + '&keyword=' + keyword;
       }
console.log(search);
      $.ajax({
        
        url:'?page='+search,
        type:'get',
        beforeSend:function()
        {
          pageajax= false;
          $("#pagination_loader").html(pagination_loader);
        }
      }).done(function(data){
        pageajax=true;
        $("#pagination_loader").html('');

        if(data.html ==""){
          //$("#pagination_loader").html('No more data!');
          datamore=false;
          return true;
        }else{
          $("#contentSelector").append(data.html);
           ratingAndBgImageset();
        }

      }).fail(function(jqXHR,ajaxOptions,thrownError){
          pageajax=true;
          alert('Server not responding...');
      });
  }

var page=1;
var pageajax=false;
var datamore=true;
$(window).scroll(function(){
  if($(window).scrollTop()+ $(window).height() >= $(document).height() -($(".ps-footer").height()-70) ){

    if(datamore && pageajax){
          page++;
    infiniteScroll(page);
    }
  }
});


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

function scrollToArea(id) {
    getoffset=$("#"+id).offset().top;
    let foodmenu=$("#foodmenu").height();
    getoffset=getoffset-(90+foodmenu);
    $('html, body').animate({
          scrollTop:getoffset
      }, 1000);
}

function confirm(option={}){
  swal.fire({
    title: 'Are you sure!',
    showCancelButton: true,
    confirmButtonText: `Ok`,
    denyButtonText: `Cancel`,
    }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      if(option.hasOwnProperty('link')){
        window.location=option.link;
      }}
    });
}
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("navbar").style.top = "0";
  } else {
    document.getElementById("navbar").style.top = "-50px";
  }
}