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
               



                <div class="ps-section__wrapper">
                    <div class="ps-section__right pl-0">
                        <section class="ps-store-box">
                           
                            <div class="ps-section__content">
                            <div class="infinite-scroll">
                                <div class="row" id="contentSelector">

                                  @if ($companies)
                                  
                                  
                                  @include('storepanels.country-list-item')

                                    
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
<?php if(isset($companies) && $total >= $paginate){?>
  var pageajax=true;
 <?php } ?>
</script>


<style>
  .location-mark{
    position: absolute;
    margin-top: 5px;
    margin-left: 5px;
  }
  .ps-block--store .ps-block__content {
padding : 0px;
  }
  .mainlocations{
    background-color: #f1f1f1;
  }
  .locations-furniture:hover{
    background-color: #ccc;
  }

  </style>
@endsection