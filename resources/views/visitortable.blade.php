@extends('layouts.app')

@section('content')

@php
	$now = strtotime(date('Y-m-d h:i:s'));
@endphp

<div class="container">

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            	<div class="panel-body">

            		<div class="form-group">
                        <label for="searchParam" class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input id="searchParam" type="text" class="form-control" name="searchParam" required autofocus>
                        </div>
                    </div>

            		<div class="form-group">
                        <label for="dateStart" class="col-md-4 control-label">Start Date</label>
                        <div class="col-md-6">
                            <input class="datepicker form-control" type="text" name="dateStart" id="dateStart" required readonly="" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dateEnd" class="col-md-4 control-label">End Date</label>
                        <div class="col-md-6">
                            <input class="datepicker form-control" type="text" name="dateEnd" id="dateEnd" required readonly="" />
                        </div>
                    </div>

                    <button class="btn btn-default" id="searchButton" name="searchButton">Search</button>

            	</div>
            </div>
        </div>
	</div>

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<table class="table table-bordered table-striped">
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
				<tbody id="visitorTable">
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
								@if($visitor->time_arrived)
									{{ $visitor->time_arrived }}
								@else
									<b>N/A</b>
								@endif
							</td>
							<td>{{ $visitor->visitor_code }}</td>
							<td>
								@if(strtotime($visitor->time_expected) > $now)
									<a href="{{ url('/editnotification/') . $id }}"><button type="button" class="btn btn-info btn-block">Edit</button></a>
									<button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#deleteModal">Delete</button>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

</div>

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
    		<a href="{{ url('/deletenotification') . '/' . $id }}"><button type="button" class="btn btn-default">Yes</button></a>
			<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
    	</div>
    </div>

  </div>
</div>

@endsection