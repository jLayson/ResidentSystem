@extends('layouts.app')

@section('content')

@php
	$now = strtotime(date('Y-m-d h:i:s'));
@endphp

<div class="container">

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<td>Submitted By</td>
						<td>Visitor Name</td>
						<td>Reason for Visit</td>
						<td>Expected Time of Arrival</td>
						<td>Time Arrived</td>
						<td>Visitor Code</td>
						<td>Actions</td>
					</tr>
				</thead>
				<tbody>
					<button class="button-xsmall pure-button"><a href="{{ url('/export/visitor/notification') }}">Export to PDF</a></button>
					@foreach($visitors as $visitor)
					@php
						$time = date("d-m-Y h:i:s", strtotime($visitor->time_expected));
						$id = $visitor->id;
					@endphp
						<tr>
							<td>{{ $visitor->submitted_by}}</td>
							<td>{{ $visitor->visitor_name }}</td>
							<td>{{ $visitor->reason_for_visit }}</td>
							<td>
								{{ $time }}
							</td>
							<td>
								@if($visitor->time_arrived)
									{{ $visitor->time_arrived }}
								@else
									<b>N/A</b>
								@endif
							</td>
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

	<div class="row">
		<div class="col-md-2 col-md-offset-5">
			@for ($ctr = 0; $ctr < $total; $ctr++)
				<a href="/listprofiles/{{ $ctr }}"><button class="btn btn-default">{{ $ctr + 1 }}</button></a>
			@endfor
		</div>
	</div>

</div>

@endsection