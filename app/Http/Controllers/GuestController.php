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

		$guests = Guest::leftjoin('residents', 'guests.person_to_visit', 'residents.id')
						->where('is_active', 1)
						->select('guests.*', 'residents.name_first', 'residents.name_middle', 'residents.name_last')
						->orderBy('guests.created_at', 'desc')
						->get();

		return view('adminlistguests')->with('guests', $guests);
	}

	public function editGuestDetails($id){
		$data = $request->input();
		unset($data['_token']);

		$data['name'] = $data['name_first'] . " " . $data['name_middle'] . " " . $data['name_last'];

		unset($data['name_first']);
		unset($data['name_middle']);
		unset($data['name_last']);

		$guest = Guest::where('id', '=', $id)
						->update($data);

		return redirect('adminlistguests');
	}

	public function listGuestRecord(){
		
		$guests = Guest::leftjoin('residents', 'guests.person_to_visit', 'residents.id')
						->where('is_active', 1)
						->select('guests.*', 'residents.name_first', 'residents.name_middle', 'residents.name_last')
						->get();

		return view('adminlistguests')->with('guests', $guests);
	}

}