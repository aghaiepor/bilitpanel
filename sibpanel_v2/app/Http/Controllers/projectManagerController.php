<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class projectManagerController extends Controller
{
    public function index(){
        return view("ProjectManager") ;
    }
}
