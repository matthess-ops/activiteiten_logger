<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index(){
     error_log("dit werkt");
     return view('logs');
    }
}
