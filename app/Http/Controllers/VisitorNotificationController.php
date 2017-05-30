<?php

namespace App\Http\Controllers;

use App\Visitor;
use App\Resident;
use App\Guest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VisitorNotificationController extends Controller
{
	public function userAddNotification(Request $request){

		$visitor = new Visitor();

		$data = $request->input();
		$data['time_expected'] = date('Y-m-d', strtotime($data['date_expected'])) . " " . date('h:i:s', strtotime($data['time_expected']));
		unset($data['date_expected']);
		unset($data['_token']);

		$user = Resident::where('user_id', '=', Auth::id())
							->get();

		$initals;

		foreach($user as $u){
			$f = substr($u->name_first, 0, 1);
			$m = substr($u->name_middle, 0, 1);
			$l = substr($u->name_last, 0, 1);

			$initials = $f[0] . $m[0] . $l[0];
		}

		$data['submitted_by'] = Auth::id();
		$data['visitor_code'] = date('ymdhi') . $initials;

		$visitor->create($data);

		return redirect('userhomepageredirect');
	}

	public function userViewSubmittedNotifications(){
		$visitors = Visitor::select('id', 'visitor_name', 'reason_for_visit', 'time_expected', 'time_arrived', 'visitor_code')
					->where('submitted_by', '=', Auth::id())
					->where('is_active', '=', 1)
					->get();

		return view('submittednotifications')->with('visitors', $visitors);
	}

	public function userEditNotificationForm($id){
		$visitor = Visitor::select('id', 'visitor_name', 'reason_for_visit', 'time_expected', 'time_arrived')
					->where([
						['submitted_by', '=', Auth::id()],
						['id', '=', $id],
					])
					->get();

		return view('visitoredit')->with('visitor', $visitor);
	}

	public function userEditNotification(Request $request){
		$data = $request->input();
		$data['time_expected'] = date('Y-m-d', strtotime($data['date_expected'])) . " " . date('h:i:s', strtotime($data['time_expected']));
		unset($data['date_expected']);
		unset($data['_token']);

		Visitor::where('id', $data["id"])
				->update($data);

		return redirect('userviewnotifications');
	}

	public function userDeleteNotification($id){

		$visitor = Visitor::find($id);

		$visitor->is_active = 0;

		$visitor->update();

		return redirect('userviewnotifications');
	}

	public function adminViewAllNotifications(){
		$visitors = Visitor::join('residents', 'visitors.submitted_by', '=', 'user_id')
					->select('visitors.*', 'visitors.created_at', 'residents.name_first', 'residents.name_middle', 'residents.name_last')
					->orderBy('created_at', 'desc')
					->get();

		/*foreach($visitors as $v){
			$v->submitted_by = $v->name_first . " " . $v->name_middle . " " . $v->name_last;
		}

		$total = ceil(count($visitors)/20);*/

		return view('adminlistnotifications')->with('visitors', $visitors);
	}

	public function adminViewPendingNotifications(){
		$now = date('Y-m-d h:i:s'); 

		$visitors = Visitor::join('residents', 'visitors.submitted_by', '=', 'user_id')
					->select('visitors.*', 'visitors.created_at', 'residents.name_first', 'residents.name_middle', 'residents.name_last')
					->where([
						['time_arrived', null],
						['time_expected', '>', $now]
					])
					->orderBy('created_at', 'desc')
					->get();

		/*foreach($visitors as $v){
			$v->submitted_by = $v->name_first . " " . $v->name_middle . " " . $v->name_last;
		}

		$total = ceil(count($visitors)/20);*/

		return view('adminlistnotifications')->with('visitors', $visitors);
	}

	public function adminVerifyNotification($id){
		$now = date("Y-m-d h:i:s");

		$visitors = Visitor::where('id', $id)
							->update(['time_arrived' => $now]);

		return redirect('listnotifications/0');
	}

	public function visitorGetAjaxForm($offset){
		$visitors = Visitor::join('residents', 'residents.user_id', '=', 'submitted_by')
					->select('visitors.id', 'name_first', 'name_middle', 'name_last', 'visitor_name', 'reason_for_visit', 'time_expected', 'time_arrived')
					->offset($offset * 20)
					->limit(20)
					->get();

		foreach($visitors as $v){
			$v->submitted_by = $v->name_first . " " . $v->name_middle . " " . $v->name_last;
		}

		$total = ceil(count($visitors)/20);

		return view('visitortable')->with('visitors', $visitors)->with('total', $total);
	}

	public function visitorGetAjax(Request $request){
		$data = $request->input();
		
		$returndata = "";

		$data['dateStart'] = date('Y-m-d', strtotime($data['dateStart']));
		$data['dateEnd'] = date('Y-m-d', strtotime($data['dateEnd']));

		$visitors = Visitor::join('residents', 'residents.user_id', '=', 'submitted_by')
							->select('visitors.id', 'name_first', 'name_middle', 'name_last', 'visitor_name', 'reason_for_visit', 'time_expected', 'time_arrived')
							->whereBetween('time_expected', array($data['dateStart'], $data['dateEnd']))
							->offset(0)
							->limit(20)
							->get();

		foreach($visitors as $v)
		{
			$time = date("d-m-Y h:i:s", strtotime($v->time_expected));
			$id = $v->id;
			$url = "\"{{ url('/editnotification') . " . $id .  " }}\"";

			$returndata .= "<tr>
								<td>" . $v->visitor_name . " </td>
								<td>" . $v->reason_for_visit . " </td>
								<td>" . $time . " </td>
								<td>" . $v->time_arrived . " </td>
								<td>" . $v->visitor_code . " </td>
								<td>
									<a href=" . $url . "<button type=\"button\" class=\"btn btn-info btn-block\">Edit</button></a>
									<button type=\"button\" class=\"btn btn-info btn-block\" data-toggle=\"modal\" data-target=\"#deleteModal\">Delete</button>
								</td>
							</tr>";
		}

		return $returndata;
	}

	public function userHomepageRedirect(){
		$visitors = Visitor::select('id', 'visitor_name', 'reason_for_visit', 'time_expected', 'time_arrived', 'visitor_code')
					->where('submitted_by', '=', Auth::id())
					->where('is_active', '=', 1)
					->get();

		return view('userhome')->with('visitors', $visitors);
	}


	public function getSecurityHome(){
		$now = date('Y-m-d');

		$residents = Resident::get();

		$visitors = Visitor::join('residents', 'visitors.submitted_by', '=', 'user_id')
					->select('visitors.*', 'visitors.created_at', 'residents.name_first', 'residents.name_middle', 'residents.name_last')
					->where([
						['time_arrived', null],
						['time_expected', '>', $now]
					])
					->orderBy('created_at', 'desc')
					->get();

		$guests = Guest::leftjoin('residents', 'guests.person_to_visit', 'residents.id')
						->where('is_active', 1)
						->where([
							['guests.created_at', '>', $now]
						])
						->select('guests.*', 'residents.name_first', 'residents.name_middle', 'residents.name_last')
						->get();

		return view('securityhomepage')->with('visitors', $visitors)->with('residents', $residents)->with('guests', $guests);	
	}

	public function ajaxVisitorTable(){
		$now = date('Y-m-d h:i:s');

		$returndata = "";

		$visitors = Visitor::join('residents', 'visitors.submitted_by', '=', 'user_id')
					->select('visitors.*', 'visitors.created_at', 'residents.name_first', 'residents.name_middle', 'residents.name_last')
					->where([
						['time_arrived', null],
						['time_expected', '>', $now]
					])
					->orderBy('created_at', 'desc')
					->get();

		foreach($visitors as $visitor){
			$name = $visitor->name_first . " " . $visitor->name_second . " " . $visitor->name_last;
			$te = explode(" ", $visitor->time_expected);
			$now = strtotime(date('Y-m-d h:i:s'));

			if((strtotime($visitor->time_expected) > $now) && ($visitor->time_arrived == null)){
				$button = "<a href\"/verifynotification/{{ id }}\"><button type=\"button\" class=\"btn btn-info btn-block\">Verify</button></a>";
			}

			$returndata .= "<tr>
								<td>" . $name . "</td>
								<td>" . $visitor->visitor_name . "</td>
								<td>" . $te[0] . "</td>
								<td>" . $te[1] . "</td>
								<td>" . $visitor->visitor_code . "</td>
								<td>" . $button . "</td>
							</tr>";
		}

		return $returndata;
	}
}