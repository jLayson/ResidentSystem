<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <!-- DateTime Styles -->
    <link href="{{ URL::asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/bootstrap-timepicker.css') }}" rel="stylesheet">
    <!-- Datatables Styles -->
    <link href="{{ URL::asset('datatable/jquery.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('MDB/css/mdb.min.css') }}" rel="stylesheet">
    
    <style type="text/css">
        .table > tbody > tr > td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
    
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-toggleable-md navbar-dark bg-primary navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Resident System') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <!-- <li><a href="{{ url('/register') }}">Register</a></li> -->
                        @elseif(Auth::user()->account_type == 0)
                            <li><a href="{{ url('/viewprofile') }}">My Profile</a></li>
                            <!-- <li><a href="{{ url('/filereport') }}">File Report</a></li> -->
                            <li><a href="{{ url('/userviewreports') }}">Reports</a></li>
                            <li><a href="{{ url('/filevisitornotification') }}">Submit Visitor Notification</a></li>
                            <!-- <li><a href="{{ url('/userviewnotifications') }}">My Visitor Notifications</a></li> -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @elseif(Auth::user()->account_type == 1)
                            <li><a href="{{ url('/listprofiles') }}">Users</a></li>
                            <li><a href="{{ url('/listreports') }}">Reports</a></li>
                            <li><a href="{{ url('/listguests') }}">Guests</a></li>
                            <li><a href="{{ url('/registeruser') }}">Register</a></li>
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Notifications<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/listnotifications') }}">View All</a></li>
                                    <li><a href="{{ url('/listpending') }}">View Pending</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @elseif(Auth::user()->account_type == 2)
                            <li><a href="{{ url('/listprofiles') }}">Residents</a></li>
                            <li><a href="{{ url('/listreports') }}">Reports</a></li>
                            <li><a href="{{ url('/listguests') }}">Guests</a></li>
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Notifications<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/listnotifications') }}">View All</a></li>
                                    <li><a href="{{ url('/listpending') }}">View Pending</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('navbar')
        @yield('content')
    
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="{{ URL::asset('js/jquery-3.2.0.min.js') }}"></script>
    <!-- DateTime Scripts -->
    <script src="{{ URL::asset('js/main.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-timepicker.min.js') }}"></script>
    <!-- DataTable Scripts -->
    <script src="{{ URL::asset('datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('datatable/moment.js') }}"></script>

    <script src="{{ URL::asset('MDB/js/mdb.min.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function(){

        $('#dataTableV2').DataTable({
            "fixedHeader": true,
            "searching" : false,
            "lengthChange": false,
            "scrollY": "400px",
            "scrollCollapse": true,
            "info": false,
            "paging": false
        });

        $('table.datatable').DataTable({
            "searching" : false,
            "lengthChange": false
        });

        $('#datatableGuest').DataTable({
            "searching" : false,
            "lengthChange": false,
            "order": [[0, 'desc']]
        });

        $('#datatableNotif').DataTable({
            "searching" : false,
            "lengthChange": false,
            "order": [[0, 'desc']]
        });
        
        //Table ID for DataTable
        var table = $('#dateTableWithDateRange').DataTable();

        // Date range filter
        //$.fn.dataTable.ext.search.push(
        $.fn.dataTableExt.afnFiltering.push(

            function(settings, data, dataIndex) {

            //Start Date
            var startDate = $('#startDate').val();

            //End Date
            var endDate = $('#endDate').val();

            var created_at = data[3] || 0;

                if ((startDate == "" || endDate == "") || (moment(created_at).isSameOrAfter(startDate) && moment(created_at).isSameOrBefore(endDate))) 
                {
                    return true;
                } else {
                    return false;
                }
            }

        );
            
        //StartDate and EndDate class range            
        $('#startDate, #endDate').change(function() {
            table.draw();
        });

    });

</script>

<script type="text/javascript">
     $(document).ready(function(){
    var d = new Date();
    var mon;
    var day;
    var mer;
    if(d.getMonth() > 10){
        mon = d.getMonth() + 1;
    }else{
        mon = "0" + (d.getMonth() + 1);
    }
    if(d.getDate() > 10){
        day = d.getDate();
    }else{
        day = "0" + d.getDate();
    }
    if(d.getHours > 12){
        mer = "PM";
    }else{
        mer = "AM";
    }
    var now = mon + "/" + day + "/" + d.getFullYear();
    var hnow = d.getHours() + 1;
    var hin;

    $('#date_expected').datepicker({
        autoclose: true,
        startDate: '+0d'
    });
    $('#time_expected').timepicker({
        minuteStep: 1,
        defaultTime: (hnow) + ":" + d.getMinutes() + " " + mer
    }).on('changeTime.timepicker', function(e) {
        if((document.getElementById('date_expected').value) == now){
            if(e.time.meridian == "PM"){
                hin = e.time.hours + 12;
            }else{
                hin = e.time.hours;
            }
            if(hnow > hin){
                window.alert("Notifications must be made at least 30 minutes in advance");
            }else{
                return true;
            }
        }  
    });

    $('.datepicker').datepicker({
        autoclose:true
    })
});
</script>

@yield('pageJS')

<meta name="_token" content="{!! csrf_token() !!}" />

</body>
</html>
