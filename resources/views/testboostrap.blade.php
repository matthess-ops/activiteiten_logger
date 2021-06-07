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

    <div class="container-fluid" style="max-width: 1600px">
        <div class="card">
            <div class="card-header">Header</div>
            <div class="card-body">
                <div class="row">
                    <div class=" bg-success wrapper-lef-column">

                        <form action="{{ route('data.storeNewSelection') }}" method="POST">
                            @csrf

                            <div class="wrapper-timer row">
                                <div class="col-4">
                                    <h1>00:00</h1>

                                </div>
                                <div class="col-8">
                                    <input class="btn btn-primary"  type="submit" value="start">


                                </div>
                            </div>

                            <div class="wrapper-selections">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="mainActivitiesSelect">Main Activity</label>

                                    </div>
                                    <div class="col-8">
                                        <select class="form-select " aria-label="Default select example"
                                            id="mainActivitiesSelect" name="mainActivities">
                                            @foreach ($mainActivities as $mainActivity)
                                                @if ($currentSelections['mainActivities'] == $mainActivity)
                                                    <option value={{ $mainActivity }} selected>{{ $mainActivity }}
                                                    </option>

                                                @else
                                                    <option value={{ $mainActivity }}>{{ $mainActivity }}</option>

                                                @endif
                                            @endforeach
                                        </select>
                                    </div>


                                </div>


                                <div class="row">
                                    <div class="col-4">
                                        <label for="subActivitiesSelect">Sub Activity</label>

                                    </div>
                                    <div class="col-8">
                                        <select class="form-select" aria-label="Default select example"
                                            id="subActivitiesSelect" name="subActivities">
                                            @foreach ($subActivities as $subActivity)
                                                @if ($currentSelections['subActivities'] == $subActivity)
                                                    <option value={{ $subActivity }} selected>{{ $subActivity }}
                                                    </option>

                                                @else
                                                    <option value={{ $subActivity }}>{{ $subActivity }}</option>

                                                @endif
                                            @endforeach
                                        </select>
                                    </div>


                                </div>

                                @foreach ($scaledOptions as $scaledOption)
                                    <div class="row">
                                        <div class="col-4">

                                            <label for={{ $scaledOption }}>{{ $scaledOption }}</label>
                                        </div>
                                        <div class="col-8">

                                            <select class="form-select" aria-label="Default select example"
                                                id={{ $scaledOption }} name={{ str_replace(" ", "-", $scaledOption) }}>
                                                @for ($i = 1; $i < 10; $i++)
                                                    @if ($i == $currentSelections[$scaledOption]) <option value={{ $i }}
                                                    selected>{{ $i }}</option>

                                                @else
                                                    <option value={{ $i }}
                                                    >{{ $i }}</option> @endif
                                                @endfor


                                            </select>

                                        </div>
                                    </div>

                                @endforeach


                                @foreach ($fixedOptions as $key => $values)
                                    <div class="row">

                                        <div class="col-4">

                                            <label for={{ $key }}>{{ $key }}</label>
                                        </div>

                                        <div class="col-8">

                                            <select class="form-select" aria-label="Default select example"
                                                id={{ $key }} name={{ str_replace(" ", "-", $key) }}> 
                                                @foreach ($values as $value)
                                                    @if ($currentSelections[$key] == $value)
                                                        <option value={{ $value }} selected>{{ $value }}
                                                        </option>

                                                    @else
                                                        <option value={{ $value }}>{{ $value }}
                                                        </option>

                                                    @endif


                                                @endforeach
                                            </select>
                                        </div>


                                    </div>

                                @endforeach

                                <div class="row">

                                    <div class="col-4">

                                        <label for="Experiment">Experiment</label>
                                    </div>

                                    <div class="col-8">

                                        <select class="form-select" aria-label="Default select example" id="Experiment" name="experiments">

                                            @foreach ($experiments as $experiment)
                                                @if ($experiment == $currentSelections['experiments'])
                                                    <option value="{{$experiment }}" selected>{{ $experiment }}
                                                    </option>

                                                @else
                                                    <option value={{ $experiment }}>{{ $experiment }} </option>

                                                @endif




                                            @endforeach
                                        </select>
                                    </div>
                                </div>








                            </div>

                        </form>
                    </div>


                        <div class=" table-responsive col-sm-8 bg-primary">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        @foreach (array_keys($suggestions[0]) as $suggestion)
                                            <th scope="col">{{ $suggestion }} </th>

                                        @endforeach

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($suggestions as $suggestion)
                                    <br>
                                        <tr>
                                            @foreach (array_keys($suggestion) as $suggestionKey)
                                                <td>{{ $suggestion[$suggestionKey] }}</td>
                                            @endforeach
                                                @csrf
                                            <td>
                                                <form action="{{ route('data.store') }}" method="POST">
                                                    @csrf
                                                
                                                    <input type="hidden" name="suggestion" value={{str_replace(" ", "-", json_encode($suggestion,TRUE)) }}>
                                    
                                                    <input class="btn btn-primary"  type="submit" value="pick">
                                                    
                                                  </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <form action="{{ route('data.storeTest') }}" method="POST">
                            @csrf
                        
                            <input type="text" name="name" id="name" required>
                            <input type="hidden" name="suggestion" value="{{json_encode($suggestion,TRUE) }}">

                            <input class="btn btn-primary"  type="submit" value="lefuck">
                            
                          </form>


                       
                    </div>

                </div>





      


</body>

</html>
