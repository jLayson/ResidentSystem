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
    
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
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
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @else
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

<script type="text/javascript">

    $(document).ready(function(){

        $('#datatable').DataTable({
            "searching" : false
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

</body>
</html>
