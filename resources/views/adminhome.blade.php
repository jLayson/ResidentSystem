@extends('layouts.app')

@section('content')

<style type="text/css">
    .table > tbody > tr > td {
        vertical-align: middle;
        text-align: center;
    }
</style>

<div class="container">

    <div class="row">
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
                            <td><a href="/adminviewprofile/{{$resident->id}}">
                                @if($resident->avatar == null)
                                    <img src="{{ asset('storage/avatars/default.jpeg') }}" width="100px" height="100px" align="center">
                                @else
                                    <img src="{{ asset('storage/avatars/'.$resident->avatar) }}" width="100px" height="100px" align="center">
                                @endif
                            </a></td>
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