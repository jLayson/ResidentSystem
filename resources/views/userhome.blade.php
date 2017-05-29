@extends('layouts.app')

@section('content')
<div class="container">

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/viewprofile') }}">My Profile</a></li>
                <li><a href="{{ url('/filereport') }}">File Report</a></li>
                <li><a href="{{ url('/userviewreports') }}">My Reports</a></li>
                <li><a href="{{ url('/filevisitornotification') }}">Submit Visitor Notification</a></li>
                <li><a href="{{ url('/userviewnotifications') }}">My Visitor Notifications</a></li>
            </ul>
        </div>
    </nav>

    <!-- <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="{{ url('/viewprofile') }}"><p>My Profile</p></a>
            <a href="{{ url('/filereport') }}"><p>File Report</p></a>
            <a href="{{ url('/userviewreports') }}"><p>My Reports</p></a>
            <a href="{{ url('/filevisitornotification') }}"><p>Submit Visitor Notification</p></a>
            <a href="{{ url('/userviewnotifications') }}"><p>My Visitor Notifications</p></a>
        </div>
    </div> -->
</div>
@endsection
