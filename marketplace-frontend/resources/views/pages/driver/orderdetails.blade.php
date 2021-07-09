@extends('pages.driver.driverlayout')
@section('driverpage')
@include('pages.driver.navbar')
<div class="roms--order-detail"> 
    @include('panels.success')
    @include('panels.errors')
        
    <h4 class="mb-4">Order Details</h4>
    
@if (in_array($order->orderstatus->id,[6,7]))
    <div class="row">
    <div class="col-md-12" id="map-show" style="display: none;" >
    <div class="label" id="distanceandtime"></div>
    <div id="map"></div> 
    </div>   
    </div>
@endif
      <div class="row">
        <div class="col-md-12">
          <div class="roms--cancel-order-block text-right">

            @if ($order->orderstatus->id == 1 && $order->active !==0)
            <span>
              <a href="javascript:void(0);" onclick="confirm({'link':'{{ route('driver.acceptorder',['id'=>$order->id]) }}'})" class="ps-btn ps-btn--sm bg-success mb-4">Accept</a>
            </span>
            <span>
              <a href="javascript:void(0);" onclick="confirm({'link':'{{ route('driver.cancelorder',['id'=>$order->id]) }}'})" class="ps-btn ps-btn--sm bg-danger mb-4">Decline</a>
            </span>
            @endif
            @if (in_array($order->orderstatus->id,[6,7]))
            <span>
              @php
                /*
                $base = 'https://www.google.com/maps/dir/?api=1';
               // $origin = '&origin='.$order->ordergps->driver_lat.','.$order->ordergps->driver_lon;
              //  $waypoints = '&waypoints='.$order->company->latitude.','.$order->company->longitude;
              // below origin and waypoint comment in production.
                $origin = '&origin='.$order->company->latitude.','.$order->company->longitude;
                $waypoints = '';
                $dests = '&destination='.$order->ordergps->drop_lat.','.$order->ordergps->drop_lon;                
                $travelmode = '&travelmode=driving';
                //$action = '&dir_action=navigate';
                $direct = $base.$origin.$dests.$waypoints.$travelmode;
               //  echo urlencode($base.$origin.$dests.$waypoints.$travelmode);
               */
              @endphp
              <a href="javascript:void(0)" onclick="ToggleMap();" class="ps-btn ps-btn--sm bg-warning mb-4">Navigate</a>
             
            </span>
            
@if (in_array($order->orderstatus->id,[6]))
            <span>
              <a href="{{ route('driver.pickuporder',['id'=>$order->id]) }}" class="ps-btn ps-btn--sm bg-primary mb-4">Picked up Order</a>
            </span>
        @endif
            <span>
              <a href="{{ route('driver.completeorder',['id'=>$order->id]) }}" class="ps-btn ps-btn--sm bg-success mb-4">Complete Order</a>
            </span>
            
            @endif
          </div>
        </div>
      </div>

    
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table ps-table--compare">
                    <tbody>
                        <tr>
                            <td class="heading"># Order ID</td>
                            <td>{{ $order->unique_order_id}}</td>
                            <td class="heading">Order Status</td>
                            <td>{{ $order->orderstatus->name }} @if ($driver) ({{$driver['name']}}) @endif</td>
                        </tr>
                        <tr>
                            <td class="heading">Name</td>
                            <td>{{ $order->user->name }}</td>
                            @if (in_array($order->orderstatus->id,[1,6,7]) && $order->active !==0)
                            <td class="heading">Address</td>
                            <td>{{ $order->address }}</td>
                            @endif
                        </tr>
                        @if(!empty($order->note))
                        <tr>
                            <td class="heading text-warning">Instruction</td>
                            <td colspan="3">{{ $order->note }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <h4 class="mt-5 mb-5">Order Items</h4>
    <div class="row">
        <div class="col-md-12">          
            <div class="table-responsive">
{!! Form::open(['route'=>['driver.updateOrder',$order->id],'method'=>'POST','class'=>'updateOrder']) !!}
        <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quanity</th>
                    <th>Available</th>
                    <th>Total</th>
                </tr>
                </thead>
                    <tbody>
                      @foreach ($order->orderitems as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>
                @if (in_array($order->orderstatus->id,[6,7,8]))
                            <label class="label">

                                <input type="hidden" name="itemid[]" value="{{$item->id}}">
                                <input type="radio" 
                                @if(in_array($order->orderstatus->id,[7,8])) disabled="disabled" @endif
                                 name="item_availability{{$item->id}}" value="1" class="checkbox_input" @if($item->isavailable === 1)checked @endif> Yes</label>
                            <label class="label">
                            <input type="radio"
                            @if(in_array($order->orderstatus->id,[7,8])) disabled="disabled" @endif name="item_availability{{$item->id}}" class="checkbox_input" value="0" @if($item->isavailable ===0)checked @endif> No</label>
                @endif
                     </td>
                            <td>{{ romsProPrice($item->price,false)}}</td>
                        </tr> 
                      @endforeach
                    </tbody>
                </table>
      @if (in_array($order->orderstatus->id,[6]))
       <div class="col-12"><button type="submit" class="ps-btn ps-btn--sm bg-danger mb-4 pull-right">Update Order</button></div>
       @endif
        {!! Form::close() !!} 
   </div>
        </div>
    </div>
    @if ($driver)
    <h4 class="mt-5 mb-5">Driver Details</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table ps-table--compare">
                    <tbody>
                        <tr>
                            <td class="heading">Driver Name</td>
                            <td>{{$driver['name']}}</td>
                            <td class="heading">Driver Vehicle</td>
                            <td>{{$driver['vehicle']}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
    @endif
    <h4 class="mt-5 mb-5">Merchant Details</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table ps-table--compare">
                    <tbody>
                        <tr>
                            <td class="heading">Merchant Name</td>
                            <td>{{$order->company->name}}</td>
                            <td class="heading">Merchant Address</td>
                            <td>{{$order->company->address}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <h4 class="mt-5 mb-5">Payment Details</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table ps-table--compare">
                    <tbody>
                       
                        <tr>
                            <td class="heading">Payment Type</td>
                            @if ($order->payment_method == 1)
                              <td>Cash on Delivery</td>
                            @else
                              <td>Online Payment</td>
                            @endif  
                            @if($order->tip_amount != 0)
                            <td class="heading">Tip Amount</td>
                            <td>{{romsProPrice($order->tip_amount,false)}}</td>  
                            @endif                        
                            <td class="heading">Order Total</td>
                            <td>{{romsProPrice($order->total,false)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@php
//orign
$latitude_origin = Auth::user()->latitude;
$longitude_origin = Auth::user()->longitude;

// dest
if($order->orderstatus->id==7){
 $latitude_dest = $order->ordergps->drop_lat;
 $longitude_dest = $order->ordergps->drop_lon;
}else{
 $latitude_dest = $order->company->latitude;
 $longitude_dest = $order->company->longitude;  
}
@endphp

@section('page-scripts')
<script>
    @if (in_array($order->orderstatus->id,[6,7]))
    var myStartOrigin = 0.0;
    var myEndOrigin = 0.0;
    var directionsService = 0.0;
    var directionsRenderer = 0.0;
    var openorder={{Front::IsactiveOrder(Auth::user()->id,Auth::user()->user_type,$order->id)}};
    var latitude_origin={{$latitude_origin}};
    var longitude_origin={{$longitude_origin}};
    var latitude_dest={{$latitude_dest}};
    var longitude_dest={{$longitude_dest}};

    function getDestiantionLocation(){
        if(openorder >0){
            $.ajax({
            url:'/driver/get-destiantion-Location/{{$order->id}}',
            type:'get',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend:function(){}}
            ).done(function(data){
                console.log(data.error);
                if(data.error == false){
                    latitude_dest=data.lat;
                    longitude_dest=data.lon;
                    initMapStore();
                }
            }).fail(function(jqXHR,ajaxOptions,thrownError){ });
        }//if close
    }
    
    
    function ToggleMap(){
        $('#map-show').toggle();
        initMapStore();
    }

    function initMapStore() {
            
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer();

            myStartOrigin = new google.maps.LatLng({{$latitude_origin}},{{$longitude_origin}});
            myEndOrigin = new google.maps.LatLng({{$latitude_dest}}, {{$longitude_dest}});

            const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: myStartOrigin,
            });
            directionsRenderer.setMap(map);

            /* new google.maps.Marker({
                position: myStartOrigin,
                map,
                title: "{{$order->company->name}}",
            });*/
            calcRoute();
            getDistance();
        }
@endif
</script>

<script src="{{asset('js/bh_custom.js')}}"></script>

<style>
/* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
#map {
  height: 300px;
}
</style>
@endsection
