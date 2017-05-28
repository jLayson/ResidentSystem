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
					->get();

		return view('submittedreports')->with('reports', $reports);
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
}