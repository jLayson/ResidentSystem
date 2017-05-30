<?php

namespace App\Http\Controllers;

use App\Report;
use App\ReportNature;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
	public function retrieveReportNatures(){
		$reportnatures = ReportNature::get();

		return view('reportform')->with('reportnatures', $reportnatures);
	}

	public function userFileReport(Request $request){
		$data = $request->input();
		unset($data['_token']);

		$data['submitted_by'] = Auth::id();
		$data['created_at'] = date("Y-m-d H:i:s");

		Report::insert($data);

		return redirect('userviewreports');
	}


	public function userEditReportForm($id){
		$reportnatures = ReportNature::get();
		$report = Report::where('id', '=', $id)
						->get();

		return view('reportform')->with('reportnatures', $reportnatures)->with('report', $report);
	}

	public function userEditReport(){
		$data = $request->input();
		unset($data['_token']);

		$report = Report::update($data);

		return redirect('userviewreports');
	}

	public function userWithdrawReport($id){
		$report = Report::where('id', '=', $id)
						->update([
							['is_active', 0]
						]);

		return redirect('userviewreports');
	}

	public function userViewSubmittedReports(){
		$reports = Report::join('report_natures', 'report_natures.id', '=', 'reports.report_nature')
					->select('report_natures.nature_name', 'reports.description', 'reports.location', 'reports.created_at')
					->where('submitted_by', '=', Auth::id())
					->where('is_active', '=', 1)
					->get();

		$reportnatures = ReportNature::get();

		return view('submittedreports')->with('reports', $reports)
										->with('reportnatures', $reportnatures);
	}

	public function adminListReports()
	{
		$reports = Report::join('report_natures', 'report_natures.id', '=', 'reports.report_nature')
					->join('residents', 'residents.user_id', '=', 'reports.submitted_by')
					->select('name_first', 'name_middle', 'name_last', 'report_natures.nature_name', 'reports.description', 'reports.location', 'reports.created_at')
					->orderBy('created_at', 'desc')
					->get();

		return view('adminlistreports')->with('reports', $reports);
	}

	public function ajaxReportTable(){
		$now = date('Y-m-d h:i:s');

		$reports = Report::join('report_natures', 'report_natures.id', '=', 'reports.report_nature')
					->join('residents', 'residents.user_id', '=', 'reports.submitted_by')
					->select('name_first', 'name_middle', 'name_last', 'report_natures.nature_name', 'reports.description', 'reports.location', 'reports.created_at')
					->where('reports.created_at', '>', $now)
					->orderBy('created_at', 'desc')
					->get();

		$returndata = "";

		foreach($reports as $report){
			$time_submitted = date('m-d-Y h:i:s', $reports->created_at);

			$returndata .= "<tr>
                        		<td>" . $report->nature_name . "</td>
                       			<td>" . $report->description . "</td>
                        		<td>" . $report->location . "</td>
                       		 	<td>" . $time_submitted . "</td>
                        		<td>" . $report->name_first . " " . $report->name_middle . " " . $report->name_last . "</td>
                    		</tr>";
		}

		return $returndata;
	}

	public function fileReportAJAX(Request $request){
		$data = $request->input();

		unset($data['_token']);

		$data['submitted_by'] = Auth::id();

		$report = Report::create($data);
	}

	public function residentReportTable(){

		$reports = Report::join('report_natures', 'reports.report_nature', '=', 'report_natures.id')
					->select('reports.*', 'report_natures.nature_name')
					->where('reports.is_active', '=', 1)
					->where('submitted_by', '=', Auth::id())
					->orderBy('reports.created_at', 'desc')
					->get();

		$returndata = "";

		foreach($reports as $report){

			$returndata .= "<tr>
                        		<td>" . $report->nature_name . "</td>
                       			<td>" . $report->description . "</td>
                        		<td>" . $report->location . "</td>
                       		 	<td>" . $report->created_at . "</td>
                    		</tr>";
		}

		return $returndata;
	}
}