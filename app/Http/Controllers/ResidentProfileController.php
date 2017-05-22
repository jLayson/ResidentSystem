<?php

namespace App\Http\Controllers;

use App\Resident;
use App\Report;
use App\ReportNature;
use App\Visitor;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ResidentProfileController extends Controller
{
	public function userViewProfile(){
		$resident = Resident::where('user_id', '=', Auth::id())->first();

		if(!($resident)){
			$resident = Resident::insert(['user_id' => Auth::id()]);
		}

		$resident = Resident::join('users', 'users.id', '=', 'residents.user_id')
					->select('users.id',  'residents.name_first', 'residents.name_middle', 'residents.name_last',
								'residents.address', 'residents.number_home', 'residents.number_mobile', 'residents.birth_date')
					->where('users.id', '=', Auth::id())
					->get();

		return view('profileform')->with('resident', $resident);	
	}

	public function userEditProfile(Request $request){
		$data = $request->input();
		unset($data['_token']);
		$data['birth_date'] = date("Y-m-d", strtotime($data['birth_date']));

		Resident::where('user_id', Auth::id())
					->update($data);

		return redirect('viewprofile');
	}

	public function adminViewProfile($userId){
		$now = date('Y-m-d h:i:s');

		$resident = Resident::join('users', 'users.id', '=', 'residents.user_id')
					->select('users.id',  'residents.name_first', 'residents.name_middle', 'residents.name_last',
								'residents.address', 'residents.number_home', 'residents.number_mobile', 'residents.birth_date')
					->where('users.id', '=', $userId)
					->get();
		$visitors = Visitor::where('visitors.submitted_by', '=', $userId)
					->count();
		$visitorspending = Visitor::where([
										['visitors.submitted_by', '=', $userId],
										['visitors.time_expected', '>', $now]
									])
									->count();

		return view('adminviewresident')->with('resident', $resident)->with('visitors', $visitors)->with('visitorspending', $visitorspending);
	}

	public function adminViewListProfiles($offset){
		if(!isset($offset)){
			$offset = 0;
		}else{
			$offset = 0;
		}

		$residents = Resident::join('users', 'users.id', '=', 'residents.user_id')
					->select('users.id',  'residents.name_first', 'residents.name_middle', 'residents.name_last',
								'residents.address', 'residents.number_home', 'residents.number_mobile', 'residents.birth_date')
					->offset($offset * 20)
					->limit(20)
					->orderBy('residents.id', 'desc')
					->get();

		$total = ceil(count($residents)/20);

		return view('adminlistresidents')->with('residents', $residents)->with('total', $total);
	}
}