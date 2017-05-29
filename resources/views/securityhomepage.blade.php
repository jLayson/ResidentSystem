@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="well">
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

@php
    $now = strtotime(date('Y-m-d h:i:s'));
@endphp

    <div class="col-md-8">
        <div class="well">

        <div class="input-group">
            <input class="form-control datepicker range-filter" type="text" id="startDate" placeholder="Start Date" readonly="" required/>
            <div class="input-group-addon">TO</div>
            <input class="form-control datepicker range-filter" type="text" id="endDate" readonly="End Date" required/>
        </div>

        <table class="table table-bordered table-striped" id="dateTableWithDateRange">
            <thead>
                <tr>
                    <td>Submitted By</td>
                    <td>Visitor Name</td>
                    <td>Expected Date of Arrival</td>
                    <td>Expected Time of Arrival</td>
                    <td>Visitor Code</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody id="visitorTable">
                @foreach($visitors as $visitor)
                <!-- @php
                    $time = date("d-m-Y h:i:s", strtotime($visitor->time_expected));
                    $id = $visitor->id;
                @endphp -->
                    <tr>
                        <td>{{ $visitor->name_first . " " . $visitor->name_middle . " " . $visitor->name_last }}</td>
                        <td>{{ $visitor->visitor_name }}</td>

                        @php

                            $te = explode(" ", $visitor->time_expected) 

                        @endphp

                        @foreach((array) $te[0] as $teDate)
                            @foreach((array) $te[1] as $teTime)

                            <td>{{ $teDate }}</td>
                            <td>{{ $teTime }}</td>

                            @endforeach
                        @endforeach
    
                        <td>{{ $visitor->visitor_code }}</td>
                        <td>
                            @if((strtotime($visitor->time_expected) > $now) && ($visitor->time_arrived == null))
                                <a href="/verifynotification/{{$id}}"><button type="button" class="btn btn-info btn-block">Verify</button></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>

@endsection