<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class presellController extends Controller
{
    var $Api ;
    public function __construct()
    {
        $this->Api = new Api() ;
    }

    public function index(){
        $ProvinceList =  Cache::get('ProvinceList');
//        return $AccountList;
        return view("presellManagement" , ['ProvinceList' => $ProvinceList]) ;
    }

    public function GetAccountProvince(Request $request)
    {
        $province_id = $request->get("id");
        $AccountList = $this->Api->GetAccountProvince($province_id);
        return $AccountList ;
    }
    public function AccountList(Request $request)
    {
        $AccountList = $this->Api->AccountList(1,[0]);
        return $AccountList ;
    }
}
