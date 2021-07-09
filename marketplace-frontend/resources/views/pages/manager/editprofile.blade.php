@extends('pages.manager.managerlayout')
@section('managerpage')
@include('pages.manager.navbar')
<div class="roms--document" id="editProfile">
  @php
  $nuser = json_decode($user->toJson());
@endphp
        {!! Form::model($user, ['route'=>'manager.editProfilePost','class'=>'roms--user-forms','method'=>'POST']) !!}
        <h4 class="mb-5">Edit Profile</h4>
        @include('panels.errors')
        @include('panels.success')
        <div class="row">
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
        </div>
        <div class="form-group submit">
            <button type="submit" class="ps-btn">Update Profile</button>
        </div>
    {!! Form::close() !!}
</div>

@endsection
