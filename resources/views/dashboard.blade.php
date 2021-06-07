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
                    <a class="nav-item nav-link active" href="#">Dashboard <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="#">Diary</a>
                    <a class="nav-item nav-link" href="#">Logs</a>
                </div>
            </div>
        </div>

    </nav>
    {{-- {{var_dump($mainActivities)}} --}}
    <div class="row">
        
    <div class="container mt-5 " style="max-width: 80%;">
        <div class="card ">
            <div class="card-header bg-light font-weight-bold " style="font-size: 1.4em">
                Timer
            </div>
            <div class="card-body">
              




                {{-- main activities --}}

                <div class=" container float-left wrapper_activities">

                    <h1 style ="display: inline-block;">00:00</h1>
                    <button type="button" class="btn btn-primary ">Start</button>
                    <form action="" method="POST">


                        <label for="mainActivitiesSelect">Main Activity</label>
                        <select class="form-select " aria-label="Default select example" id="mainActivitiesSelect">
                            @foreach ($mainActivities as $mainActivity)
                                @if ($currentSelections['mainActivities'] == $mainActivity)
                                    <option value={{ $mainActivity }} selected>{{ $mainActivity }}</option>

                                @else
                                    <option value={{ $mainActivity }}>{{ $mainActivity }}</option>

                                @endif
                            @endforeach
                        </select>
                        <br>

                        <label for="subActivitiesSelect">Sub Activity</label>
                        <select class="form-select" aria-label="Default select example" id="subActivitiesSelect">
                            @foreach ($subActivities as $subActivity)
                                @if ($currentSelections['subActivities'] == $subActivity)
                                    <option value={{ $subActivity }} selected>{{ $subActivity }}</option>

                                @else
                                    <option value={{ $subActivity }}>{{ $subActivity }}</option>

                                @endif
                            @endforeach
                        </select>
                        <br>


                        @foreach ($scaledOptions as $scaledOption)
                            <label for={{ $scaledOption }}>{{ $scaledOption }}</label>
                            <select class="form-select" aria-label="Default select example" id={{ $scaledOption }}>
                                @for ($i = 1; $i < 10; $i++)
                                    @if ($i == $currentSelections[$scaledOption]) <option value={{ $i }}
                                    selected>{{ $i }}</option>

                                @else
                                    <option value={{ $i }} >{{ $i }}</option> @endif
                                @endfor


                            </select>

                            <br>

                        @endforeach


                        @foreach ($fixedOptions as $key => $values)

                            <label for={{ $key }}>{{ $key }}</label>
                            <select class="form-select" aria-label="Default select example" id={{ $key }}>
                                @foreach ($values as $value)
                                    @if ($currentSelections[$key] == $value)
                                        <option value={{ $value }} selected>{{ $value }} </option>

                                    @else
                                        <option value={{ $value }}>{{ $value }} </option>

                                    @endif


                                @endforeach
                            </select>


                            <br>
                        @endforeach


                        <label for="Experiment">Experiment</label>
                        <select class="form-select" aria-label="Default select example" id="Experiment">

                            @foreach ($experiments as $experiment)
                                @if ($experiment == $currentSelections['experiments'])
                                    <option value={{ $experiment }} selected>{{ $experiment }} </option>

                                @else
                                    <option value={{ $experiment }}>{{ $experiment }} </option>

                                @endif




                            @endforeach
                        </select>
                            <br>

                    </form>


                </div>

                
                  
                </div>
                <div class="wrapper_table_presets container row col-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>

                </div>






            </div>


       




        </div>
    </div>
    {{-- start dagboek sizzle --}}
    <div class="row">
        <div class="container mt-5 " style="max-width: 80%;">
        <div class="card ">
            <div class="card-header bg-light font-weight-bold " style="font-size: 1.4em">
                Dagboek
            </div>
            <div class="card-body">
                <h4>dagboek sizzle</h4>
            </div>
        </div>
    </div>
</div>



    </div>
    </div>
    </div>




 <h3>leufkcakdjflasdjfkljl</h3>
</body>

</html>
