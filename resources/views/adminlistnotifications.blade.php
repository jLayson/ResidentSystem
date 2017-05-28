@extends('layouts.app')

@section('content')

@php
	$now = strtotime(date('Y-m-d h:i:s'));
@endphp

<div class="container">

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<button class="button-xsmall pure-button"><a href="{{ url('/export/visitor/notification') }}">Export to PDF</a></button>

			<div class="input-group">
				<input class="datepicker range-filter" type="text" id="startDate" placeholder="Start Date" readonly="" required/>
				<div class="input-group-addon">to</div>
    			<input class="datepicker range-filter" type="text" id="endDate" readonly="End Date" required/>
			</div>

			<table class="table table-bordered table-striped" id="dateTableWithDateRange">
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
					@foreach($visitors as $visitor)
					<!-- @php
						$time = date("d-m-Y h:i:s", strtotime($visitor->time_expected));
						$id = $visitor->id;
					@endphp -->
						<tr>
							<td>{{ $visitor->name_first . " " . $visitor->name_middle . " " . $visitor->name_last }}</td>
							<td>{{ $visitor->visitor_name }}</td>
							<td>{{ $visitor->reason_for_visit }}</td>

							@php

								$te = explode(" ", $visitor->time_expected) 

							@endphp

							@foreach((array) $te[0] as $teDate)
								@foreach((array) $te[1] as $teTime)

							<td>
								{{ $teDate }} <!-- {{ $teTime }} -->
							</td>

								@endforeach
							@endforeach
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

</div>

@endsection