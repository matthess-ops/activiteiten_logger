{{-- updates for next version --}}
{{--1: On each blade the navbar is duplicated, make the navbar a layout and extend it into here --}}





<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Diary - Activiteiten logger</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">


    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

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
                    <a class="nav-item nav-link" href="{{ route('ConfigData.index') }}">Config</a>
                    <a class="nav-item nav-link  active" href="{{ route('post.index') }}">Diary</a>
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
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Posts</div>
                <div class="card-body">
                @foreach ($postData as $item)
                    
                <div class="card mt-4">
                    <div class="card-header">{{$item->title." :".$item->created_at}}</div>
                    <div class="card-body">
                        <form action="{{ route('post.saveDelete') }}" method="POST">
                            @csrf

                        <div class="form-group mb-0">
                            <textarea name="post_text" class="form-control mb-3" id="post_text" >{{$item->post}}</textarea>
                            <input type="hidden" value="{{$item->id}}" name="id">
                            <input name="ButtonState" id="Delete" class="btn btn-primary" type="submit" value="Delete">
                            <input name="ButtonState" id="Save" class="btn btn-primary" type="submit" value="Save">
                        </div>
                        </form>




                  
                </div>
            </div>

                @endforeach

                   {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {!! $postData->links() !!}
                </div>

             

            </div>
        </div>
    </div>






</body>

</html>
