@extends('pages.driver.driverlayout')

@section('driverpage')

@include('pages.driver.navbar')

    <div class="roms--orders">
        <h4 class="mb-5 ml-5p pl-15">My Earnings</h4>
        <div class="row">
        <div class="col-md-12">
    <div class="pl-5r mb-1-3r">
   <div>047min = $017/min </div>        
   <div>(rounding applied)  </div>        

</div>

<div class="ml-5p pl-11 pr-15">
         <div class="min-h-36 justify-between  orders-flex border-tb-black ">
<div class="orders-flex-left flex-center">
   
     <div class="mt-3p">
    <h7 class="text-body2 font-900 font-15 color-medium ">Your earnings </h7>
     </div>

</div>
  <div class="order-price flex-center pr-15">
<p class="font-900 font-15 color-secondary ">$5.63 </p>

  </div>

</div>
</div>

<div class="order-price flex-center pr-15  pl-16 ">
<div class="widget widget_footer">
                   <p class="w-70">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellendus placeat dicta nesciunt modi vel enim facilis delectus consequatur maxime ut laborum illum, asperiores quasi quo minima! Libero iste repudiandae voluptas?</p>
  <div class="morelinks">
  <!-- <p class="morelink"><strong>More</strong></p> -->
  <button type="button" class="showmore sm-btn">More details</button>
  <!-- <ul class="ps-list--link footlinkshow" style="display:none">
    <li><a href="faqs.html">FAQs 1 </a></li>
    <li><a href="faqs.html">FAQs 2</a></li>
    <li><a href="faqs.html">FAQs 3 </a></li>
    <li><a href="faqs.html">FAQs 4 </a></li>
    
  </ul> -->
  <div class="  min-h-36 contentshow  orders-flex  mb-5" style="display:none">
  <div class="justify-between border-t"> 

  <div class="orders-flex-left flex-center">
   
   <div class="mt-3p">
  <h7 class="text-body2 font-900 font-15 color-medium  ">Total </h7>
   </div>

</div>
<div class="order-price flex-center pr-15">
<p class="font-900 font-15 color-secondary  ">$9.63 </p>

</div>


  </div>

  <div class="order-price flex-center   " >
  <p class="w-70">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellendus placeat dicta nesciunt modi vel enim facilis delectus consequatur maxime ut laborum illum, asperiores quasi quo minima! Libero iste repudiandae voluptas?</p>
</div>
<div class="bg-grey-light h-30">
  

</div>

<h4 class="mb-5 ">Paid to Uber</h4>
<div class="justify-between "> 

  <div class="orders-flex-left flex-center">
   
   <div class="mt-3p">
  <h7 class="text-body2 color-medium f-bold ">Service Fee </h7>
   </div>

</div>
<div class="order-price flex-center pr-15">
<p class="text-subtitle color-secondary f-bold">$1.63 </p>

</div>


  </div>
<div class="justify-between "> 

  <div class="orders-flex-left flex-center">
   
   <div class="mt-3p">
  <h7 class="text-body2 color-medium f-bold ">Booking Fee </h7>
   </div>

</div>
<div class="order-price flex-center pr-15">
<p class="text-subtitle color-secondary f-bold">$1.63 </p>

</div>


  </div>
  <div class="justify-between border-t"> 

  <div class="orders-flex-left flex-center">
   
   <div class="mt-3p">
  <h7 class="text-body2 font-900 font-15 color-medium ">Total </h7>
   </div>

</div>
<div class="order-price flex-center pr-15">
<p class="font-900 font-15 color-secondary">$9.63 </p>

</div>


  </div>
  <div class=" flex-center   ">
  <p class="w-70">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellendus placeat dicta nesciunt modi vel enim facilis delectus consequatur maxime ut laborum illum, asperiores quasi quo minima! Libero iste repudiandae voluptas?</p>
</div>
  
</div>
<!-- <button type="button" class="morelink sm-btn" >More details</button> -->

    <p class="moredetail sm-btn" style="display:none"><strong>More details</strong></p>
    <!-- <ul class="ps-list--link contentshows" style="display:none">
    <li><a href="faqs.html">FAQs 1 </a></li>
    <li><a href="faqs.html">FAQs 2</a></li>
    <li><a href="faqs.html">FAQs 3 </a></li>
    <li><a href="faqs.html">FAQs 4 </a></li>
    
  </ul> -->
  <div class="  min-h-36 contentshows  orders-flex  mb-5 dropdown cursor-pointer" style="display:none">
  <div class=" dropdown-toggle " type="button"  data-toggle="dropdown"> 
<div class="justify-between">
  <div class="orders-flex-left flex-center">
   
   <div class="mt-3p">
  <h7 class="text-body2 font-900 font-15 color-medium  ">Fare </h7>
   </div>

</div>
<div class="order-price flex-center pr-15 ">
<p class="font-900 font-15 color-secondary mr-3  ">$5.63 </p>
<span class="mb-1r"><img src="http://127.0.0.1:8000/images/icon/arrow-down.png"></span>

</div>
</div>

<div class="dropdown-menu w-100 border-0 z-0 trasnform will-change max-h-500 top-50 position-static">
<div class="justify-between dropdown-item pl-4r pr-0 "> 

<div class="orders-flex-left flex-center">
 
 <div class="mt-3p">
<h7 class="text-body2 color-medium f-bold ">Base </h7>
 </div>

</div>
<div class="order-price flex-center pr-5r">
<p class="text-subtitle color-secondary f-bold">$0.75 </p>

</div>


</div>

    <!-- <a class="dropdown-item" href="#">Product 02</a>
    <a class="dropdown-item" href="#">Product 03</a> -->
    <div class="justify-between dropdown-item pl-4r pr-0 "> 

  <div class="orders-flex-left flex-center">
   
   <div class="mt-3p">
  <h7 class="text-body2 color-medium f-bold ">Distance </h7>

   </div>
   

</div>

<div class="order-price flex-center pr-5r">
<p class="text-subtitle color-secondary f-bold">$2.63 </p>

</div>



  </div>
  <div class="pl-4r mb-1-3r">
   <div>047min = $017/min </div>        
   <div>(rounding applied)  </div>        

</div>

  <div class="justify-between dropdown-item pl-4r pr-0 "> 

<div class="orders-flex-left flex-center">
 
 <div class="mt-3p">
<h7 class="text-body2 color-medium f-bold ">Long pickup-distance </h7>
 </div>

</div>
<div class="order-price flex-center pr-5r">
<p class="text-subtitle color-secondary f-bold">$0.75 </p>

</div>


</div>


  <div class="justify-between dropdown-item pl-4r pr-0 "> 

<div class="orders-flex-left flex-center">
 
 <div class="mt-3p">
<h7 class="text-body2 color-medium f-bold ">Long pickup - time </h7>
 </div>

</div>
<div class="order-price flex-center pr-5r">
<p class="text-subtitle color-secondary f-bold">$1.75 </p>

</div>


</div>
<div class="pl-4r mb-1-3r">
   <div>047min = $017/min </div>        
   <div>(rounding applied)  </div>        

</div>
  <div class="justify-between dropdown-item pl-4r pr-0 "> 

<div class="orders-flex-left flex-center">
 
 <div class="mt-3p">
<h7 class="text-body2 color-medium f-bold ">Time </h7>
 </div>

</div>
<div class="order-price flex-center pr-5r">
<p class="text-subtitle color-secondary f-bold">$1.75 </p>

</div>


</div>
<div class="pl-4r mb-1-3r">
   <div>66min = $0.10/min </div>        
   <div>(rounding applied)  </div>        

</div>



  </div>
  </div>
<!-- <div class="dropdown contentshows" style="display:none">
  <button class="btn btn-primary btn-lg dropdown-toggle" type="button"  data-toggle="dropdown">
    Products
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="#">Product 01</a>
    <a class="dropdown-item" href="#">Product 02</a>
    <a class="dropdown-item" href="#">Product 03</a>
  </div>
</div> -->
  </div>
</div>

     </div>
        </div>

</div>




@endsection


