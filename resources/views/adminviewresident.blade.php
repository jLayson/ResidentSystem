@extends('layouts.app')

@section('content')

<div class="container">

	<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Resident Information</div>
                <div class="panel-body">
                	@foreach($resident as $res)
                		<div class="col-md-4">
                             @if($res->avatar == null)
                                    <img src="{{ asset('storage/avatars/default.jpeg') }}" width="200px" height="200" align="center">
                                @else
                                    <img src="{{ asset('storage/avatars/'.$res->avatar) }}" width="200px" height="200px" align="center">
                                @endif
						</div>

						<div class="col-md-4">
							<p>Name: {{ $res->name_first }} {{ $res->name_middle }} {{ $res->name_last }}</p>
							<p>Address: {{ $res->address }}</p>
							<p>Mobile Number: {{ $res->number_mobile }}</p>
							<p>Home Number: {{ $res->number_home }}</p>
							<p>Birth Date: {{ $res->birth_date }}</p>
						</div>

						<div class="col-md-4">
							<p>Reports Submitted: {{ $reports }}</p>
							<p>Total Visitor Notifications: {{ $visitors }}</p>
							<p>Pending Visitor Notifications: {{ $visitorspending }}</p>
							<!-- <p>Registered Vehicles: </p> -->
						</div>
					@endforeach
                </div>
            </div>
        </div>
    </div>

</div>

@endsection