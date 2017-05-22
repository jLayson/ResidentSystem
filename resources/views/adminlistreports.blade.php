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

	<div class="row">
		<div class="col-md-2 col-md-offset-5">
			@for ($ctr = 0; $ctr < $total; $ctr++)
				<a href="/listprofiles/{{ $ctr }}"><button class="btn btn-default">{{ $ctr + 1 }}</button></a>
			@endfor
		</div>
	</div>

</div>
@endsection