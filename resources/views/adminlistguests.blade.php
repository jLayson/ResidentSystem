@extends('layouts.app')

@section('content')

<div class="container-fluid">

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<table class="table table-bordered table-striped" id="dataTableGuest">
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
						<tr>
							<td>{{ $guest->name }}</td>
							<td>{{ $guest->reason }}</td>
							<td>
								@if($guest->person_to_visit == 0)
									NO ONE
								@endif
								{{ $guest->name_first . " " . $guest->name_middle . " " . $guest->name_last }}
							</td>
							<td>{{ $guest->vehicle_plate }}</td>
							<td>{{ $guest->created_at }}</td>
							<td>
							@if($guest->time_departed == null)

							@else 
								{{ $guest->time_departed }}
							@endif
							</td>
							<td>
								@if($guest->time_departed == "")
									<button class="btn btn-default">Edit</button>
									<button class="btn btn-default"><a href="/guestdeparture/{{ $guest->id }}">Confirm Departure</a></button>
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