@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="{{ url('/viewprofile') }}"><p>My Profile</p></a>
            <a href="{{ url('/filereport') }}"><p>File Report</p></a>
            <a href="{{ url('/userviewreports') }}"><p>My Reports</p></a>
            <a href="{{ url('/filevisitornotification') }}"><p>Submit Visitor Notification</p></a>
            <a href="{{ url('/userviewnotifications') }}"><p>My Visitor Notifications</p></a>
        </div>
    </div>
</div>
@endsection
