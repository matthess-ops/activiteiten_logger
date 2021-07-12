<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Config - Activiteiten logger</title>

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
                <a class="nav-item nav-link" href="{{ route('TimerData.readData') }}">Dashboard</a>          
                <a class="nav-item nav-link  active" href="{{ route('ConfigData.index') }}">Config</a>
                <a class="nav-item nav-link" href="{{ route('post.index') }}">Diary</a>
                <a class="nav-item nav-link" href="{{ route('Logs.index') }}">Logs</a>
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
        <div class="row">
            <div class="col-sm-6">

                <div class="card">
                    <div class="card-header">Create/Add options</div>
                    
                    <div class="card-body wrapper-add-options">
                        <div class="form-group row ">
                            <div class="col-12">
                                <h5>Add new option to group.</h5>
                            </div>
                        </div>
                        <form action='{{ route('ConfigData.store') }}' method="post">
                            @csrf

                            <div class="form-group row ">
                                <div class="wrapper-label">
                                    <label for="mainActivities" class="col-form-label">Main Activity:</label>
                                </div>
                                <div class="wrapper-select">
                                    <input type="text" class="form-control" id="mainActivities" name="mainActivities">
                                </div>

                                <div class="wrapper-button">
                                    <input class="btn btn-primary" type="submit" value="Add">
                                </div>
                            </div>

                        </form>
                        <form action='{{ route('ConfigData.store') }}' method="post">
                            @csrf


                            <div class="form-group row ">
                                <div class="wrapper-label">
                                    <label for="subActivities" class="col-form-label">Sub Activity:</label>
                                </div>
                                <div class="wrapper-select">
                                    <input type="text" class="form-control" id="subActivities" name="subActivities">
                                </div>

                                <div class="wrapper-button">
                                    <input class="btn btn-primary" type="submit" value="Add">
                                </div>
                            </div>
                        </form>
                        <form action='{{ route('ConfigData.store') }}' method="post">
                            @csrf
                            <div class="form-group row ">
                                <div class="wrapper-label">
                                    <label for="experiments" class="col-form-label">Experiment:</label>
                                </div>
                                <div class="wrapper-select">
                                    <input type="text" class="form-control" id="experiments" name="experiments">
                                </div>

                                <div class="wrapper-button">
                                    <input class="btn btn-primary" type="submit" value="Add">
                                </div>
                            </div>

                        </form>

                     

                      
                        {{-- add new options to an already existing fixed option --}}
                        @foreach ($fixedOptions as $key => $value)

                            <form action='{{route('ConfigData.storeFixed')}}' method="post">
                                @csrf
                                <div class="form-group row ">
                                    <div class="wrapper-label">
                                        <label for="{{ $key }}"
                                            class="col-form-label">{{ $key }}:</label>
                                    </div>
                                    <div class="wrapper-select">
                                        <input type="text" class="form-control" id="{{ $key }}"
                                            name="{{ $key }}">
                                    </div>

                                    <div class="wrapper-button">
                                        <input class="btn btn-primary" type="submit" value="Add">
                                    </div>
                                </div>

                            </form>

                        @endforeach

                        <div class="form-group row ">
                            <div class="col-12">
                                <h5>Create new scaled group.</h5>
                            </div>
                        </div>

                        {{-- scaled options piece --}}
                        <form action='{{route('ConfigData.storeScaled')}}' method="post">
                            @csrf
                            <div class="form-group row ">
                                <div class="wrapper-label">
                                    <label for="scaledOptions" class="col-form-label">Scaled option:</label>
                                </div>
                                <div class="wrapper-select">
                                    <input type="text" class="form-control" id="scaledOptions" name="scaledOptions">
                                </div>

                                <div class="wrapper-button">
                                    <input class="btn btn-primary" type="submit" value="Create">
                                </div>
                            </div>

                        </form>

                      

                        {{-- add new group to fixed options --}}

                        <div class="form-group row ">
                            <div class="col-12">
                                <h5>Create new group plus options.</h5>
                            </div>
                        </div>

                            <form action='{{route('ConfigData.createNewFixed')}}' method="post">
                                @csrf
                                <div class="form-group row ">
                                    <div class="wrapper-label">
                                        <label for="fixedOptions" class="col-form-label">Group name:</label>
                                    </div>
                                    <div class="wrapper-select">
                                        <input type="text" class="form-control" id="fixedOptions" name="fixedOptions">
                                    </div>
                                    <div class="wrapper-button">
                                        <input class="btn btn-primary" type="submit" value="Create">
                                    </div>


                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        
                                        <input type="text" class="form-control" id="1" name="1" placeholder="Option 1.">
                                    </div>       
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="2" name="2" placeholder="Option 2.">
                                    </div>  
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="3" name="3" placeholder="Option 3.">
                                    </div> 
                                
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        
                                        <input type="text" class="form-control" id="4" name="4" placeholder="Option 4.">
                                    </div>       
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="5" name="5" placeholder="Option 5.">
                                    </div>  
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="6" name="6" placeholder="Option 6.">
                                    </div> 
                                
                                </div>
                            </form>











                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">Remove Options</div>
                        <div class="card-body">
                            <div class="form-group row ">
                                <div class="col-12">
                                    <h5>Remove group option</h5>
                                </div>
                            </div>

                            {{-- main activities remove option --}}
                            <form action='' method="post">
                                @csrf
    
                                <div class="form-group row ">
                                    <div class="wrapper-label">
                                        <label for="mainActivities" class="col-form-label">Main Activity:</label>
                                    </div>
                                    <div class="wrapper-select">
                                        <select class="form-control" name="mainActivities" id="mainActivities">
                                            @foreach ($mainActivities as $mainActivity)
                                            
                                                    <option value="{{ $mainActivity }}">{{ $mainActivity }}
                                                    </option>
                                            @endforeach
    
                                        </select>                                    </div>
    
                                    <div class="wrapper-button">
                                        <input class="btn btn-primary" type="submit" value="Remove">
                                    </div>
                                </div>
    
                            </form>

                             {{-- sub activities remove option --}}
                             <form action='' method="post">
                                @csrf
    
                                <div class="form-group row ">
                                    <div class="wrapper-label">
                                        <label for="subActivities" class="col-form-label">Sub Activity:</label>
                                    </div>
                                    <div class="wrapper-select">
                                        <select class="form-control" name="subActivities" id="subActivities">
                                            @foreach ($subActivities as $subActivity)
                                            
                                                    <option value="{{ $subActivity }}">{{ $subActivity }}
                                                    </option>
                                            @endforeach
    
                                        </select>                                    </div>
    
                                    <div class="wrapper-button">
                                        <input class="btn btn-primary" type="submit" value="Remove">
                                    </div>
                                </div>
    
                            </form>


                                       {{-- experiments remove option --}}
                                       <form action='' method="post">
                                        @csrf
            
                                        <div class="form-group row ">
                                            <div class="wrapper-label">
                                                <label for="experiments" class="col-form-label">Experiment:</label>
                                            </div>
                                            <div class="wrapper-select">
                                                <select class="form-control" name="experiments" id="experiments">
                                                    @foreach ($experiments as $experiment)
                                                    
                                                            <option value="{{ $experiment }}">{{ $experiment }}
                                                            </option>
                                                    @endforeach
            
                                                </select>                                    </div>
            
                                            <div class="wrapper-button">
                                                <input class="btn btn-primary" type="submit" value="Remove">
                                            </div>
                                        </div>
            
                                    </form>

                                    <div class="form-group row ">
                                        <div class="col-12">
                                            <h5>Remove option/group</h5>
                                        </div>
                                    </div>


                                     {{-- fixed options remove option --}}
                                     @foreach ($fixedOptions as $key => $values )
                                     <form action='{{route('ConfigData.removeFixedGroupOrOption')}}' method="post">
                                        @csrf
            
                                        <div class="form-group row ">
                                            <div class="col-3">
                                                <label for="{{$key}}" class="col-form-label">{{$key}}:</label>
                                            </div>
                                            <div class="col-5">
                                                <select class="form-control" name="{{$key}}" id="{{$key}}">
                                                    @foreach ($values as $value)
                                                    
                                                            <option value="{{ $value }}">{{ $value }}
                                                            </option>
                                                    @endforeach
            
                                                </select>                                    </div>
            
                                            <div class="col-sm-4">
                                                <input class="btn btn-secondary" type="submit" name="Remove_Option" value="Rem_opt">
                                            
                                                <input class="btn btn-primary" type="submit" name="Remove_Group" value="Rem_group">

                                            </div>

                                            {{-- <div class="col-sm-2">
                                            </div> --}}
                                        </div>
            
                                    </form>
                                    
                                    @endforeach


                                   @foreach ($scaledOptions as $scaledOption )
                                   <form action='{{route('ConfigData.removeScaledOption')}}' method="post">
                                    @csrf
                                    <div class="form-group row ">
                                        <div class="col-3">
                                            <label for="{{$scaledOption}}" class="col-form-label">{{$scaledOption}}:</label>
                                        </div>
                                        <div class="col-5">

                                            <input name="scaledOptions" type="hidden" value="{{$scaledOption}}">

                                                       </div>
        
                                        <div class="col-2">
                                            <input type="hidden" value="{{$scaledOption}}" name="user_id">
                                            <input name="iknietsnap" type="hidden" value="{{$scaledOption}}">

                                            <input class="btn btn-primary" type="submit" name="{{$scaledOption}}" value="Remove">
                                        </div>

                                    
                                    </div>
                                </form>



                                   @endforeach




                            

                        </div>
                    </div>
                </div>
            </div>



        </div>




</body>

</html>
