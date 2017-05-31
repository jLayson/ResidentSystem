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
								'residents.address', 'residents.number_home', 'residents.number_mobile', 'residents.birth_date', 'residents.avatar')
					->where('users.id', '=', Auth::id())
					->get();

		return view('profileform')->with('resident', $resident);	
	}

	public function userEditProfile(Request $request){
		$data = $request->input();
		unset($data['_token']);
		$data['birth_date'] = date("Y-m-d", strtotime($data['birth_date']));

			$file = $request->file('avatar');

			$name = $request->input('name_last');

			if($request->hasFile('avatar'))
			{

				$ext = $file->guessClientExtension();

				$file->storeAs('public/avatars/', "{$name}.{$ext}");

				$explode = $file->storeAs('public/avatars/', "{$name}.{$ext}");

				$image = explode('/', $explode);

				$imageName = $image[3];

				$data['avatar'] = $imageName;

			}

		Resident::where('user_id', Auth::id())
					->update($data);

		return redirect('viewprofile');
	}

	public function adminViewProfile($userId){
		$now = date('Y-m-d h:i:s');

		$resident = Resident::join('users', 'users.id', '=', 'residents.user_id')
					->select('users.id',  'residents.name_first', 'residents.name_middle', 'residents.name_last',
								'residents.address', 'residents.number_home', 'residents.number_mobile', 'residents.birth_date', 'residents.avatar')
					->where('users.id', '=', $userId)
					->get();
		$visitors = Visitor::where('visitors.submitted_by', '=', $userId)
					->count();

		$reports = Report::where('reports.submitted_by', '=', $userId)
					->count();

		$visitorspending = Visitor::where([
										['visitors.submitted_by', '=', $userId],
										['visitors.time_expected', '>', $now]
									])
									->count();

		return view('adminviewresident')->with('resident', $resident)
		->with('visitors', $visitors)
		->with('visitorspending', $visitorspending)
		->with('reports', $reports);
	}

	public function adminViewListProfiles()
	{
		$residents = Resident::join('users', 'users.id', '=', 'residents.user_id')
					->select('users.id',  'residents.name_first', 'residents.name_middle', 'residents.name_last',
								'residents.address', 'residents.number_home', 'residents.number_mobile', 'residents.birth_date', 'residents.avatar')
					->orderBy('residents.id', 'desc')
					->get();

		return view('adminlistresidents')->with('residents', $residents);
	}

	public function adminHomePage()
	{
		$residents = Resident::join('users', 'users.id', '=', 'residents.user_id')
					->select('users.id',  'residents.name_first', 'residents.name_middle', 'residents.name_last',
								'residents.address', 'residents.number_home', 'residents.number_mobile', 'residents.birth_date', 'residents.avatar')
					->orderBy('residents.id', 'desc')
					->get();

		return view('adminhome')->with('residents', $residents);
	}
}