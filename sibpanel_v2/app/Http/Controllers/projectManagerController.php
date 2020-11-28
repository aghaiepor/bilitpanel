<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Http\Request;

class projectManagerController extends Controller
{
    var $api ;
    public function __construct()
    {
        $this->api = new Api;
    }

    public function index(){
        $GetProjectList = $this->api->GetProjectList();
        return $GetProjectList ;
        return view("ProjectManager" ,["GetProjectList" => $GetProjectList["ContentData"]]) ;
    }


}
