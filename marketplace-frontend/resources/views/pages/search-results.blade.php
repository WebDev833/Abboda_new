@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')
          <section class="ps-store-list pt-50">
            <div class="container">
               
<!-- 
                <div class="ps-search-filters">
                  {!! Form::open(['route'=>'search','method'=>'get','class'=>'ps-form--filters-search' ]) !!}
            <div class="row">
                <div class="col-md-5 col-6">
                  <div class="form-group">
                  {!! Form::text('keyword',request()->input('keyword') , ['placeholder'=>trans('front.enter_your_search_keyword'),'class'=>'form-control','autofocus'=>'autofocus']) !!}
                  </div>
                </div>
                <div class="col-md-4 col-6">
                  <div class="form-group select-foodtype">
                    @if(count($foodtypes))
                    <select class="form-control ps-select-multi" multiple="" name="foodtype[]" data-placeholder="Select Food Types">
                    @foreach($foodtypes as $key=>$type)
 <option value="{{$key}}" @if(is_array(request()->input('foodtype')) && in_array($key,request()->input('foodtype')))selected @endif>{{$type['value']}}</option>
                    @endforeach
                    </select>
                    @endif
                  </div>
                </div>


              <div class="col-lg-3 col-md-3 col-12">
                 <div class="form-group">
                    <button class="form-control btn btn-primary btn-lg" type="submit">{{trans('front.search_botton_text') }}</button>
                  </div>

              </div>

            </div>


                  {!! Form::close() !!}
                </div> -->


                <div class="ps-section__wrapper">
                    <div class="ps-section__right pl-0">
                        <section class="ps-store-box">
                           
                            <div class="ps-section__content">
                            <div class="infinite-scroll">
                                <div class="row" id="contentSelector">




                                  @if ($companies)
                                  
                                      @include('storepanels.store-list-item')

                                      {{-- @each('storepanels.store-list-item', $companies, 'company') --}}

                                    
                                    @else
                                      <div class="col-md-12">
                                        <p>We don't find any result for your query..!!!</p>
                                      </div>
                                  @endif
                                  
                                  </div>
                                  <div class="ajax-load" id="pagination_loader"></div>
                                </div> <!-- infinite scroll end--->
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
@endsection


@section('page-scripts')
   
<script type="text/javascript">
  var pageajax=true;
</script>
@endsection