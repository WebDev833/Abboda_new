        <div class="row">
        <div class="col-md-12 content">
  {!! Form::open(['route'=>'driver.goOnline','method'=>'POST','class'=>'go-online','id'=>'goOnlineForm' ]) !!}

        @if(Auth::user()->isOnline)
          <div class="content text-center btn-on-map">
         <button type="button" class="ps-btn" onclick="updateLocation('goOnlineForm',0,false);">Go Offline</button>
        </div>
     
        @else
        <div class="content text-center btn-on-map"> 
        <button type="button" class="ps-btn" onclick="updateLocation('goOnlineForm',1);">Go Online</button>
      </div>
        @endif
          
   {!! Form::hidden('lat','',['class'=>'latitude'])!!}
   {!!Form::hidden('lon','',['class'=>'longitude']) !!}
   {!!Form::hidden('isOnline','',['class'=>'isOnline']) !!}
{!! Form::close() !!}

          <div id="maplocation"></div>

        </div>
        </div>