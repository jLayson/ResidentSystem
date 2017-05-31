@extends('layouts.app')

@section('content')

<div class="container">

	<div class="row">

	@if(Auth::user()->account_type == 1)
		<button class="button-xsmall pure-button"><a href="{{ url('/export/resident') }}">Export to PDF</a></button>
	@endif

		<div class="col-md-10 col-md-offset-1">
			<table id="adminListResidents" class="table table-bordered table-striped datatable" id="datatable">
				<thead>
					<tr>
						<td>Resident Image</td>
						<td>Name</td>
						<td>Address</td>
						<td>Mobile Number</td>
						<td>Home Number</td>
					</tr>
				</thead>
				<tbody>
					@foreach($residents as $resident)
						
						<tr>
<<<<<<< HEAD
							@if($resident->avatar == null)
								<td><a href="/adminviewprofile/{{$resident->id}}"><img src="{{ asset('storage/avatars/default.jpeg') }}" width="100px" height="100px" align="center"></a></td>
							@else
								<td><a href="/adminviewprofile/{{$resident->id}}"><img src="{{ asset('storage/avatars/'.$resident->avatar) }}" width="100px" height="100px" align="center"></a></td>
							@endif
=======
							<td><a href="/adminviewprofile/{{$resident->id}}">
								@if($resident->avatar == null)
									<img src="{{ asset('storage/avatars/default.jpeg') }}" width="100px" height="100px" align="center">
								@else
									<img src="{{ asset('storage/avatars/'.$resident->avatar) }}" width="100px" height="100px" align="center">
								@endif
							</a></td>
>>>>>>> 93f049268cefe7306ee821463627fe85c31da69c
							<td><a href="/adminviewprofile/{{$resident->id}}">{{ $resident->name_first }} {{ $resident->name_middle }} {{ $resident->name_last }}</a></td>
							<td><a href="/adminviewprofile/{{$resident->id}}">{{ $resident->address }}</a></td>
							<td><a href="/adminviewprofile/{{$resident->id}}">{{ $resident->number_mobile }}</a></td>
							<td><a href="/adminviewprofile/{{$resident->id}}">{{ $resident->number_home }}</a></td>
						</tr>
						
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td>Resident Image</td>
						<td>Name</td>
						<td>Address</td>
						<td>Mobile Number</td>
						<td>Home Number</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

</div>

@endsection