{!! Form::open(['route'=>'setdeliveryaddress','method'=>'POST','class'=>'ps-form--photo-search' ]) !!}
<div class="ps-form__content">
 
   
    <div class="form-group form-group--icon">
        {!! Form::text('address', Session::get('deliverydetails.address'), ['placeholder'=>trans('front.enter_your_keyword'),'class'=>'form-control main-search user-current-address-show pac-input autocomplete','data-results-source'=> route('searchtags'),'autofocus'=>'autofocus','required'=>'required']) !!} 
        <i><img class="user-current-address" src="{{ asset('/images/icon/fa-location.png')}}"></i>
       
    </div>
    <div class="form-group hiddenfields">
         
         {!! Form::hidden('location', 0)!!}
         {!! Form::hidden('lat', Session::get('deliverydetails.lat'),['class'=>'latitude'])!!}
         {!!Form::hidden('lon',Session::get('deliverydetails.lon'),['class'=>'longitude']) !!}
</div>
    <button type="submit"><img src="{{ asset('/images/icon/search-arrow.png')}}">{{-- trans('front.search_botton_text') --}}</button>
</div>

{!! Form::close() !!}

@section('vendor-scripts')
    <script type="text/javascript">
      var availableTags = @json(Front::availableTags());
    </script>
@endsection