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
		$timedep = null;
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
				
			}else{
				$timedep = date('m-d-Y h:i:s', strtotime($guest->time_departed));
			}

			if($timedep != null){
				$button = "<div class=\"btn-group\" role=\"group\">
                                <button class=\"btn btn-default btn-sm btn-lft\" id=\"leftButton\" name=\"leftButton\" value=\"" . $guest->id . "\">Left</button>
                            </div>";
			}

			$returndata .= "<tr>
                        <td>" . $guest->name . "<input type=\"hidden\" id=\"uid\" value=\"" . $guest->id . "\"></td>
                        <td>" . $guest->reason . "</td>
                        <td>" . $resname . "</td>
                        <td class=\"col-md-1\">" . $guest->vehicle_plate . "</td>
                        <td class=\"col-md-1\">" . $created_at . "</td>
                        <td class=\"col-md-1\">" . $timedep . "</td>
                        <td>" . $button . "</td>
                    </tr>

                    <div class=\"modal fade\" id=\"{{$guest->id}}view\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
                <div class=\"modal-dialog\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                            <h4 class=\"modal-title\" id=\"myModalLabel\"><b>Edit Row</b></h4>
                        </div>
                    <div class=\"modal-body\">
                            <form id=\"my_form\" class=\"form-horizontal\" role=\"form\" method=\"POST\" action=\"/guestupdate/{{$guest->id}}\">
                            {{ csrf_field() }}

                                <div class=\"form-group row\">
                                    <div class=\"col-md-12\">
                                        <input type=\"text\" class=\"form-control\" placeholder=\"Name\" id=\"name\" name=\"name\" value=" . $guest->name . " required>
                                    </div>
                                </div>

                                <div class=\"form-group row\">
                                    <div class=\"col-md-12\">
                                        <input type=\"text\" class=\"form-control\" placeholder=\"Reason for Visit\" id=\"reason\" name=\"reason\" value=" . $guest->reason . " required>
                                    </div>
                                </div>

                                <div class=\"form-group row\">
                                    <div class=\"col-md-12\">
                                        <select id=\"person_to_visit\" name=\"person_to_visit\" class=\"form-control\">
                                   
                                            @if(\$guest->person_to_visit == 0)
                                                <option value=\"0\" selected>N/A</option>
                                            @else
                                                <option value=\"0\">N/A</option>
                                            @endif

                                            @foreach(\$residents as \$resident)

                                                @if(\$guest->person_to_visit == \$resident->id)
                                                    <option value='{{ \$resident->id }}' selected>{{ \$resident->name_first }} {{ \$resident->name_last }}</option>
                                                @else
                                                    <option value='{{ \$resident->id }}'>{{ \$resident->name_first }} {{ \$resident->name_last }}</option>
                                                @endif

                                            @endforeach

                                        </select> 
                                    </div>
                                </div>

                                <div class=\"form-group row\">
                                    <div class=\"col-md-12\">
                                        <input type=\"text\" class=\"form-control\" placeholder=\"Vehicle Plate\" id=\"plate\" name=\"plate\" value=" . $guest->vehicle_plate . " required>
                                    </div>
                                </div>
                                    
                                <div class=\"form-group row\">        
                                    <div class=\"text-center\">
                                        <button type=\"submit\" class=\"btn btn-primary\">Update</button>
                                    </div>
                                </div>

                            </form>
                        <div class=\"modal-footer\">
                        </div>

                        </div>
                    </div>
                </div>
            </div>";
        }

        return $returndata;
	}

	public function ajaxGuestLeft(Request $request){
		$data = $request->input();
		unset($data['_token']);

		$now = date('Y-m-d h:i:s');

		$guest = Guest::where('id', '=', $data['user_id'])
						->update(['time_departed' => $now]);

		return var_dump($data);
	}

}