<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class presellController extends Controller
{
    var $Api ;
    public function __construct()
    {
        $this->Api = new Api() ;
    }

    public function indexPage(){
        $ProvinceList =  Cache::get('ProvinceList');
        return $ProvinceList;
        return view("presellManagement" , ['ProvinceList' => $ProvinceList]) ;
    }
    public function transaction(Request $request , $id=null , $province_id=null){
        if(is_null($id) || is_null($province_id) )
            return redirect()->route("presellManger");

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

//        return $Account ;
//        dd($this->Api->GetChargeDocument(8));

        return view("presell_transaciton"  , ["transactions" => $GetChargeTransaction  , "Account" =>$Account , "province_name" => $province_name , "total_amount" =>$total_amount , "total_buy"=>$total_buy]);

    }
    public function GetDechargeTransaction(Request $request){
        $page = $request->get("page") ;
        $account_id = $request->get("account_id");
        $trace_number = "";
        $GetChargeTransaction = $this->Api->GetDechargeTransaction($page ,$account_id, $trace_number) ;
        $GetChargeTransactions =  $GetChargeTransaction["ContentData"]["log"] ;
        $images_url = [] ;

//        foreach ($GetChargeTransactions as $GetChargeTransaction){
//            $url = 0 ;
//            if( is_null($GetChargeTransaction["picture_id"]) ||  $GetChargeTransaction["picture_id"] === null ) {
//                array_push($images_url , $url);
//            }else
//                $url = $this->Api->GetDocumentAddress($GetChargeTransaction["picture_id"]);
//                array_push($images_url , $url);
//        }
        $data = [
            "GetChargeTransactions" => $GetChargeTransactions ,
            "images_url" => $images_url ,
        ] ;
        return $data;

    }
    public function GetChargeTransaction(Request $request){
        $page = $request->get("page") ;
        $account_id = $request->get("account_id");
        $trace_number = "";
        $GetChargeTransaction = $this->Api->GetChargeTransaction($page ,$account_id, $trace_number) ;
        $GetChargeTransactions =  $GetChargeTransaction["ContentData"]["log"] ;
        $images_url = [] ;
        foreach ($GetChargeTransactions as $GetChargeTransaction)
        {
            $url = 0 ;
            if( is_null($GetChargeTransaction["picture_id"]) ||  $GetChargeTransaction["picture_id"] === null ) {
                array_push($images_url , $url);
            }else
                $url = $this->Api->GetDocumentAddress($GetChargeTransaction["picture_id"]);
            array_push($images_url , $url);
        }
        $data = [
            "GetChargeTransactions" => $GetChargeTransactions ,
            "images_url" => $images_url ,
        ] ;
        return $data;
    }
    public function GetTransactionFilter(Request $request){
        $type = $request->get("type");
        $page = $request->get("page") ;
        $account_id = $request->get("account_id");
        $trace_number = $request->get("trace_number");
        if(is_null($trace_number))
            $trace_number = "" ;
        $reference_number = $request->get("reference_number");
        if(is_null($reference_number))
            $reference_number = "" ;
        $ToDate = $request->get("ToDate");
//        return $ToDate ;
        $FromDate = $request->get("FromDate");
        if(is_null($ToDate) && is_null($FromDate) )
            $date = ["",""] ;
        else{
            if ($FromDate !='')
                $FromDate = Verta::parse($this->fa2en($FromDate).' 00:00:00')->timestamp ;
            if($ToDate != "")
                $ToDate = Verta::parse($this->fa2en($ToDate).' 00:00:00')->timestamp ;

            $date = [(string)$FromDate , (string)$ToDate ];
        }
//        return $date;
        $images_url = [] ;
        if($type == "charge"){
            $GetChargeTransaction = $this->Api->GetChargeTransaction($page ,$account_id, $trace_number , $reference_number , $date , "ajax" ) ;
            $total_pages = $GetChargeTransaction["ContentData"]["total_pages"] ;
            $GetChargeTransactions =  $GetChargeTransaction["ContentData"]["log"] ;
            foreach ($GetChargeTransactions as $GetChargeTransaction)
            {
                $url = 0 ;
                if( is_null($GetChargeTransaction["picture_id"]) ||  $GetChargeTransaction["picture_id"] === null ) {
                    array_push($images_url , $url);
                }else{
                    $url = $this->Api->GetDocumentAddress($GetChargeTransaction["picture_id"]);
                    array_push($images_url , $url);
                }
            }
        }
        else{
            $GetChargeTransaction = $this->Api->GetDechargeTransaction($page ,$account_id, $trace_number , $reference_number , $date , "ajax") ;
            $total_pages = $GetChargeTransaction["ContentData"]["total_pages"] ;
            $GetChargeTransactions =  $GetChargeTransaction["ContentData"]["log"] ;
        }
//        return $GetChargeTransaction ;

        $data = [
            "GetChargeTransactions" => $GetChargeTransactions ,
            "images_url" => $images_url ,
            "total_pages" => $total_pages ,
        ] ;
        return $data;
    }

    public function GetTransaction(Request $request){
        $page = $request->get("page") ;
        $account_id = $request->get("account_id");
        $trace_number = $request->get("trace_number");
        $trancation_type = $request->get("type");
        $images_url = [] ;
        if($trancation_type == "charge"){
            $GetTransaction = $this->Api->GetChargeTransaction($page ,$account_id, $trace_number  ,"","","ajax") ;
            $GetTransactions =  $GetTransaction["ContentData"]["log"] ;
            foreach ($GetTransactions as $GetTransactions)
            {
                $url = 0 ;
                if( is_null($GetTransactions["picture_id"]) ||  $GetTransactions["picture_id"] === null ) {
                    array_push($images_url , $url);
                }else
                    $url = $this->Api->GetDocumentAddress($GetTransactions["picture_id"]);
                array_push($images_url , $url);
            }
        }
        else{
            $GetTransaction = $this->Api->GetDechargeTransaction($page ,$account_id, $trace_number,"","", "ajax") ;
            $GetTransactions =  $GetTransaction["ContentData"]["log"] ;
        }
        $payment_datetime = "-";
        if (array_key_exists( "description_json" ,$GetTransactions )) {
            if( count($GetTransactions["description_json"]) != 0 ){
                $payment_datetime = $GetTransactions["description_json"]["payment_datetime"] ;
                $payment_datetime = Carbon::parse($payment_datetime)->timestamp;
                $payment_datetime = new Verta($payment_datetime);
                $payment_datetime =$payment_datetime->formatDatetime();
            }
        }

        Log::info($payment_datetime);

        $data = [
            "GetChargeTransactions" => $GetTransactions ,
            "images_url" => $images_url ,
            "payment_datetime" => $payment_datetime ,
        ] ;
        return $data;

    }
    public function ChargeAccount(Request $request , $id){
        if(is_null($id))
            return  redirect()->back()->with("error" , "خطا در شارژ حساب ! ");

        $charge_amount = $request->get("charge_amount");
        $account_id = $id;
        $project_name = "TourismSystem";
        $reference_number = $this->fa2en($request->get("reference_number"));
//        return $reference_number ;
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

