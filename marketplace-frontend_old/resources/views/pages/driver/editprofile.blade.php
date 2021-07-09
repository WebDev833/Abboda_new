@extends('pages.driver.driverlayout')
@section('driverpage')
@include('pages.driver.navbar')
<div class="roms--document" id="editProfile">
  @php
  $nuser = json_decode($user->toJson());
@endphp
        {!! Form::open(['route'=>'driver.editProfilePost','class'=>'roms--user-forms','method'=>'POST']) !!}
        <h4 class="mb-5">Edit Profile</h4>
        @include('panels.errors')
        @include('panels.success')
        <div class="row">
            <div class="col-md-12 col-sm-12 col-12 ">
                <div class="form-group">
                    <div class="form-group">
                      {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', (old('name')) ? old('name') : $nuser->name,
                        ["class"=>"form-control",'required'=>'required'])
                        !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-12 ">
                <div class="form-group">
                    <div class="form-group">
                      {!! Form::label('phone', 'Phone') !!}
                        {!! Form::number('phone', (old('phone')) ? old('phone'): $nuser->phone,
                        ['class'=>'form-control','required'=>'required'])
                        !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-12 ">
                <div class="form-group">
                    <div class="form-group">
                      {!! Form::label('age', 'Age') !!}
                        {!! Form::number('age', $nuser->age,
                        ['class'=>'form-control','required'=>'required'])
                        !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-12 ">
                <div class="form-group">
                    <div class="form-group">
                      {!! Form::label('vehicle', 'Vehicle') !!}
                        {!! Form::text('vehicle', $nuser->vehicle,
                        ['class'=>'form-control','required'=>'required'])
                        !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-12 ">
                <div class="form-group">
                    <div class="form-group">
                      {!! Form::label('gender', 'Gender') !!}
                        {!! Form::select('gender', ['male'=>'Male','female'=>'Female'], (old('gender') ? old('gender') : $nuser->gender), ['class'=>'form-control','required'=>'required']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group submit">
            <button type="submit" class="ps-btn">Update Profile</button>
        </div>
    {!! Form::close() !!}
</div>

@endsection
