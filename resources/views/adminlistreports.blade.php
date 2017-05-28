@extends('layouts.app')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<table class="table table-bordered table-striped">
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
					<button class="button-xsmall pure-button"><a href="{{ url('/export/report') }}">Export to PDF</a></button>
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

	{{ $reports->render() }}

</div>
@endsection