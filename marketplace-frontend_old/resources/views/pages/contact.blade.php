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
        <div class="ps-section__header">
            <h3>Contact Us For Any Questions</h3>
        </div>
        <div class="ps-section__content">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                    <div class="ps-block--contact-info">
                        <h4>Contact Directly</h4>
                        <p><a href="#"><span class="__cf_email__"
                                    data-cfemail="cdaea2a3b9acaeb98da0acbfb9abb8bfb4e3aea2a0">[email&#160;protected]</span></a><span>9876543210</span></p>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                    <div class="ps-block--contact-info">
                        <h4>Head Quater</h4>
                        <p><span>#123 abc city state country 21030</span></p>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                    <div class="ps-block--contact-info">
                        <h4>Work With Us</h4>
                        <p><span>Send your CV to our email:</span><a href="#"><span class="__cf_email__"
                                    data-cfemail="dcbfbdaeb9b9ae9cb1bdaea8baa9aea5f2bfb3b1">[email&#160;protected]</span></a>
                        </p>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                    <div class="ps-block--contact-info">
                        <h4>Customer Service</h4>
                        <p><a href="#"><span class="__cf_email__"
                                    data-cfemail="4a293f393e25272f38292b382f0a272b383e2c3f383364292527">[email&#160;protected]</span></a><span>9876543210</span></p>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                    <div class="ps-block--contact-info">
                        <h4>Media Relations</h4>
                        <p><a href="#"><span class="__cf_email__"
                                    data-cfemail="3f525a5b565e7f525e4d4b594a4d46115c5052">[email&#160;protected]</span></a><span>9876543210</span></p>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                    <div class="ps-block--contact-info">
                        <h4>Vendor Support</h4>
                        <p><a href="#"><span class="__cf_email__"
                                    data-cfemail="4432212a202b36373134342b363004292536302231363d6a272b29">[email&#160;protected]</span></a><span>9876543210</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ps-contact-form">
    <div class="container">
        <form class="ps-form--contact-us" action="" method="get">
            <h3>Get In Touch</h3>
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Name *">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Email *">
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Subject *">
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                    <div class="form-group">
                        <textarea class="form-control" rows="5" placeholder="Message"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group submit">
                <button class="ps-btn">Send message</button>
            </div>
        </form>
    </div>
</div>
@endsection
