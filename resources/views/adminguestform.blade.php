@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Guest</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/addguest') }}">
                        {{ csrf_field() }}

                        <div class="form-group">

                            <label for="name_first" class="col-md-4 control-label">First Name</label>
                            <div class="col-md-6">
                                <input id="name_first" type="text" class="form-control" name="name_first" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <label for="name_middle" class="col-md-4 control-label">Middle Name</label>
                            <div class="col-md-6">
                                <input id="name_middle" type="text" class="form-control" name="name_middle" required autofocus>

                                @if ($errors->has('middle_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('middle_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <label for="last" class="col-md-4 control-label">Last Name</label>
                            <div class="col-md-6">
                                <input id="name_last" type="text" class="form-control" name="name_last" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="reason" class="col-md-4 control-label">Reason for Visit</label>
                            <div class="col-md-6">
                                <textarea  id="reason" type="text" class="form-control" name="reason" required autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="vehicle_plate" class="col-md-4 control-label">Vehicle Plate Number</label>

                            <div class="col-md-6">
                                <input id="vehicle_plate" type="text" class="form-control" name="vehicle_plate" required autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="radio" class="col-md-4 control-label">Has Sticker</label>
                            <div class="radio">
                                <label><input type="radio" name="has_sticker" value="1">Yes</label>
                                <label><input type="radio" name="has_sticker" value="0">No</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="person_to_visit" class="col-md-4 control-label">Person to Visit</label>

                            <div class="col-md-6">
                                <select id="person_to_visit" name="person_to_visit" class="form-control">
                                    @foreach($residents as $resident)
                                        <option value='{{ $resident->id }}'>{{ $resident->name_first }} {{ $resident->name_last }}</option>
                                    @endforeach
                                </select> 
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

@endsection
