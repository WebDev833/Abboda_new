@extends('pages.user.userlayout')
@section('userpage')

<div class="roms--document" id="editProfile">
       
        <div class="profile-row row onlydesktop">
<div class="col-6">
<h5 class="mb-5" style="font-size: 20px;">Profile</h5>
</div>

<div class="edit-btn col-6">

<button type="button" class="edit-profile-btn" style="float: right;"  data-toggle="modal" data-target="#exampleModal">EDIT PROFILE</button>
</div>
        
        </div>
        @include('panels.errors')
        @include('panels.success')

        <div class="flex-container">
        <div class="profile-data">
        <img class="rounded-circle ml-2" alt="100x100" width="100px" src="{{asset('images/sample.png')}}"
          data-holder-rendered="true">
          @php
                                  $user = json_decode($user->toJson());
                              @endphp
                              <div class="name-profile">
          <h6>{{$user->name}}</h6>
                              </div>
         
</div>

<div class="profile-data-content">

<div class="main-content-profile">
    <div class="icon-image-profile">
  <i class="icon-profile-dial"> <img src="{{asset('images/number-icon.png')}}"></i> 
  </div>
<div class="text-icon-profile ">
    <h6 class="text-subtitle color-secondary">Phone Number</h6>
    <p class="text-bdy2 color-medium">{{$user->phone}}</p>
</div>
</div>
<div class="main-content-profile">
    <div class="icon-image-profile">
<i> <img src="{{asset('images/email--icon.png')}}" style="color:black;"></i> 
</div>
<div class="text-icon-profile">
    <h6 class="text-subtitle color-secondary">Email id</h6>
    <p class="text-bdy2 color-medium">{{$user->email}}</p>
</div>
</div>
<div class="main-content-profile notfordesktop">
    <div class="edit-profile-btn-mobile">
<a data-toggle="modal" data-target="#exampleModal"><img src="{{asset('images/edit-pencil-icon.png')}}">
</div>
<div class="text-icon-profile">
    <h6 class="text-subtitle color-secondary">Edit Profile</h6></a>
</div>
</div>
<div class="main-content-profile notfordesktop">
    <div class="edit-profile-btn-mobile">
<a href=""><img src="{{asset('images/change-password-icon.png')}}">
</div>
<div class="text-icon-profile">
    <h6 class="text-subtitle color-secondary">Change Password</h6></a>
</div>
</div>



</div>


        </div>
        <div class="sign-out-mbl notfordesktop">
 <a href="{{route('logout')}}"> <img src="{{asset('images/signout-icon.png')}}">  <h7 class="color-primary">Sign Out</h7></a>
</div>
       
     {{--    <div class="row">
            <div class="col-md-12 col-sm-12 col-12 ">
                <div class="form-group">
                    <div class="form-group">
                      {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', old('name'),
                        ["class"=>"form-control",'required'=>'required'])
                        !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-12 ">
                <div class="form-group">
                    <div class="form-group">
                      {!! Form::label('phone', 'Phone') !!}
                        {!! Form::number('phone', old('phone'),
                        ['class'=>'form-control','required'=>'required'])
                        !!}
                    </div>
                </div>
            </div>
        </div>--}}
      
    {!! Form::close() !!}
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="close-popup">&times;</span>
        </button>
   
    <div class="main-content-mobile">
    
<div class="account">

<div class="container">
{!! Form::model($user, ['route'=>'user.editProfilePost','class'=>'ps-form--account ps-tab-root','method'=>'POST']) !!}



<div class="text-login-mobile mt-20 mb-20">

<h6 class="color-medium text-center">Edit Profile</h6>
</div>
<div class="popup-image">
<img class="rounded-circle mr-3" alt="100x100" width="100px" src="{{asset('images/sample.png')}}"
          data-holder-rendered="true">        
          <i class="fa fa-pencil edit-image-icon"></i>
          
          </div>
<div class="form-label-group">

{!! Form::text('name', old('name'),
                        ["class"=>"input-field-mobile form-control","id"=>"inputEmail"]) !!}
                        <label for="inputEmail">Full Name</label>
                    </div>
                    <div class="form-label-group">
                    {!! Form::number('phone', old('phone'),
                         ['class'=>'input-field-mobile  form-control','id'=>'phone-field']) !!}
                        
                        
                        <label for="phone-field">Phone Number</label>
                    </div>
                    <div class="form-label-group ">
                    {!! Form::text('email', old('email'),
                            ['class'=>'input-field-mobile  form-control','id'=>'email-id']) !!}
                        
                       
                        <label for="email-id">Email Id</label>
                    </div>
                   
                    
                <div class="form-group sign-in-btn">
                        <button type="submit"
                            class="sign-mobile btn btn-danger" >SAVE CHANGES</button>
                      
                    </div>

{!! Form::close() !!}
</div>
</div>
    </div>
    </div>
  </div>
</div>

@endsection
@section('page-scripts')

<style>
  .profile-data-content {
    padding: 17px;
}
    </style>
@endsection