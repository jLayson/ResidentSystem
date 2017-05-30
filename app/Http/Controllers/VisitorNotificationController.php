<?php

namespace App\Http\Controllers;

use App\Visitor;
use App\Resident;
use App\Guest;
use App\Report;

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

		return redirect('userhomepageredirect');
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

		$reports = Report::join('report_natures', 'report_natures.id', '=', 'reports.report_nature')
					->join('residents', 'residents.user_id', '=', 'reports.submitted_by')
					->select('name_first', 'name_middle', 'name_last', 'report_natures.nature_name', 'reports.description', 'reports.location', 'reports.created_at')
					//->where('reports.created_at', '>', $now)
					->orderBy('created_at', 'desc')
					->get();

		return view('securityhomepage')->with('visitors', $visitors)->with('residents', $residents)->with('guests', $guests)->with('reports', $reports);	
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
			$now = strtotime(date('Y-m-d h:i:s'));
			$time_expected = date('m-d-Y h:i:s', strtotime($visitor->time_expected));

			if((strtotime($visitor->time_expected) > $now) && ($visitor->time_arrived == null)){
				$button = "<a href\"/verifynotification/{{ id }}\"><button type=\"button\" class=\"btn btn-info btn-block\">Verify</button></a>";
			}

			$returndata .= "<tr>
								<td>" . $name . "</td>
								<td>" . $visitor->visitor_name . "</td>
								<td>" . $time_expected . "</td>
								<td>" . $visitor->visitor_code . "</td>
								<td>" . $button . "</td>
							</tr>";
		}

		return $returndata;
	}

	//AJAX add visitor
/*	public function residentAddVisitorAJAX(Request $request){
		$visitor = new Visitor();

		$time = $request->input('time_expected');
		$date = $request->input('date_expected');
		$timeDate = date('Y-m-d', strtotime($date)) . " " . date('h:i:s', strtotime($time));

		$visitor->submitted_by = Auth::id();
		$visitor->visitor_name = $request->input('visitor_name');
		$visitor->reason_for_visit = $request->input('reason_for_visit');
		$visitor->time_expected = $timeDate;
		

			$user = Resident::where('user_id', '=', Auth::id())
							->get();

			$initals;

			foreach($user as $u){
				$f = substr($u->name_first, 0, 1);
				$m = substr($u->name_middle, 0, 1);
				$l = substr($u->name_last, 0, 1);

				$initials = $f[0] . $m[0] . $l[0];
			}

			$visitor->visitor_code = date('ymdhi') . $initials;

		$visitor->save();
	}*/
/*
	public function residentGetVisitorAJAX(){

		$visitors = Visitor::select('id', 'visitor_name', 'reason_for_visit', 'time_expected', 'time_arrived', 'visitor_code')
					->where('submitted_by', '=', Auth::id())
					->where('is_active', '=', 1)
					->get();

		$returndata = "";

		foreach($visitors as $visitor){

			$button = "<div class='btn-group' role='group'>
						<button type='button' class='btn btn-primary btn-sm'><a href='/editnotification/{{ $visitor->id }}' style='color:#FFFFFF'>Edit</a></button>
						<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#deleteModal'>Delete</button>
					</div>";

			$returndata .= "<tr>
                        		<td>" . $visitor->visitor_name . "</td>
                       			<td>" . $visitor->reason_for_visit . "</td>
                        		<td>" . $visitor->time_expected . "</td>
                       		 	<td>" . $visitor->time_arrived . "</td>
                       		 	<td>" . $visitor->visitor_code . "</td>
                       		 	<td>" . $button . "</td>
                    		</tr>";
		}

		return $returndata;
	}*/
}