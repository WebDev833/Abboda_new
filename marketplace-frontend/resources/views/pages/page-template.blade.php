@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')
<div class="ps-contact-info">
    <div class="container">
       
        <div class="ps-section__content">
            <div class="row">

@if($pageConfigs['page']->static ==2)
            <div class="col-12">
            <div class="row">
                
                <div class="col-md-4 col-6 ">
                <div class="form-group row">
                    <label for="country" class="col-sm-3 col-form-label">Country:
                    </label>
                    <div class="col-sm-9">

                     {!! Form::select('Country',$pageConfigs['countries'], ($pageConfigs['country_id'] > 0 ) ? $pageConfigs['country_id'] : '2', ['class'=>'ps-select roms--country', 'data-url'=>$pageConfigs['page']->translate(App::getLocale())->slug] ) !!}
                   
                    </div>
                </div>

                </div>
                
                <div class="col-md-6 col-8">

                <div class="form-group row">

                <label for="Language" class="col-sm-3 col-form-label">Language:</label> 
                <div class="col-sm-9">
                 {!! Form::select('language', [
                  'en'=>'English',
                  'ar'=>'Arabic'
                  ], (Session::has('language')) ? Session::get('language') : 'en', ['class'=>'ps-select roms--language','data-url'=>route('switchlang')]) !!}
                </div>

                </div>
                </div>
            </div>    
            </div>
            </div>    
<hr>
@endif

                @if ($pageConfigs['sections']->count())
                    @foreach ($pageConfigs['sections'] as $section)
                {!!$section->translate(App::getLocale())->content!!}
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</div>

@endsection
