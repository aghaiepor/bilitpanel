<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OffController extends Controller
{
    var  $api ;
    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(){
        $Project_list = Cache::get('ProjectList');
        $locations = Cache::get('LocationList') ;
        $ServiceList = Cache::get('ServiceList') ;
//        $VoucherTypeList = Cache::get('VoucherTypeList');
//        $VoucherTypeList = $this->api->VoucherInfoList();
        $SellerUserList = Cache::get('SellerUserList');
//        return $GetSibUser ;
//        return $SellerUserList ;
        $SellerUserList = array_filter($SellerUserList, function ($event) {
            return $event['type'] == "b2b user";
        });
        $array_keys = array_keys($SellerUserList) ;
        $service_pics = [];
//        return $SellerUserList ;
        return view('off' , ["ProjectList" => $Project_list , "locations" => $locations ,
            "ServiceList" => $ServiceList , "SellerUserList" => $SellerUserList] ) ;
    }
    public function AddDiscountPolicy(Request $request){
        $project_id = (int)$request->get("project_id") ;
        $location_id = (int)$request->get("location_id") ;
        $service_id = (int)$request->get("service_id" ) ;
        $voucher_info_id = (int)$request->get("voucher_info_id" ) ;
        $sib_user_id = (int)$request->get("sib_user_id") ;
        $description = $request->get("description") ;
        $percentage = (int)$request->get("percentage") ;
        if(is_null($percentage))
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف : لطفا درصد تخفیف را وارد نمایید .  ");

        if($project_id == 0 && $location_id == 0 && $service_id == 0 && $voucher_info_id == 0 && $sib_user_id ==0  ){
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف : پرکردن حداقل یکی از فیلد ها الزامیست .  ");
        }

        $AddDiscountPolicy = $this->api->AddDiscountPolicy($project_id ,$location_id ,$service_id , $voucher_info_id ,$sib_user_id ,$description ,$percentage);
//        return $AddDiscountPolicy;
        if($AddDiscountPolicy["Header"]["Status"] == 0 )
            return redirect()->back()->with("success" , " تخفیف مورد نظر ایجاد گردید ");
        else if($AddDiscountPolicy["Header"]["Message"] == "Permission Denied")
            return redirect()->back()->with("error" , "منع دسترسی : شما مجاز به انجام چنین عملیاتی نیستید !   ");
        else
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف !  ");

    }
    public function GetDiscountPolicyList(Request $request){

        $project_id = (int)$request->get("project_id") ;
        $location_id = (int)$request->get("location_id") ;
        $service_id = (int)$request->get("service_id" ) ;
        $voucher_info_id = (int)$request->get("voucher_info_id" ) ;
        $sib_user_id = (int)$request->get("sib_user_id") ;


        $GetDiscountPolicyList = $this->api->GetDiscountPolicyList($project_id ,$location_id ,$service_id , $voucher_info_id ,$sib_user_id , "ajax") ;
        return $GetDiscountPolicyList;
    }
    public function GetSibUser(Request $request)
    {
        $id = $request->get("id") ;
        $userInfo = $this->api->GetSibUser($id , "ajax");
        return $userInfo ;
    }
    public function EditDiscountPolicy(Request $request , $id){
//        return json_encode($request->all());
        if(is_null($id))
            return redirect()->back();

        $discount_policy_id = (int)$id;
        $active = (($request->get("active") == "true") ? true : false) ;
        $description = $request->get("description");
        if(is_null($description))
            $description = "";
        $percentage = (int)$request->get("percentage");

        $activation_date = $request->get("activation_date");
        $activation_date = $this->fa2en($activation_date);
        $activation_date = Verta::parse($activation_date)->timestamp;
        $activation_date = Carbon::createFromTimestamp($activation_date)->format('Y-m-d H:i');

        $expiration_date = $request->get("expiration_date") ;
        $expiration_date = $this->fa2en($expiration_date);
        $expiration_date = Verta::parse($expiration_date)->timestamp;
        $expiration_date = Carbon::createFromTimestamp($expiration_date)->format('Y-m-d H:i');

        $EditDiscountPolicy = $this->api->EditDiscountPolicy($discount_policy_id ,$active ,$description ,$percentage , $activation_date , $expiration_date );
//        return $EditDiscountPolicy;
        if($EditDiscountPolicy["Header"]["Status"] == 0 ){
            return redirect()->back()->with("success" , " ویرایش تخفیف انجام شد .  ");
        }else if ($EditDiscountPolicy["Header"]["MessageCode"] == 158 ) {
            return redirect()->back()->with("error" , " خطا : تاریخ نامعتبر است  ! ");
        }
        else
            return redirect()->back()->with("error" , " خطا در ویرایش تخفیف ! ");
    }
    public function GetDiscountPolicy(Request $request){
        $discount_policy_id = $request->get("id");
        $GetDiscountPolicy = $this->api->GetDiscountPolicy($discount_policy_id , "ajax") ;
        return $GetDiscountPolicy;

    }
    public function DiscountPolicyActivation(Request $request ){
        $discount_policy_id = (int)$request->get("id");
        $active = (($request->get("active") == "true") ? true : false) ;
        $EditDiscountPolicy = $this->api->DiscountPolicyActivation($discount_policy_id ,$active );
        return $EditDiscountPolicy;
    }
//    public function VoucherTypeList(Request $request)
//    {
//        $id = $request->get("id") ;
//        $userInfo = $this->api->VoucherTypeList($id , "ajax");
//        return $userInfo ;
//    }
    private function fa2en($number){
        return strtr($number, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
    }
}
