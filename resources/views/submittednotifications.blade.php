@extends('layouts.app')

@section('content')

<style type="text/css">
    .table > tbody > tr > td {
        vertical-align: middle;
        text-align: center;
    }
</style>

@php
	$now = strtotime(date('Y-m-d h:i:s'));
@endphp

<div class="container-fluid">

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<table class="table table-bordered table-striped datatable" id="datatable">
				<thead>
					<tr>
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
					@php
						$time = date("d-m-Y h:i:s", strtotime($visitor->time_expected));
						$id = $visitor->id;
					@endphp
						<tr>
							<td>{{ $visitor->visitor_name }}</td>
							<td>{{ $visitor->reason_for_visit }}</td>
							<td>
								{{ $time }}
							</td>
							<td>
								@if($visitor->time_arrived == "0000-00-00 00:00:00")
									<b>N/A</b>
								@else
									{{ $visitor->time_arrived }}
								@endif
							</td>
							<td>{{ $visitor->visitor_code }}</td>
							<td>
								@if(strtotime($visitor->time_expected) > $now)
									<div class="btn-group" role="group">
										<button type="button" class="btn btn-primary btn-sm"><a href="/editnotification/{{ $visitor->id }}" style="color:#FFFFFF">Edit</a></button>
										<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#deleteModal">Delete</button>
									</div>
								@endif
							</td>
						</tr>

						<!-- Modal -->
						<div id="deleteModal" class="modal fade" role="dialog">
							<div class="modal-dialog modal-sm">

						    <!-- Modal content-->
						    <div class="modal-content">
						    	<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
						        	<h4 class="modal-title">Delete</h4>
						      	</div>
						    	<div class="modal-body">
									<p>Are you sure you want to delete this entry?</p>
								</div>
						    	<div class="modal-footer">
						    		<a href="/deletenotification/{{ $visitor->id }}"><button type="button" class="btn btn-default">Yes</button></a>
									<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
						    	</div>
						    </div>

						  </div>
						</div>

					@endforeach
				</tbody>
			</table>
		</div>
	</div>

</div>


@endsection