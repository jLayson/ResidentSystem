<?php

namespace App\Http\Controllers;

use App\Guest;
use App\Resident;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
	public function addGuestForm(){
		$residents = Resident::get();

		return view('adminguestform')->with('residents', $residents);
	}

	public function addGuestRecord(Request $request){
		$data = $request->input();
		unset($data['_token']);

		$guest = Guest::create($data);

		return redirect('listguests');
	}

	public function updateGuestDeparture($id){
		$now = date("Y-m-d h:i:s");

		$guest = Guest::find($id);

		$guest->time_departed = $now;

		$guest->save();

		$residents = Resident::get();

		$guests = Guest::leftjoin('residents', 'guests.person_to_visit', 'residents.id')
						->where('is_active', 1)
						->select('guests.*', 'residents.name_first', 'residents.name_middle', 'residents.name_last')
						->orderBy('guests.created_at', 'desc')
						->get();

		return view('adminlistguests')->with('guests', $guests)
										->with('residents', $residents);
	}

	public function editGuestDetails(Request $request, $id){
		
		$guest = Guest::find($id);

		if($request->input('name') != null) {
            $guest->name = $request->input('name');
        }

        if($request->input('reason') != null) {
            $guest->reason = $request->input('reason');
        }

        if($request->input('person_to_visit') != null) {
            $guest->person_to_visit = $request->input('person_to_visit');
        }

        if($request->input('plate') != null) {
            $guest->vehicle_plate = $request->input('plate');
        }

		$guest->update();

		$residents = Resident::get();
		
		$guests = Guest::leftjoin('residents', 'guests.person_to_visit', 'residents.id')
						->where('is_active', 1)
						->select('guests.*', 'residents.name_first', 'residents.name_middle', 'residents.name_last')
						->get();

		return view('adminlistguests')->with('guests', $guests)
										->with('residents', $residents);
	}

	public function listGuestRecord(){

		$residents = Resident::get();
		
		$guests = Guest::leftjoin('residents', 'guests.person_to_visit', 'residents.id')
						->where('is_active', 1)
						->select('guests.*', 'residents.name_first', 'residents.name_middle', 'residents.name_last')
						->get();

		return view('adminlistguests')->with('guests', $guests)
										->with('residents', $residents);
	}

}