@extends('layouts.app')

@section('content')
<div class="container-fluid">

	<div class="row">

	<div class="col-md-3">

		<div class="panel panel-default">
                <div class="panel-heading">File Report</div>
                <div class="panel-body">

                <div id="reportSuccess" class="well" style="background-color:#006dcc" hidden>
                    <p style="color:#E5E5E5">Report Successfully Filed</p>
                </div>

                    <!-- <form class="form-horizontal" role="form" method="POST" action="{{ url('/submitreport') }}"> -->
                    <div class="form-group">

                        <div class="col-sm-12">
                            <div class="row">
                            <label for="report_nature" class="col-md-4 control-label">Nature of Violation</label>
                            <div class="col-md-8">
                                <select id="report_nature" name="report_nature" class="form-control">
                                    @foreach($reportnatures as $rn)
                                        <option value='{{ $rn->id }}'>{{ $rn->nature_name }}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <label for="description" class="col-md-4 control-label">Description (Describe perpetrators' actions, appearance, etc.)</label>
                            <div class="col-md-8">
                                <textarea  id="description" type="text" class="form-control" name="description" required autofocus></textarea>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <label for="location" class="col-md-4 control-label">Location (Where violation is happening)</label>
                            <div class="col-md-8">
                                <textarea  id="location" type="text" class="form-control" name="location" required autofocus></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-md-offset-4">
                                <button id="submitReport" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                        </div>
                        
                    <!-- </form> -->
                    </div>
                </div>
            </div>
	</div>

		<div class="col-md-9">
			<table class="table table-bordered table-striped" id="dataTableV2">
				<thead>
					<tr>
						<td>Report Nature</td>
						<td>Description</td>
						<td>Location</td>
						<td>Time Submitted</td>
					</tr>
				</thead>
				<tbody id="residentReportTable">
					@foreach($reports as $report)
						<tr>
							<td>{{ $report->nature_name }}</td>
							<td>{{ $report->description }}</td>
							<td>{{ $report->location }}</td>
							<td>{{ $report->created_at }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection

@section('pageJS')
    <script src="{{ URL::asset('js/custom/residentReport.js') }}"></script>
@endsection