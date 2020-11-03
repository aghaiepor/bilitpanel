<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class presellController extends Controller
{
    public function index(){
        return view("presellManagement") ;
    }
}
