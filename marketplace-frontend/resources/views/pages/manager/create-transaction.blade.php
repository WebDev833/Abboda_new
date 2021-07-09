@extends('pages.manager.managerlayout')
@section('managerpage')
@include('pages.manager.navbar')
<div class="roms--document" id="createTransaction">
        {!! Form::open(['route'=>'manager.storeTransaction','class'=>'roms--user-forms','method'=>'POST']) !!}
        {!! Form::open(['route'=>'manager.storeTransaction','class'=>'roms--user-forms','method'=>'POST']) !!}
        <h4 class="mb-5">Create Transaction</h4>
        @include('panels.errors')
        @include('panels.success')
        <div class="row">
            <div class="col-md-12 col-sm-12 col-12 ">
                <div class="form-group">
                    <div class="form-group">
                      {!! Form::label('receiver_id', 'Driver') !!}
                        {!! Form::select('receiver_id', $drivers, old('receiver_id'), ['class'=>'form-control ps-select','required'=>'required']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-12 ">
                <div class="form-group">
                    <div class="form-group">
                      {!! Form::label('amount', 'Amount') !!}
                        {!! Form::number('amount', old('amount'),
                        ['class'=>'form-control','required'=>'required'])
                        !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <div class="form-group">
                      {!! Form::label('paid', 'Paid') !!}
                        {!! Form::select('paid', ['1'=>'Yes','0'=>'No'], old('paid'), ['class'=>'form-control ps-select','required'=>'required']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <div class="form-group">
                      {!! Form::label('received', 'Received') !!}
                        {!! Form::select('received', ['0'=>'No','1'=>'Yes'], old('received'), ['class'=>'form-control ps-select','required'=>'required']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group submit">
            <button type="submit" class="ps-btn">Create Transaction</button>
        </div>
    {!! Form::close() !!}
</div>

@endsection
