@extends('layouts.app')

@section('content')

@foreach ($resident as $res)

@php

    $res->birth_date = date("m-d-Y", strtotime($res->birth_date));

@endphp

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Profile</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/editprofile') }}">
                        {{ csrf_field() }}

                        <div class="form-group">

                            <label for="name_first" class="col-md-4 control-label">First Name</label>
                            <div class="col-md-6">
                                <input id="name_first" type="text" class="form-control" name="name_first" value="{{ $res->name_first }}" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <label for="name_middle" class="col-md-4 control-label">Middle Name</label>
                            <div class="col-md-6">
                                <input id="name_middle" type="text" class="form-control" name="name_middle" value="{{ $res->name_middle }}" required autofocus>

                                @if ($errors->has('middle_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('middle_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <label for="last" class="col-md-4 control-label">Last Name</label>
                            <div class="col-md-6">
                                <input id="name_last" type="text" class="form-control" name="name_last" value="{{ $res->name_last }}" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">Address</label>

                            <div class="col-md-6">
                                <textarea  id="address" type="text" class="form-control" name="address" required autofocus>{{ $res->address }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="number_home" class="col-md-4 control-label">Home Number</label>

                            <div class="col-md-6">
                                <input id="number_home" type="text" class="form-control" name="number_home" value="{{ $res->number_home }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="number_mobile" class="col-md-4 control-label">Mobile Number</label>

                            <div class="col-md-6">
                                <input id="number_mobile" type="text" class="form-control" name="number_mobile" value="{{ $res->number_mobile }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="birth_date" class="col-md-4 control-label">Birth Date</label>

                            <div class="col-md-6">
                                <input class="datepicker form-control" type="text" name="birth_date" value="{{ $res->birth_date }}" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach
@endsection
