@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')
          <section class="ps-store-list pt-0">
            <div class="container">
                <div class="ps-section__header pb-5">
                    <h4 class="text-left">{{ ($coMcount = count($companies)) ? $coMcount : '0' }} Search Result For : " <span class="roms--search-page-query">{{ request()->input('keyword') }}</span> "</h4>
                </div>
                <div class="ps-section__wrapper">
                    <div class="ps-section__right pl-0">
                        <section class="ps-store-box">
                           
                            <div class="ps-section__content">
                                <div class="row">
                                  @if ($companies)
                                      @each('storepanels.store-list-item', $companies, 'company')
                                  @else
                                      <div class="col-md-12">
                                        <p>We don't find any result for your query..!!!</p>
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