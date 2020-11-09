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
    public function SetAccountSetting(Request $request , $id=null)
    {
        if($id == null)
            return redirect()->back()->with("error" , "خطا در ويرايش تنظيمات .");

        $account_id = $id ;
        $average_balance_use = $request->get("average_balance_use") ;
        $red_percentage = $request->get("red_percentage");
        $green_percentage = $request->get("green_percentage");
        $orange_percentage = $request->get("orange_percentage") ;
        $yellow_percentage  = $request->get("yellow_percentage");
        $AccountList = $this->Api->SetAccountSetting($account_id ,$average_balance_use , $red_percentage ,$orange_percentage , $yellow_percentage , $green_percentage);
        if($AccountList["Header"]["Status"] == 0 ){
            return redirect()->back()->with("success" , " ويرايش تنظيمات انجام گرديد . ");
        }
        else {
            return redirect()->back()->with("error" , "خطا در ويرايش تنظيمات .");
        }
    }
}
