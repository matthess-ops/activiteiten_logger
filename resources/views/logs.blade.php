{{-- updates for next version --}}
{{--1: On each blade the navbar is duplicated, make the navbar a layout and extend it into here --}}
{{--2: a small problem is that the user can try to make a graph while no logs are selected, in next version the make graph button needs to be hidden/black/alert popup when there are not logs --}}
{{--3: The activity, fixed and scaled options are now only populated with their associatd mainActivities,subActivities options etc columns in the timer_data table
however. These options are not the same in time. Therefore if an option is removed, it wont be shown as a graphing option. While there might
be logs that have this value. This could be fixed by checking the selected logs for the different options
    --}}


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Logs - Activiteiten logger</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">


    <!-- Scripts -->
 
    <script src="{{ asset('js/logs.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">


</head>

<body>
        {{-- view vars that are needed as js vars --}}

    <script>
        var logss = @json($logss);
        var timerData = @json($timerData);
        var dates = @json($datesIn);

    </script>




    <nav class="navbar navbar-expand-lg navbar-dark bg-primary center">
        <div class="container">

            <a class="navbar-brand" style="font-size: 2.0em" href="#">Activiteiten logger</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav " style="font-size: 1.6em">
                    <a class="nav-item nav-link" href="{{ route('TimerData.readData') }}">Dashboard</a>          
                    <a class="nav-item nav-link" href="{{ route('ConfigData.index') }}">Config</a>
                    <a class="nav-item nav-link" href="{{ route('post.index') }}">Diary</a>
                    <a class="nav-item nav-link  active" href="{{ route('Logs.index') }}">Logs</a>
                    <a class="nav-item nav-link justify-content-end" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                     {{ __('Logout') }}
                 </a>

                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                 </form> 
                </div>
            </div>
        </div>

    </nav>

    <div class="container-fluid" style="max-width: 1600px">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Table</div>
                <div class="card-body">
                    <form action="{{ route('Logs.getLogs') }}" method="post">

                        @csrf
                        <div class="row mb-4">

                            <div class="col-sm-3">

                                <label for="start">Start date:</label>


                                <input id="startDate" type="date" value="2021-07-06" id="start" name="log-start">

                            </div>

                            <div class="col-sm-3">
                                <label for="end">End date:</label>
                                <input id="endDate" type="date" value="2021-07-09" id="end" name="log-end">
                            </div>

                            <div class="col-sm-3">
                                <input class="btn btn-primary" type="submit" value="get logs">

                            </div>

                            <div class="col-sm-3">
                                <label>Nr of Logs: {{ count($logss) }}</label>

                            </div>






                    </form>
                </div>


                <div class="row mb-4">
                    <div class="col-sm-12">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-primary">
                                <input type="radio" name="day" id="day"> day
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="week" id="week"> week
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="month" id="month"> month
                            </label>
                        </div>
                    </div>
                </div>








                <div class="row mb-4">
                    <div id="activityDiv" class="col-sm-4 ">
                        <div class="row">

                            <div class="form-group">
                                <label for="activityInput">Activity options</label>
                                <input class="btn btn-primary " type="button" name="activityInput" id="activityInput"
                                    type="submit" value="Add Activity">

                            </div>

                        </div>

                        <div class="row">
                            <div id="activityRows">

                            </div>
                        </div>




                    </div>
                    <div id="fixedDiv" class="col-sm-4 ">
                        <div class="row">
                            <div class="form-group ">
                                <label for="fixedInput">Fixed options</label>
                                <input class="btn btn-primary" type="button" name="fixedInput" id="fixedInput"
                                    type="submit" value="Add Fixed">
                            </div>
                        </div>

                        <div class="row">
                            <div id="fixedRows">

                            </div>
                        </div>



                    </div>
                    <div id="scaledDiv" class="col-sm-4">

                        <div class="row">
                            <div class="form-group">
                                <label for="scaledInput">Scaled options</label>
                                <input class="btn btn-primary float-sm-right" type="button" name="scaledInput"
                                    id="scaledInput" type="submit" value="Add Scaled">
                            </div>

                        </div>

                        <div class="row">
                            <div id="scaledRows">

                            </div>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <input id="make graph" class="btn btn-primary" type="button" value="make graph">
                    </div>
                </div>





            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">Graph</div>
            <div class="card-body">
                <div id="canvasDiv">
                    <canvas id="logsChart"></canvas>
                </div>

            </div>
        </div>
    </div>




    </div>




</body>

</html>
