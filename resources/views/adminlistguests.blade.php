@extends('layouts.app')

@section('content')

<div class="container">

	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<td>Name</td>
						<td>Reason for Visit</td>
						<td>Person to Visit</td>
						<td>Vehicle Plate Number</td>
						<td>Time Arrived</td>
						<td>Time Departed</td>
						<td>Action</td>
					</tr>
				</thead>
				<tbody>
					<button class="button-xsmall pure-button"><a href="{{ url('/export/guest') }}">Export to PDF</a></button>
					@foreach($guests as $guest)
						@php
							if($guest->time_departed == null)
							{
								$guest->time_departed = "";
							}
						@endphp
						<tr>
							<td>{{ $guest->name}}</td>
							<td>{{ $guest->reason}}</td>
							<td>{{ $guest->name_first . " " . $guest->name_middle . " " . $guest->name_last }}</td>
							<td>{{ $guest->vehicle_plate }}</td>
							<td>{{ $guest->created_at }}</td>
							<td></td>
							<td>
								@if($guest->time_departed == "")
									<button class="btn btn-default">Edit</button>
									<button class="btn btn-default">Confirm Departure</button>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	{{ $guests->render() }}

</div>

@endsection