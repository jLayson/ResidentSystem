@extends('layouts.app')

@section('content')

<div class="container" onload="loadNow()">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

			<button class="button-xsmall pure-button"><a href="{{ url('/export/report') }}">Export to PDF</a></button>

			<!-- <div class="input-group">
				<input class="datepicker range-filter" type="text" id="startDate" placeholder="Start Date" readonly="" required/>
				<div class="input-group-addon">to</div>
    			<input class="datepicker range-filter" type="text" id="endDate" readonly="End Date" required/>
			</div> -->

			<table class="table table-bordered table-striped" id="datatable">
				<thead>
					<tr>
						<td>Report Nature</td>
						<td>Description</td>
						<td>Location</td>
						<td>Time Submitted</td>
						<td>Submitted By</td>
					</tr>
				</thead>
				<tbody>
					@foreach($reports as $report)
						<tr>
							<td>{{ $report->nature_name }}</td>
							<td>{{ $report->description }}</td>
							<td>{{ $report->location }}</td>
							<td>{{ $report->created_at }}</td>
							<td>{{ $report->submitted_by }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection