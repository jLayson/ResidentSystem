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

		$data['name'] = $data['name_first'] . " " . $data['name_middle'] . " " . $data['name_last'];

		unset($data['name_first']);
		unset($data['name_middle']);
		unset($data['name_last']);

		$guest = Guest::create($data);

		return redirect('listguests');
	}

	public function updateGuestDeparture($id){
		$now = date("Y-m-d h:i:s");

		$report = Report::where('id', '=', $id)
						->update([
								['time_departed' => $now]
							]);

		return redirect('userviewreports');
	}

	public function editGuestDetails($id){
		$data = $request->input();
		unset($data['_token']);

		$data['name'] = $data['name_first'] . " " . $data['name_middle'] . " " . $data['name_last'];

		unset($data['name_first']);
		unset($data['name_middle']);
		unset($data['name_last']);

		$report = Report::where('id', '=', $id)
						->update($data);

		return redirect('userviewreports');
	}

	public function listGuestRecord(){
		$guests = Guest::join('residents', 'guests.person_to_visit', '=', 'user_id')
						->select('guests.*', 'residents.name_first', 'residents.name_middle', 'residents.name_last')
						->orderBy('created_at', 'desc')
						->paginate(10);

		return view('adminlistguests')->with('guests', $guests);
	}

}