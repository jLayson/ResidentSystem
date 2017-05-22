@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">File Report</div>
                <div class="panel-body">

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/submitreport') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="report_nature" class="col-md-4 control-label">Nature of Violation</label>
                            <div class="col-md-6">
                                <select id="report_nature" name="report_nature" class="form-control">
                                    @foreach($reportnatures as $rn)
                                        <option value='{{ $rn->id }}'>{{ $rn->nature_name }}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Description (Describe perpetrators' actions, appearance, etc.)</label>
                            <div class="col-md-6">
                                <textarea  id="description" type="text" class="form-control" name="description" required autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location" class="col-md-4 control-label">Location (Where violation is happening)</label>
                            <div class="col-md-6">
                                <textarea  id="location" type="text" class="form-control" name="location" required autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                        
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
