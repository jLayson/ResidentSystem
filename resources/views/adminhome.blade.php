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
    		<a href="{{ url('/listprofiles/0') }}"><p>List All Users</p></a>
            <a href="{{ url('/listnotifications/0') }}"><p>List All Notifications</p></a>
            <a href="{{ url('/listpending/0') }}"><p>List All Pending Notifications</p></a>
            <a href="{{ url('/listreports/0') }}"><p>List All Reports</p></a>
            <a href="{{ url('/guestform') }}"><p>Guest Registration Form</p></a>
    	</div>
    </div>
</div>
@endsection