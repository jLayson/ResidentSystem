<?php

namespace App\Http\Controllers;

use App;
use PDF;
use App\Resident;
use App\Visitor;
use App\Report;
use App\Guest;
use Illuminate\Http\Request;
use App\Http\Requests;


class PdfExportController extends Controller
{

	//Export Resident List To PDF
    public function residentExport()
    {
    	$resident = Resident::all();

    	$pdf = PDF::loadView('exporttopdf');

    	$html = '<html>' . 
					'<style>' .
		    			'table {
						    border-collapse: collapse;
						}

						table, th, td {
							padding: 5px;
						    border: 1px solid black;
						    text-align: center;
						}' .
                        'h3 {
                            text-align: center;
                        }' .
					'</style>' .
    				'<body>' .
                        '<h3> Resident List </h3><br>' .
    					'<table align="center" style="margin: 0px auto;">' . 
    						'<thead>' .
    							'<tr>' .
    								'<th><b>Resident Image</b></th>' .
    								'<th><b>Name</b></th>' . 
    								'<th><b>Address</b></th>' . 
    								'<th><b>Mobile Number</b></th>' .
    								'<th><b>Home Number</b></th>' .
    							'</tr>' .
    						'</thead>' .
    						'<tbody>'; 

    	foreach ($resident as $details) 
    	{ 
    		$html .= 	"<tr>" .
    					"<td>" . "<img src='storage/avatars/". $details->avatar ."' width='100px' height='100px'/>" . "</td>" .
    					"<td>" . $details->name_first . " " . $details->name_middle . " " . $details->name_last . "</td>" . 
    					"<td>" . $details->address . "</td>" . 
    					"<td>" . $details->number_mobile . "</td>" .
    					"<td>" . $details->number_home . "</td>" .
    					"</tr>"; 
    	} 
    		$html .= 	'</tbody>' . 
    						'</table>' .
    							'</body>' . 
    								'</html>'; 

    		$pdf->loadHTML($html); 

    		return $pdf->stream('Resident List');
    }

    //Export Report Lists To PDF
    public function reportExport()
    {
    	$report = Report::join('report_natures', 'reports.report_nature', '=', 'report_natures.id')
                            ->join('residents', 'reports.submitted_by', '=', 'user_id')
                            ->select('reports.*', 'residents.name_first', 'residents.name_middle', 'residents.name_last', 'report_natures.nature_name')
                            ->get();

    	$pdf = PDF::loadView('exporttopdf');

    	$html = '<html>' . 
					'<style>' .
		    			'table {
						    border-collapse: collapse;
						    align: center;
						}

						table, th, td {
							padding-left: 5px;
							padding-right: 5px;
						    border: 1px solid black;
						    text-align: center;
						}' .
                        'h3 {
                            text-align: center;
                        }' .
					'</style>' .
    				'<body>' .
                        '<h3> Reports List </h3><br>' .
    					'<table>' . 
    						'<thead>' .
    							'<tr>' .
    								'<th><b>Report Nature</b></th>' .
    								'<th><b>Description</b></th>' . 
    								'<th><b>Location</b></th>' . 
    								'<th><b>Time Submitted</b></th>' .
    								'<th><b>Submitted By</b></th>' .
    							'</tr>' .
    						'</thead>' .
    						'<tbody>'; 

    	foreach ($report as $details) 
    	{ 
    		$html .= 	"<tr>" .
    					"<td>" . $details->nature_name . "</td>" .
    					"<td>" . $details->description . "</td>" . 
    					"<td>" . $details->location . "</td>" . 
    					"<td>" . $details->created_at . "</td>" .
    					"<td>" . $details->name_first . " " . $details->name_middle . " " . $details->name_last . "</td>" .
    					"</tr>"; 
    	} 
    		$html .= 	'</tbody>' . 
    						'</table>' .
    							'</body>' . 
    								'</html>'; 

    		$pdf->loadHTML($html); 

    		return $pdf->stream('Report List');
    }

    //Export Visitor Notification to PDF
    public function visitorNotifExport()
    {
    	$visitor = Visitor::join('residents', 'visitors.submitted_by', '=', 'user_id')
    						->select('visitors.*', 'residents.*')
    						->get();

    	$pdf = PDF::loadView('exporttopdf');

    	$html = '<html>' . 
					'<style>' .
		    			'table {
						    border-collapse: collapse;
						}

						table, th, td {
							padding-left: 5px;
							padding-right: 5px;
						    border: 1px solid black;
						    text-align: center;
						    font-size: 12px;
						}
						h3 {
							text-align: center;
						}' .
					'</style>' .
    				'<body>' .
    					'<h3> Visitor Notification List </h3><br>' .
    					'<table align="center">' . 
    						'<thead>' .
    							'<tr>' .
    								'<th><b>Submitted By</b></th>' .
    								'<th><b>Visitor Name</b></th>' . 
    								'<th><b>Reason for Visit</b></th>' . 
    								'<th><b>Expected Time of Arrival</b></th>' .
    								'<th><b>Time Arrived</b></th>' .
    								'<th><b>Visitor Code</b></th>' .
    							'</tr>' .
    						'</thead>' .
    						'<tbody>'; 

    	foreach ($visitor as $details) 
    	{ 
    		$html .= 	"<tr>" .
    					"<td>" . $details->name_first . " " . $details->name_middle . " " . $details->name_last . "</td>" .
    					"<td>" . $details->visitor_name . "</td>" . 
    					"<td>" . $details->reason_for_visit . "</td>" . 
    					"<td>" . $details->time_expected . "</td>" .
    					"<td>" . $details->time_arrived . "</td>" .
    					"<td>" . $details->visitor_code . "</td>" .
    					"</tr>"; 
    	} 
    		$html .= 	'</tbody>' . 
    						'</table>' .
    							'</body>' . 
    								'</html>'; 

    		$pdf->loadHTML($html); 

    		return $pdf->stream('Visitor Notification List');
    }

    //Export Guests to PDF
    public function guestExport()
    {
        $guest = Guest::join('residents', 'guests.person_to_visit', '=', 'user_id')
                            ->select('guests.name', 'guests.reason', 'guests.person_to_visit', 'guests.vehicle_plate', 'guests.time_departed', 'guests.created_at', 'residents.name_first', 'residents.name_middle', 'residents.name_last')
                            ->where('is_active', 1)
                            ->get();

        $pdf = PDF::loadView('exporttopdf');

        $html = '<html>' . 
                    '<style>' .
                        'table {
                            border-collapse: collapse;
                        }

                        table, th, td {
                            padding-left: 5px;
                            padding-right: 5px;
                            border: 1px solid black;
                            text-align: center;
                            font-size: 12px;
                        }
                        h3 {
                            text-align: center;
                        }' .
                    '</style>' .
                    '<body>' .
                        '<h3> Visitor Notification List </h3><br>' .
                        '<table align="center">' . 
                            '<thead>' .
                                '<tr>' .
                                    '<th><b>Guest Name</b></th>' .
                                    '<th><b>Reason for Visit</b></th>' . 
                                    '<th><b>Person to Visit</b></th>' . 
                                    '<th><b>Vehicle Plate</b></th>' .
                                    '<th><b>Time Arrived</b></th>' .
                                    '<th><b>Time Departed</b></th>' .
                                '</tr>' .
                            '</thead>' .
                            '<tbody>'; 

        foreach ($guest as $details) 
        { 
            $html .=    "<tr>" .
                        "<td>" . $details->name . "</td>" .
                        "<td>" . $details->reason . "</td>" . 
                        "<td>" . $details->name_first . " " . $details->name_middle . " " . $details->name_last . "</td>" . 
                        "<td>" . $details->vehicle_plate . "</td>" .
                        "<td>" . $details->created_at . "</td>" .
                        "<td>" . $details->time_departed . "</td>" .
                        "</tr>"; 
        } 
            $html .=    '</tbody>' . 
                            '</table>' .
                                '</body>' . 
                                    '</html>'; 

            $pdf->loadHTML($html); 

            return $pdf->stream('Guest List');
    }

}
