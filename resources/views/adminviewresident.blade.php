@extends('layouts.app')

@section('content')

<div class="container">

	<div class="row">
		<div class="col-md-2 col-md-offset-5">
			<!-- Resident Image Here -->
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>

		</div>
	</div>

	<div class="row">

	@foreach($resident as $res)
		<div class="col-md-4">
			<p>Name: {{ $res->name_first }} {{ $res->name_middle }} {{ $res->name_last }}</p>
			<p>Address: {{ $res->address }}</p>
			<p>Mobile Number: {{ $res->number_mobile }}</p>
			<p>Home Number: {{ $res->number_home }}</p>
			<p>Birth Date: {{ $res->birth_date }}</p>
		</div>

		<div class="col-md-4 col-md-offset-2">
			<p>Reports Submitted: </p>
			<p>Total Visitor Notifications: {{ $visitors }}</p>
			<p>Pending Visitor Notifications: {{ $visitorspending }}</p>
			<p>Registered Vehicles: </p>
		</div>
	@endforeach

	</div>

</div>

@endsection