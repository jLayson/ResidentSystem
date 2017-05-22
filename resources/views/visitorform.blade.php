@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">File Report</div>
                <div class="panel-body">

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/submitvisitornotification') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="visitor_name" class="col-md-4 control-label">Visitor Name</label>
                            <div class="col-md-6">
                                <input id="visitor_name" type="text" class="form-control" name="visitor_name" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="reason_for_visit" class="col-md-4 control-label">Reason for Visit</label>
                            <div class="col-md-6">
                                <textarea  id="reason_for_visit" type="text" class="form-control" name="reason_for_visit" required autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="date_expected" class="col-md-4 control-label">Expected Date of Arrival</label>
                            <div class="col-md-6">
                                <input class="datepicker form-control" type="text" name="date_expected" id="date_expected" required readonly="" />
                            </div>
                        </div>

                        <div class="form-group bootstrap-timepicker timepicker">
                            <label for="time_expected" class="col-md-4 control-label">Expected Time of Arrival</label>
                            
                            <div class="col-md-6">
                                <input id="time_expected" name="time_expected" type="text" class="form-control input-small" readonly="">
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

