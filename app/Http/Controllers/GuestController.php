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

	public function addGuestAjax(Request $request){
		$data = $request->input();
		$data['name'] = $data['name_first'] . " " . $data['name_middle'] . " " . $data['name_last'];

		unset($data['_token']);

		$guest = Guest::create($data);
	}

	public function ajaxGuestTable(){
		$dnow = date('Y-m-d');
		$resname = "";
		$timedep;
		$button = "";

		$returndata = "";

		$guests = Guest::leftjoin('residents', 'guests.person_to_visit', 'residents.id')
						->where('is_active', 1)
						->where('guests.created_at', '>', $dnow)
						->select('guests.*', 'residents.name_first', 'residents.name_middle', 'residents.name_last')
						->orderBy('created_at', 'desc')
						->get();

		foreach($guests as $guest){
			$created_at = date('m-d-Y h:i:s', strtotime($guest->created_at));

			if($guest->person_to_visit == 0)
			{
				$resname = "N/A";
			}else{
				$resname = $guest->name_first . " " . $guest->name_middle . " " . $guest->name_last;
			}

			if($guest->time_departed == null){
				$timedep = "";
			}else{
				$timedep = date('m-d-Y h:i:s', strtotime($guest->time_departed));
			}

			if($timedep == ""){
				$button = "<div class=\"btn-group\" role=\"group\">
                                <button class=\"btn btn-default btn-sm\" id=\"btnDetails\" data-toggle=\"modal\" data-target=\"" . $guest->id . "\" data-backdrop=\"static\" data-keyboard=\"true\">Update</button>
                                <button class=\"btn btn-default btn-sm\"><a href=\"/guestdeparture/" . $guest->id . "\" style=\"color:#E5E5E5\">Left</a></button>
                            </div>";
			}

			$returndata .= "<tr>
                        <td>" . $guest->name . "</td>
                        <td>" . $guest->reason . "</td>
                        <td>" . $resname . "</td>
                        <td class=\"col-md-1\">" . $guest->vehicle_plate . "</td>
                        <td class=\"col-md-1\">" . $created_at . "</td>
                        <td class=\"col-md-1\">" . $timedep . "</td>
                        <td>" . $button . "</td>
                    </tr>";
        }

        return $returndata;
	}

}