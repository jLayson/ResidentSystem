@extends('layouts.app')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-md-4">
            {{ csrf_field() }}
        <h3>Guest Registration</h3>

        <div id="successnotification" class="well" style="background-color:#006dcc" hidden>
            <p style="color:#E5E5E5">Successfully added entry</p>
         </div>

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
                <button id="submitForm" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <table class="table table-bordered table-striped datatable" id="datatable">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Reason</td>
                    <td>Person to Visit</td>
                    <td>Plate</td>
                    <td>Arrived</td>
                    <td>Departed</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody id="guestTable">
                @foreach($guests as $guest)
                    <tr>
                        <td>{{ $guest->name }}</td>
                        <td>{{ $guest->reason }}</td>
                        <td>
                            @if($guest->person_to_visit == 0)
                                NO ONE
                            @endif
                            {{ $guest->name_first . " " . $guest->name_middle . " " . $guest->name_last }}
                        </td>
                        <td class="col-md-1">{{ $guest->vehicle_plate }}</td>
                        <td class="col-md-1">{{ $guest->created_at }}</td>
                        <td class="col-md-1">
                        @if($guest->time_departed == null)

                        @else 
                            {{ $guest->time_departed }}
                        @endif
                        </td>
                        <td>
                            @if($guest->time_departed == "")
                                <div class="btn-group" role="group">
                                    <button class="btn btn-default btn-sm" id="btnDetails" data-toggle="modal" data-target="#{{$guest->id}}view" data-backdrop="static" data-keyboard="true">Update</button>
                                    <button class="btn btn-default btn-sm"><a href="/guestdeparture/{{ $guest->id }}" style="color:#E5E5E5">Left</a></button>
                                </div>
                            @endif
                        </td>
                    </tr>

                <div class="modal fade" id="{{$guest->id}}view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><b>Edit Row</b></h4>
                        </div>
                    <div class="modal-body">
                            <form id="my_form" class="form-horizontal" role="form" method="POST" action="/guestupdate/{{$guest->id}}">
                            {{ csrf_field() }}

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{{ $guest->name }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" placeholder="Reason for Visit" id="reason" name="reason" value="{{ $guest->reason }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <select id="person_to_visit" name="person_to_visit" class="form-control">
                                   
                                            @if($guest->person_to_visit == 0)
                                                <option value="0" selected>N/A</option>
                                            @else
                                                <option value="0">N/A</option>
                                            @endif

                                            @foreach($residents as $resident)

                                                @if($guest->person_to_visit == $resident->id)
                                                    <option value='{{ $resident->id }}' selected>{{ $resident->name_first }} {{ $resident->name_last }}</option>
                                                @else
                                                    <option value='{{ $resident->id }}'>{{ $resident->name_first }} {{ $resident->name_last }}</option>
                                                @endif

                                            @endforeach

                                        </select> 
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" placeholder="Vehicle Plate" id="plate" name="plate" value="{{ $guest->vehicle_plate }}" required>
                                    </div>
                                </div>
                                    
                                <div class="form-group row">        
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>

                            </form>
                        <div class="modal-footer">
                        </div>

                        </div>
                    </div>
                </div>
            </div>

@endforeach
        </tbody>
    </table>
</div>
</div>
@php
    $now = strtotime(date('Y-m-d h:i:s'));
@endphp

    


<br><br>

<div class="row">
    <div class="col-md-6">

        <table class="table table-bordered table-striped datatable" id="datatable">
            <thead>
                <tr>
                    <td>Submitted By</td>
                    <td>Visitor Name</td>
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

                        <td>{{ $visitor->time_expected }}
    
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

    <div class="col-md-6">
            <table class="table table-bordered table-striped datatable" id="datatable">
                <thead>
                    <tr>
                    <td>Report Nature</td>
                    <td>Description</td>
                    <td>Location</td>
                    <td>Time Submitted</td>
                    <td>Submitted By</td>
                </tr>
            </thead>
            <tbody id="reportTable">
                @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->nature_name }}</td>
                        <td>{{ $report->description }}</td>
                        <td>{{ $report->location }}</td>
                        <td>{{ $report->created_at }}</td>
                        <td>{{ $report->name_first . " " . $report->name_middle . " "  . $report->name_last}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

@endsection

@section('pageJS')
    <script src="{{ URL::asset('js/custom/securityHomeAjax.js') }}"></script>
@endsection