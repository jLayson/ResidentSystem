@extends('layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

		@if(Auth::user()->account_type == 1)
			<button class="button-xsmall pure-button"><a href="{{ url('/export/report') }}">Export to PDF</a></button>
		@endif

			<!-- <div class="input-group">
				<input class="datepicker range-filter" type="text" id="startDate" placeholder="Start Date" readonly="" required/>
				<div class="input-group-addon">to</div>
    			<input class="datepicker range-filter" type="text" id="endDate" readonly="End Date" required/>
			</div> -->

			<table class="table table-bordered table-striped datatable" id="datatable">
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
							<td>{{ $report->name_first . " " . $report->name_middle . " " . $report->name_last }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection