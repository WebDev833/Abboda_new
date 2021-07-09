{!! Form::open(['route'=>'search','method'=>'GET','class'=>'ps-form--photo-search' ]) !!}
<div class="ps-form__content">
    {{-- <div class="form-group--icon">
        <i class="icon-chevron-down"></i>
        {!! Form::select('area', $topAreaList, NULL, [
        'class' => 'form-control',
        'required' => 'required',
        ]) !!}
    </div>
    <div class="form-group--icon">
      <i class="icon-chevron-down"></i>
      {!! Form::select('type', $topCompanyTypeList, NULL, [
      'class' => 'form-control',
      'required' => 'required',
      ]) !!}
    </div> --}}
    {{-- <input class="form-control" type="text" name="keyword"
    placeholder="{{ trans('front.enter_your_keyword') }}"> --}}
    <div class="form-group form-group--icon">
        {!! Form::text('keyword', null, ['placeholder'=>trans('front.enter_your_keyword'),'class'=>'form-control main-search','data-results-source'=> route('searchtags'),'autofocus'=>'autofocus']) !!} <i class="icon-location"></i>
        {{-- @if (Session::has('location'))
        {!! Form::hidden('location', 1) !!}
        {!! Form::hidden('lat', Session::get('lat'),['class'=>'latitude']) !!}
        {!! Form::hidden('lon', Session::get('lon'),['class'=>'longitude']) !!}
        @endif --}}
    </div>
    <button type="submit">{{ trans('front.search_botton_text') }}</button>
</div>
{{-- <div class="ps-form__footer"><a href="#">Natural</a><a href="#">Digital</a><a href="#">Travel</a><a href="#">Business</a><a href="#">Animal</a><a href="#">Technology</a></div> --}}
{!! Form::close() !!}

@section('vendor-scripts')
    <script type="text/javascript">
      var availableTags = @json(Front::availableTags());
    </script>
@endsection