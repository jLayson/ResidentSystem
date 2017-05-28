<?php

namespace App\Http\Controllers;

use App\Visitor;

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

		$data['submitted_by'] = Auth::id();
		$data['visitor_code'] = date('Ymdhis') . Auth::id(); 

		$visitor->create($data);

		return redirect('userviewnotifications');
	}

	public function userViewSubmittedNotifications(){
		$visitors = Visitor::select('id', 'visitor_name', 'reason_for_visit', 'time_expected', 'time_arrived')
					->where('submitted_by', '=', Auth::id())
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

	/*public function userDeleteNotification($id){
		$visitor = Visitor::where('id', '=', $id)
					->
		
	}*/

	public function adminViewAllNotifications(){
		$visitors = Visitor::join('residents', 'residents.user_id', '=', 'submitted_by')
					->select('visitors.id', 'residents.name_first', 'residents.name_middle', 'residents.name_last', 'visitor_name', 'reason_for_visit', 'time_expected', 'time_arrived')
					->paginate(10);

		/*foreach($visitors as $v){
			$v->submitted_by = $v->name_first . " " . $v->name_middle . " " . $v->name_last;
		}

		$total = ceil(count($visitors)/20);*/

		return view('adminlistnotifications')->with('visitors', $visitors);
	}

	public function adminViewPendingNotifications(){
		$now = date('Y-m-d h:i:s'); 

		$visitors = Visitor::join('residents', 'residents.user_id', '=', 'submitted_by')
					->select('visitors.id', 'name_first', 'name_middle', 'name_last', 'visitor_name', 'reason_for_visit', 'time_expected', 'time_arrived')
					->where([
						['time_arrived', null],
						['visitors.time_expected', '>', $now]
					])
					->paginate(10);

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
}