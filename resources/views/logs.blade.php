<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">


</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary center">
        <div class="container">

            <a class="navbar-brand" style="font-size: 2.0em" href="#">Activiteiten logger</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav " style="font-size: 1.6em">
                    <a class="nav-item nav-link active" href="{{ route('TimerData.readData') }}">Dashboard <span
                            class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="{{ route('ConfigData.index') }}">Config</a>
                    <a class="nav-item nav-link" href="#">Diary</a>
                    <a class="nav-item nav-link" href="{{ route('Logs.index') }}">Logs</a>
                </div>
            </div>
        </div>

    </nav>

    <div class="container-fluid" style="max-width: 1600px">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Table</div>
                <div class="card-body">

                </div>
            </div>
        </div>


        </div>




</body>

</html>
