@extends('layouts.app')

@section('content')

<div class="container-fluid">

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<table class="table table-bordered table-striped" id="datatable">
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
									<button class="btn btn-default" id="btnDetails" data-toggle="modal" data-target="#{{$guest->id}}view" data-backdrop="static" data-keyboard="true">Update Details</button>
									<button class="btn btn-default"><a href="/guestdeparture/{{ $guest->id }}">Confirm Departure</a></button>
								@endif
							</td>
						</tr>

						<div class="modal fade" id="{{$guest->id}}view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel"><b>Edit Row</b></h4>
                            </div>
                            <div class="modal-body">
                                <form id="my_form" class="form-horizontal" role="form" method="POST" action="/guestupdate/{{$guest->id}}">
                                {{ csrf_field() }}

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{{ $guest->name }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" placeholder="Reason for Visit" id="reason" name="reason" value="{{ $guest->reason }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
											<select id="person_to_visit" name="person_to_visit" class="form-control">
                                       
	                                           	@if($guest->person_to_visit == 0)
	                                    			<option value="0" selected>N/A</option>
			                                    @else
			                                    	<option value="0">N/A</option>
			                                    @endif

	                                    		@foreach($residents as $resident)

			                                    	@if($guest->person_to_visit == $resident->id)
			                                    		<option value='{{ $resident->id }}' selected>{{ $resident->name_first }} {{ $resident->name_last }}</option>
			                                    	@else
			                                    		<option value='{{ $resident->id }}'>{{ $resident->name_first }} {{ $resident->name_last }}</option>
	                                    			@endif

	                                    		@endforeach

                                			</select> 
                                		</div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                           	<input type="text" class="form-control" placeholder="Vehicle Plate" id="plate" name="plate" value="{{ $guest->vehicle_plate }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">        
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>

                                </form>
                            <div class="modal-footer">
                            </div>

                            </div>
                        </div>
                    </div>
                </div>


			</div>


					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection