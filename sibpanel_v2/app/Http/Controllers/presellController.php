<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Hekmatinasser\Verta\Verta;
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
//        return $ProvinceList[0];
        return view("presellManagement" , ['ProvinceList' => $ProvinceList]) ;
    }
    public function transaction(Request $request , $id=null , $province_id=null){
        if(is_null($id) || is_null($province_id) )
            return redirect()->back();

        $page = $request->get("page") ;
        if(is_null($page)){
            $page = 1 ;
        }
        $account_id = $id;
        $trace_number = "";
        $GetChargeTransaction = $this->Api->GetChargeTransaction($page ,$account_id, $trace_number) ;
        $GetDechargeTransaction = $this->Api->GetDechargeTransaction($page ,$account_id, $trace_number) ;
//        return $GetChargeTransaction;
//          return $GetDechargeTransaction ;
        if(count($GetDechargeTransaction["ContentData"]) != 0 )
            $total_buy = $GetDechargeTransaction["ContentData"]["total_amount"];
        else
            $total_buy = 0 ;

        if(count($GetChargeTransaction["ContentData"]) != 0)
            $total_amount = $GetChargeTransaction["ContentData"]["total_amount"];
        else
            $total_amount = 0 ;

        $GetChargeTransaction =  $GetChargeTransaction["ContentData"] ;
//        return $GetChargeTransaction;

        $AccountList = $this->Api->GetAccountProvince($province_id);
        $province_name = $AccountList["ContentData"]["province_name"];
        $AccountList = array_filter($AccountList["ContentData"]["location_accounts"], function ($event) use ($id) {
            return $event['account_id'] == $id;
        });
        $array_keys = array_keys($AccountList) ;
        $Account = $AccountList[$array_keys[0]];

//        dd($this->Api->GetChargeDocument(8));

        return view("presell_transaciton"  , ["transactions" => $GetChargeTransaction  , "Account" =>$Account , "province_name" => $province_name , "total_amount" =>$total_amount , "total_buy"=>$total_buy]);

    }
    public function GetDechargeTransaction(Request $request){
        $page = $request->get("page") ;
        $account_id = $request->get("account_id");
        $trace_number = "";
        $GetChargeTransaction = $this->Api->GetDechargeTransaction($page ,$account_id, $trace_number) ;
        $GetChargeTransaction =  $GetChargeTransaction["ContentData"]["log"] ;
        return $GetChargeTransaction ;

    }
    public function GetChargeTransaction(Request $request){
        $page = $request->get("page") ;
        $account_id = $request->get("account_id");
        $trace_number = "";
        $GetChargeTransaction = $this->Api->GetChargeTransaction($page ,$account_id, $trace_number) ;
        $GetChargeTransaction =  $GetChargeTransaction["ContentData"]["log"] ;
        return $GetChargeTransaction ;

    }
    public function ChargeAccount(Request $request , $id){
        if(is_null($id))
            return  redirect()->back()->with("error" , "خطا در شارژ حساب ! ");

        $charge_amount = $request->get("charge_amount");
        $account_id = $id;
        $project_name = "TourismSystem";
        $reference_number = $request->get("reference_number");
        $source_bank = $request->get("source_bank");
        $payment_datetime = $request->get("payment_datetime") ;
        $payment_datetime = explode("/" , $this->fa2en($payment_datetime)) ;
        $payment_datetime = Verta::getGregorian($payment_datetime[0],$payment_datetime[1],$payment_datetime[2]);
        $payment_datetime =  $payment_datetime[0] . "-" . $payment_datetime[1] . "-" . $payment_datetime[2];
        $description = $request->get("description");
        if($request->hasFile("pic_str")){
            $image = base64_encode(file_get_contents($request->file('pic_str')->path()));
            $pic_str = $image;
//            return $image;
        }
        else
            return  redirect()->back()->with("error" , "مستندات واریزی بارگزاری نشده است ! ");

        $ChargeAccount = $this->Api->ChargeAccount($charge_amount ,$account_id, $project_name , $reference_number , $source_bank , $payment_datetime , $pic_str,$description);
//        return $ChargeAccount ;
        if($ChargeAccount["Header"]["Status"] == 0 ) {
            return  redirect()->back()->with("success" , "شارژ با موقیت انجام گردید  .");
        }else
            return  redirect()->back()->with("error" , "خطا در شارژ حساب ! ");

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
    public function LocationAccountActivation(Request $request )
    {
        $locationaccount_id = $request->get("id") ;
        $activation = ($request->get("activation") == 'true') ? True : False;
        $LocationAccountActivation = $this->Api->LocationAccountActivation($locationaccount_id  ,$activation);
        return $LocationAccountActivation;
    }


    private function fa2en($number){
        return strtr($number, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
    }
}

