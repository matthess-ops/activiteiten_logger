{{-- updates for next version --}}
{{--1: Main activities and sub Activities form group are structurally the same, thus an subview or blade component should be made to prevent code duplication  --}}
{{--2: On each blade the navbar is duplicated, make the navbar a layout and extend it into here --}}
{{--3: the 3 cards, timer, diary and statistics should be made as sections. To make the code in this file more managable--}}




<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard - Activiteiten logger</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">


    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="{{ asset('js/newview.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">


</head>

<body>

        {{-- view vars that are needed as js vars --}}

    <script>
        var startTimestampIn = @json($startTimestamp);
        var timerRunning = @json($timerRunning);
        var logs = @json($todayLogs);

    </script>
    {{-- dit hier laten als je dit verwijderd begint het dashboard te knipperen --}}
    {{-- {{ $timerRunning }} --}}


    <nav class="navbar navbar-expand-lg navbar-dark bg-primary center">
        <div class="container">

            <a class="navbar-brand" style="font-size: 2.0em" href="#">Activiteiten logger</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav " style="font-size: 1.6em">
                <a class="nav-item nav-link active" href="{{ route('TimerData.readData') }}">Dashboard</a>          
                <a class="nav-item nav-link" href="{{ route('ConfigData.index') }}">Config</a>
                <a class="nav-item nav-link" href="{{ route('post.index') }}">Diary</a>
                <a class="nav-item nav-link" href="{{ route('Logs.index') }}">Logs</a>
                <a class="nav-item nav-link" href="{{ route('logout') }}"
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

    <div class="row">


        <div class="container-fluid" style="max-width: 1600px">
            <div class="card">
                {{-- timer card --}}

                <div class="card-header">Timer</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <form action="{{ route('TimerData.startTimer') }}" method="post">
                                @csrf
                                {{-- Timer element and start and stop button --}}

                                <div class="form-group row d-flex justify-content-between">
                                    {{-- margin needs to be 10px else bootstrap will malfunction --}}
                                    
                                    <h3 style="margin: 0px" id="timer">00:00</h3>
                                    <div class="">
                                        @if ($timerRunning == true)
                                            <input class="btn btn-primary" type="submit" value="stoppen">

                                        @else
                                            <input class="btn btn-primary" type="submit" value="starten">

                                        @endif
                                    </div>
                                </div>

                                {{-- Main activities form group --}}

                                <div class="form-group row d-flex justify-content-between">
                                    <label for="mainActivities" class="col-form-label">Main Activity</label>
                                    <div class="">
                                        <select class="form-control" name="mainActivities" id="mainActivities">
                                            @foreach ($mainActivities as $mainActivity)
                                                @if ($currentSelections['mainActivities'] == $mainActivity)
                                                    <option value="{{ $mainActivity }}" selected>
                                                        {{ $mainActivity }}
                                                    </option>
                                                @else
                                                    <option value="{{ $mainActivity }}">{{ $mainActivity }}
                                                    </option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                {{-- Sub activities form group --}}

                                <div class="form-group row d-flex justify-content-between">
                                    <label for="subActivities" class="col-form-label">Sub Activity</label>
                                    <div class="">
                                        <select class="form-control" name="subActivities" id="subActivities">
                                            @foreach ($subActivities as $subActivity)
                                                @if ($currentSelections['subActivities'] == $subActivity)
                                                    <option value="{{ $subActivity }}" selected>{{ $subActivity }}
                                                    </option>
                                                @else
                                                    <option value="{{ $subActivity }}">{{ $subActivity }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- experiment form group --}}

                                <div class="form-group row d-flex justify-content-between">
                                    <label for="experiments" class="col-form-label">Experiment</label>
                                    <div class="">
                                        <select class="form-control" name="experiments" id="experiments">
                                            @foreach ($experiments as $experiment)
                                                @if ($currentSelections['experiments'] == $experiment)
                                                    <option value="{{ $experiment }}" selected>{{ $experiment }}
                                                    </option>
                                                @else
                                                    <option value="{{ $experiment }}">{{ $experiment }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- scaled options form group --}}

                                @foreach ($scaledOptions as $scaledOption)

                                    <div class="form-group row d-flex justify-content-between">
                                        <label for="{{ $scaledOption }}"
                                            class="col-form-label">{{ $scaledOption }}</label>
                                        <div class="">
                                            <select class="form-control" name="{{ $scaledOption }}"
                                                id="{{ $scaledOption }}">

                                                @if (array_key_exists($scaledOption, $currentSelections) == true)
                                                    @for ($i = 1; $i < 10; $i++) {{-- i is 10 because the scale is from 0-10 --}}


                                                        @if ($i ==
                                                        $currentSelections[$scaledOption]) <option {{-- blade code to select the previous selected scale value 0 -10 --}}

                                                        value="{{ $i }}"
                                                        selected>{{ $i }}</option>

                                                    @else
                                                        <option
                                                        value="{{ $i }}">{{ $i }}</option> @endif
                                                    @endfor
                                                @else   {{-- there could be an exception here, if a new scaled value doenst have a previous scale value. This means there would be no value pre selected this could cause problems when the form is submitted without the user selecting a value  --}}

                                                    @for ($i = 1; $i < 10; $i++)
                                                        <option value="{{ $i }}">{{ $i }}
                                                        </option>

                                                    @endfor


                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                @endforeach


                                {{-- Fixed options form group --}}

                                @foreach ($fixedOptions as $key => $values)

                                    <div class="form-group row d-flex justify-content-between">
                                        <label for="{{ $key }}"
                                            class="col-form-label">{{ $key }}</label>
                                        <div class="">
                                            <select class="form-control" name="{{ $key }}"
                                                id="{{ $key }}">

                                                @if (array_key_exists($key, $currentSelections) == true)
                                                    @foreach ($values as $value)

                                                        @if ($currentSelections[$key] == $value)
                                                            <option value={{ $value }} selected>
                                                                {{ $value }}
                                                            </option>

                                                        @else
                                                            <option value={{ $value }}>{{ $value }}
                                                            </option>

                                                        @endif


                                                    @endforeach
                                                @else
                                                {{-- Same error as with scaled options form group could happen here --}}

                                                
                                                    @foreach ($values as $value)


                                                        <option value={{ $value }} selected>{{ $value }}
                                                        </option>

                                                    @endforeach
                                                @endif


                                            </select>
                                        </div>
                                    </div>

                                @endforeach


                            </form>
                        </div>

                        {{-- Activities suggestions table --}}

                        <div class="col-sm-8 ">
                        
                            <div class="table-responsive">

                                <table class="table float-left ">
                                    <thead>
                                        <tr>

                                            @foreach (array_keys($suggestions[0]) as $suggestion)
                                                <th scope="col">{{ $suggestion }} </th>

                                            @endforeach

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($suggestions as $suggestion)
                                            <tr>

                                                @foreach (array_keys($suggestion) as $suggestionKey)
                                                    <td>{{ $suggestion[$suggestionKey] }}</td>
                                                @endforeach
                                                @csrf
                                                <td>
                                                    <form action="{{ route('TimerData.updateSelection') }}"
                                                        method="POST">
                                                        @csrf

                                                        <input type="hidden" name="suggestion"
                                                            value="{{ json_encode($suggestion, true) }}">

                                                        <input class="btn btn-primary" type="submit" value="pick">

                                                    </form>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>

            </div>


        </div>
    </div>

    <div class="row mt-3">
        <div class="container-fluid" style="max-width: 1600px">
            <div class="row">
                <div class="col-sm-6 d-flex">
                  {{-- Diary card  --}}

                    <div class="card flex-fill ">
                        <div class="card-header">Diary</div>
                        <div class="card-body">
                            <form action="{{ route('Post.create') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="DiaryTitleInput">Titel</label>
                                    <textarea class="form-control" name="DiaryTitleInput" id="DiaryTitleInput"
                                        rows="1"></textarea>
                                    <label for="DiaryTextInput">Bericht</label>
                                    <textarea class="form-control" name="DiaryTextInput" id="DiaryTextInput"
                                        rows="8"></textarea>
                                    <input class="btn btn-primary" type="submit" value="opslaan">


                                </div>

                            </form>




                        </div>
                    </div>
                </div>

                <div class="col-sm-6 d-flex">{{-- Statistics card --}}
                    <div class="card flex-fill">
                        <div class="card-header">Statistics</div>
                        <div class="card-body ">
                            <div>
                                <canvas style="min-height: 100px" id="chart"></canvas>


                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>

</html>
