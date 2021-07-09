@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')
          <section class="ps-store-list">
            <div class="container">
                
                <div class="ps-section__wrapper">
                    
                    <div class="ps-section__right">
                        <section class="ps-store-box">
                           
                            <div class="ps-section__content">
                                <div class="row">
                                  @if ($companies)
                                      @each('storepanels.store-list-item', $companies, 'company')
                                  @else
                                      <div class="col-md-12">
                                        <p>We do not have any Stores Yet...!!!!</p>
                                      </div>
                                  @endif
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
@endsection