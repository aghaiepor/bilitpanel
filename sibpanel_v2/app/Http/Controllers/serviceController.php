<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Http\Request;

class serviceController extends Controller
{
    var $api = null ;

    public function __construct()
    {
        $this->api = new Api();
    }
}
