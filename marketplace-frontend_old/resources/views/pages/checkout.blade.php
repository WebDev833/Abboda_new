@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')
            <div class="ps-section--shopping ps-shopping-cart">
            <div class="container">
                <div class="ps-section__header d-none">
                    <h1>{{ trans('front.shipping_information') }}</h1>
                </div>
                <div class="ps-section__footer">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">                          
                            <figure>
                                <figcaption>{{ trans('front.calculate_shipping') }}</figcaption>
                                {!! Form::open(['route'=>'updatetotals','class'=>'','method'=>'POST']) !!}
                                <div class="form-group">
                                    {!! Form::text('address', (session('deliverydetails.address')) ? session('deliverydetails.address') : config::get('roms.dev.address'), [
                                      'class'=>'form-control','required'=>'required',
                                      'placeholder'=> trans('front.enter_drop_address')
                                      ,'id'=>'from_address_landmark']) !!}
                                      {!! Form::hidden('lat', (session('deliverydetails.lat')) ? session('deliverydetails.lat') : config::get('roms.dev.lat'),['id'=>'from_address_lat']) !!}
                                      {!! Form::hidden('lon', (session('deliverydetails.lon')) ? session('deliverydetails.lon') : config::get('roms.dev.lon'),['id'=>'from_address_long']) !!}
                                </div>
                                <div class="form-group">
                                  {{ Form::select('payment_method', [1=>'Cash on Delivery', 2=>'Online Payment'], (session('deliverydetails.payment_method')) ? session('deliverydetails.payment_method') : config::get('roms.dev.payment_method'), ['class'=>"ps-select","required"=>"required","placeholder"=>trans('front.select_payment_method')]) }}
                                </div>
                                <div class="form-group">
                                  {!! Form::textarea('note', (session('deliverydetails.note')) ? session('deliverydetails.note') : config::get('roms.dev.note'), ['class'=>'form-control','placeholder'=> 'You can enter instructions here.. ','rows'=>'2']) !!}
                                </div>
                                <div class="form-group">
                                    <button class="ps-btn ps-btn--outline">Continue to Checkout</button>
                                </div>
                              {!! Form::close() !!}
                            </figure>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">
                          <div id="map"></div>
                        </div>
                        
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">
                            <div class="ps-block--shopping-total">
                                <div class="ps-block__header">
                                    <h3>Your Order</h3>
                                </div>
                                <div class="ps-block__content ">
                                  <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                          @php
                                              $total = 0;
                                          @endphp
                                          @if ($orderDetails && $orderDetails['items'])
                                              @foreach ($orderDetails['items'] as $item)
                                                @php
                                                   $total += $item['total'];
                                                @endphp
                                              <tr>
                                                <td class="cart_total_label">{{$item['name']}} <strong> x {{ $item['quantity'] }}</strong></td>
                                                <td class="cart_total_amount">{{ str_replace(' ','',romsProPrice($item['total'])) }}</td>
                                            </tr>
                                              @endforeach
                                          @endif
                                          @isset ($orderDetails['shipping'])
                                                @php
                                                    $total += $orderDetails['shipping'];
                                                @endphp
                                            <tr>
                                                <td class="cart_total_label">Shipping</td>
                                                <td class="cart_total_amount">{{ str_replace(' ','',romsProPrice($orderDetails['shipping'])) }}</td>
                                            </tr>
                                          @endisset
                                          @isset ($orderDetails['serviceFee'])
                                                @php
                                                    $total += $orderDetails['serviceFee'];
                                                @endphp
                                            <tr>
                                                <td class="cart_total_label">Service Fee</td>
                                                <td class="cart_total_amount">{{ str_replace(' ','',romsProPrice($orderDetails['serviceFee'])) }}</td>
                                            </tr>
                                          @endisset
                                            <tr>
                                            <td class="cart_total_label">Total</td>
                                             <td class="cart_total_amount"><strong>{{ str_replace(' ','',romsProPrice($total)) }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>

                            @if ($allowOrder)
                            {!! Form::open(['route'=> 'placeorder','method'=>'POST']) !!}
                            {!! Form::hidden('area', 5) !!}
                            {!! Form::hidden('address', 5) !!}
                            {!! Form::hidden('payment_method', 2) !!}
                            {!! Form::hidden('latitude', 5) !!}
                            {!! Form::hidden('longitude', 5) !!}
                            <button class="ps-btn ps-btn--fullwidth">{{ trans('front.place_order') }}</button>
                            {!! Form::close() !!}
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('page-scripts')
    <script>
  const GOOGLE_MAP_KEY = 'AIzaSyDmuQZuyvtLoog7Yi_s48Gwj4Y3vTT6PKs';
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmuQZuyvtLoog7Yi_s48Gwj4Y3vTT6PKs&libraries=places"></script>
<script type="text/javascript">
    /**
     * Address autocomplete Module. 
     */
    var autocompleteService = function (t) {
    var e = t,
      i = new google.maps.places.AutocompleteService,
      n = function (t) {
        e = t
      },
      s = function (t, n) {
        "undefined" != typeof e ? i.getPlacePredictions({
          input: t,
          bounds: e
        }, n) : i.getPlacePredictions({
          input: t
        }, n)
      };
    return {
      setBounds: n,
      getSuggestions: s
    }
  },
    placeService = function (t) {
      var e = new google.maps.places.PlacesService(t),
        i = ["address_component", "adr_address", "alt_id", "formatted_address", "geometry", "icon", "id", "name", "permanently_closed", "place_id", "plus_code", "scope", "type", "url", "utc_offset", "vicinity"],
        n = function (t, n) { console.log(t,n);
          e.getDetails({
            placeId: t,
            fields: i
          }, function (t, e) {
            e === google.maps.places.PlacesServiceStatus.OK && n(t)
          })
        },
        s = function (t, e) {
          n(t.place_id, e)
        };
      return {
        getPlaceDetailsFromAutocompleteResult: s,
        getPlaceDetails: n
      }
    },
    placeAutocompleteWrapperV3 = function (t) {
      var e, i, n = t,
        s = [],
        o = [],
        r = function (t) {
          var e = new RegExp(i, "i"),
            n = t.search(e);
          if (-1 != n) {
            var s = t.substr(n, i.length);
            t = t.replace(e, "");
            var o = "<span class='highlighted-search'>" + s + "</span>";
            return o + t
          }
          return t
        },
        a = function (t) {
          return r(t)
        },
        l = function (t) {
          var e = a(t.description);
          return {
            value: {
              place_id: t.place_id,
              text: e.replace(/<\S[a-z0-9'=\-\s]*>/gi, ""),
              suggestion_meta_data: t
            },
            label: e
          }
        },
        u = function (t, i) {
          if (i === google.maps.places.PlacesServiceStatus.OK)
            if (0 == t.length) e([{
              label: "No result found"
            }]);
            else {
              var n = 0;
              t.forEach(function (i) {
                n += 1;
                var r = l(i); - 1 === $.inArray(r.label, o) && (s.push(r), o.push(r.label), e(s)), n == t.length && 0 == s.length && e([{
                  label: "No result found"
                }])
              })
            }
          else 0 === s.length && e([{
            label: "No result found"
          }])
        },
        c = function (t, r) { 
          s = [], o = [], e = r, i = t, e([{
            label: "Please wait..."
          }]),n.getSuggestions(t, u)
        };
      return {
        getSuggestions: c
      }
    },
    PlaceAutoComplete = function (t, e, i, n, s) {
      // t - input
      // e - bounds
      // i - map
      // n - {} -> select g
      // s - undefined
      function o(t, e) {
        return e.value.suggestion_meta_data ? $("<li>").append("<div><div class='map_icon_wrapper'><div class='map_icon'></div></div><div class='text_of_search'>" + m(e.value.suggestion_meta_data) + "</div></div>").appendTo(t) : $("<li>").append("<div>" + e.label + "</div>").appendTo(t)
      }
      var r, a = t,
        l = e,
        u = "";
      "undefined" == typeof n && (n = {});
      var c = {
        north: 30.350,
        south: 29.750,
        east: 31.728,
        west: 30.728
      };
      $.isEmptyObject(l) && (l = c); {
        var h = (new google.maps.Rectangle({
          bounds: l
        }), i),
          d = n,
          p = new autocompleteService(l);
        new placeService(h) // this line not used....
      }
      r = new placeAutocompleteWrapperV3(p);
      var f = function (t) {
        var e = t.description;
        if (t.matched_substrings.length > 0) {
          var i = t.matched_substrings[0],
            n = e.substr(0, i.offset - 1),
            s = e.substr(i.offset, i.length),
            o = e.substr(i.offset + i.length);
          return n + "<span class='highlighted-search'>" + s + "</span><span class='non-highlighted-search'>" + o + "</span>"
        }
        return e
      },
        m = function (t) {
          return f(t)
        },
        g = function () {
          var t = {
            source: function (t, e) {
              u = t.term, r.getSuggestions(t.term, e),
              console.log(e);
            },
            minLength: 3,
            autoFill: !0,
            delay: 1e3,
            select: function (event,ui) {
              //return !1
              console.log(ui.item);
            },
            focus: function () {
              return !1
            },
            change: function (t, e) {
              e.item && e.item.value && e.item.value.suggestion_meta_data || a.val("")
            }
          },
            e = $.extend(t, d);

          @if(session('deliverydetails.address'))
            a.val(a.attr('value'));
          @endif

          a.autocomplete(e).autocomplete("instance")._renderItem = s ? s : o
        };
      g()
    },
    MapModule = function () {
      var t = function (t) {
        var e = {
          center: new google.maps.LatLng((t.north + t.south) / 2, (t.east + t.west) / 2),
          zoom: 11,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        return new google.maps.Map(document.getElementById("map"), e)
      };
      return {
        initialize_map_with_bounds: t
      }
    }();
     
    
  var SearchInitiator = function () {
    function t() {
      h.val(""), a = new google.maps.Rectangle({
        bounds: l
      }), i = new PlaceAutoComplete(h, l, s, {
        select: g,
        close: function () {
          setTimeout(function () {
            h.val() && u.val() && c.val()
          }, 200)
        }
      }), o = new placeService(s), r = new google.maps.Geocoder
    }

    function e(t, e) {
      l = t, s = e
    }
    var i, n, s, o, r, a, l = {},
      u = $("#from_address_lat"),
      c = $("#from_address_long"),
      h = $("#from_address_landmark"),
      m = function () {
        // here need to clear errrors.
      /* FormValidatorModule.hide_error($("#from_address_landmark")), FormValidatorModule.hide_error($("#to_address_landmark")) */
      },
      g = function (t, e) {
        var i = e.item;
        console.log(i);
        return console.log(l), i.value && i.value.suggestion_meta_data ? r.geocode({
          placeId: i.value.place_id
        }, function () {
          return function (t, e) {
            if("OK" == e)
            {
              if(t[0])
              {
                if(a.getBounds().contains(t[0].geometry.location))
                {
                  u.val(t[0].geometry.location.lat()),
                  c.val(t[0].geometry.location.lng()),
                  h.val(i.value.suggestion_meta_data.description)
                } else {
                  // not in bounds of city
                  h.val("")
                }
              } else {
                  // no address found in records.
                  h.val("")
              }
            } else {
                  // google responded invalid response.
                  h.val("")
            }          
          }
        }(i)) : (u.val(""), c.val(""), h.val("")), !1
      };

    return {
      init: e,
      initialize_autocomplete: t,
      clear_all_errors: m
    }
  }();

    
  //var t = $('#autocomplete-input');
  var e = {
    north: 30.350,
    south: 29.750,
    east: 31.728,
    west: 30.728
  };
  var map = MapModule.initialize_map_with_bounds(e);
 // var s;
  SearchInitiator.init(e,map);
  SearchInitiator.initialize_autocomplete();
</script>
@endsection
